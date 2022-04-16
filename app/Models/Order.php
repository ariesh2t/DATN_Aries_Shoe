<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity');
    }

    public function getTotalPriceAttribute()
    {
        return Helper::numberFormat($this->attributes['total_price']);
    }
}
