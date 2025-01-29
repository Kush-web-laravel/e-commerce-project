<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\User;

class Cart extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'product_id','product_name' ,'quantity', 'price'
    ];

    protected $dates =['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
