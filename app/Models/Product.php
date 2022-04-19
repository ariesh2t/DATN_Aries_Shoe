<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'cost',
        'price',
        'promotion',
        'desc',
        'category_id',
        'brand_id',
        'product_id',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_infors');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_infors');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCostAttribute()
    {
        return Helper::numberFormat($this->attributes['cost']);
    }

    public function getPriceAttribute()
    {
        return Helper::numberFormat($this->attributes['price']);
    }

    public function getPromotionAttribute()
    {
        return Helper::numberFormat($this->attributes['promotion']);
    }
}
