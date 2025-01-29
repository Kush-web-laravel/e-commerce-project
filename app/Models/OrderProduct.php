<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Orders;
use App\Models\Product;

class OrderProduct extends Model
{
    //

    use SoftDeletes;
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
