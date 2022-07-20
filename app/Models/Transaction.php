<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Package;
use Nette\Schema\Expect;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d-m-Y H:i:s');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])->format('d-m-Y H:i:s');
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
