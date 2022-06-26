<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaction_code',
        'amount',
        'pay',
        'charge'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
