@extends('layouts.app')

@section('content')
<div class="container">
    <h1>💰 Expense Tracker</h1>

    <div class="mb-3">
        <h3>Balans: ${{ number_format($balance, 2) }}</h3>
    </div>

    <div class="mb-3">
        <a href="{{ route('transactions.index', ['filter' => 'daily']) }}" class="btn btn-outline-primary {{ $filter === 'daily' ? 'active' : '' }}">Kunlik</a>
        <a href="{{ route('transactions.index', ['filter' => 'weekly']) }}" class="btn btn-outline-primary {{ $filter === 'weekly' ? 'active' : '' }}">Haftalik</a>
        <a href="{{ route('transactions.index', ['filter' => 'monthly']) }}" class="btn btn-outline-primary {{ $filter === 'monthly' ? 'active' : '' }}">Oylik</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary {{ !in_array($filter, ['daily','weekly','monthly']) ? 'active' : '' }}">Barchasi</a>
    </div>

    <div class="mb-3">
        <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="btn btn-success">+ Kirim qo‘shish</a>
        <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="btn btn-danger">- Chiqim qo‘shish</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sana</th>
                <th>Nomi</th>
                <th>Kategoriya</th>
                <th>Izoh</th> <!-- Izoh ustuni qo‘shildi -->
                <th>Tur</th>
                <th>Qiymat ($)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->transaction_date->format('Y-m-d') }}</td>
                <td>{{ $transaction->name ?? '-'}}</td>
                <td>{{ $transaction->category ?? '—' }}</td>
                <td>{{ $transaction->description }}</td> <!-- Izoh chiqadi -->
                <td>
                    @if($transaction->type === 'income')
                        <span class="text-success">Kirim</span>
                    @else
                        <span class="text-danger">Chiqim</span>
                    @endif
                </td>
                <td>
                    @if($transaction->type === 'income')
                        +${{ number_format($transaction->amount, 2) }}
                    @else
                        -${{ number_format($transaction->amount, 2) }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Hech qanday transaksiyalar mavjud emas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $transactions->withQueryString()->links() }}
</div>
@endsection
