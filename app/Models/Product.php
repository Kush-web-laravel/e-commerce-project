<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'price',
        'image',
        'description'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
