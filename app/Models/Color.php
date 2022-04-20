<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors';

    protected $fillable = [
        'color',
    ];

    public function productInfors()
    {
        return $this->hasMany(ProductInfor::class);
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = strtoupper($value);
    }
}
