@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Yangi {{ $type === 'income' ? 'Kirim' : 'Chiqim' }} qo‘shish</h2>

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="mb-3">
            <label for="name" class="form-label">Nomi</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

<div class="mb-3">
    <label for="category" class="form-label">Kategoriya</label>
    <select name="category" id="category" class="form-select">
        <option value="" selected>Tanlang</option>
        @foreach($categories as $category)
            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                {{ $category }}
            </option>
        @endforeach
    </select>
    @error('category')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


        <div class="mb-3">
            <label for="amount" class="form-label">Qiymat ($)</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
            @error('amount')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
    <label for="description" class="form-label">Izoh</label>
    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    @error('description')<div class="text-danger">{{ $message }}</div>@enderror
</div>


        <div class="mb-3">
            <label for="transaction_date" class="form-label">Sana</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
            @error('transaction_date')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Saqlash</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Bekor qilish</a>
    </form>
</div>
@endsection
