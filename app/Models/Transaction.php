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
    protected $foreignKey = [
        'user_id',
        'package_id',
        'item_id'
    ];
    protected $fillable = [
        'user_id',
        'transaction_code',
        'type',
        'package_id',
        'item_id',
        'quantity',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function getFormattedTotalAttribute()
    {
        return number_format($this->attributes['total'], 0, ',', '.');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function income()
    {
        return $this->hasMany(Income::class, 'transaction_id', 'id');
    }

    public function expense()
    {
        return $this->hasMany(Expense::class, 'transaction_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
