<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
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

        return response()->json([
            'transactions' => $transactions->items(),   // sahifadagi transaksiyalar
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page'    => $transactions->lastPage(),
                'per_page'     => $transactions->perPage(),
                'total'        => $transactions->total(),
            ],
            'filter'  => $filter,
            'income'  => $income,
            'expense' => $expense,
            'balance' => $balance,
        ]);
    }

    public function create(Request $request)
    {
        $categories = ['Uy', 'Transport', 'Oziq-ovqat', 'Daromad', 'Boshqa'];
        $type = $request->query('type', 'income');
        // API da ko‘pincha create faqat kategoriyalar va tip uchun json qaytariladi
        return response()->json([
            'type'       => $type,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'             => 'required|in:income,expense',
            'name'             => 'required|string|max:255',
            'category'         => 'nullable|string|max:255',
            'amount'           => 'required|min:0.01',
            'description'      => 'nullable|string|max:1000',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create($data);

        return response()->json([
            'message'     => 'Transaction muvaffaqiyatli qo‘shildi!',
            'transaction' => $transaction,
        ], 201);
    }
}
