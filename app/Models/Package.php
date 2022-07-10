<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function getFormattedPriceAttribute()
    {
        return number_format($this->attributes['price'], 0, ',', '.');
    }

    public function income()
    {
        return $this->hasOne(Income::class, 'package_id', 'id');
    }
}
