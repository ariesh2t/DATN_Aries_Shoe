<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'color',
        'size',
    ];
    
    public function getQuantityAttribute()
    {
        return Helper::numberFormat($this->attributes['quantity']);
    }
    
    public function getPriceAttribute()
    {
        return Helper::numberFormat($this->attributes['price']);
    }
}
