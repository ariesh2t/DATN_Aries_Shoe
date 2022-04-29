<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'fullname',
        'phone',
        'address',
        'note',
        'total_price',
        'order_status_id',
        'shipping',
        'reason',
    ];

    protected $appends = [
        'order_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity', 'price', 'color', 'size');
    }
    
    public function getOrderPriceAttribute()
    {
        return $this->total_price + $this->shipping;
    }
}
