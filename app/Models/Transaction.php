<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type', 'name', 'category', 'amount', 'description', 'transaction_date',
    ];
    protected $casts = [
    'transaction_date' => 'datetime',
    'created_at'       => 'datetime',
    'updated_at'       => 'datetime',
    ];

}
