<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionViewController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'daily');
        $query = Transaction::query();

        $now = Carbon::now();

        if ($filter === 'daily') {
            $query->whereDate('transaction_date', $now);
        } elseif ($filter === 'weekly') {
            $query->whereBetween('transaction_date', [(clone $now)->startOfWeek(), (clone $now)->endOfWeek()]);
        } elseif ($filter === 'monthly') {
            $query->whereMonth('transaction_date', $now->month)
                  ->whereYear('transaction_date', $now->year);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15);

        $income = (clone $query)->where('type', 'income')->sum('amount');
        $expense = (clone $query)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        return view('transactions.index', compact('transactions', 'filter', 'income', 'expense', 'balance'));
    }

    public function create(Request $request)
    {
        $categories = ['Uy', 'Transport', 'Oziq-ovqat', 'Daromad', 'Boshqa'];
        $type = $request->query('type', 'income');
        return view('transactions.create', compact('type', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:income,expense',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:1000000000000000073575873847711249839757606215217745679924585790135175914380219020205067965615308.00',
            'description' => 'nullable|string|max:1000',
            'transaction_date' => 'required|date',
        ]);

        Transaction::create($data);

        return redirect()->route('transactions.index')->with('success', 'Transaction muvaffaqiyatli qo‘shildi!');
    }
}
