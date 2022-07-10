<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';
    protected $primaryKey = 'id';
    protected $foreignKey = [
        'transaction_id',
        'package_id'
    ];
    protected $fillable = [
        'transaction_id',
        'package_id',
        'quantity'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
