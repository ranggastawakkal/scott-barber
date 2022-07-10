<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Schema\Expect;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function income()
    {
        return $this->hasOne(Income::class, 'transaction_id', 'id');
    }

    public function expense()
    {
        return $this->hasOne(Expense::class, 'transaction_id', 'id');
    }
}
