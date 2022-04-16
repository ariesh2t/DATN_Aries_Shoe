<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInfor extends Model
{
    use HasFactory;

    protected $table = 'product_infors';

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'quantity',
    ];

    public function getQauntityAttribute()
    {
        return Helper::numberFormat($this->attributes['cost']);
    }
}
