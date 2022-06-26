<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    protected $primaryKey = 'id';
    protected $foreignKey = [
        'item_id',
        'transaction_id'
    ];
    protected $fillable = [
        'item_id',
        'quantity',
        'amount'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
