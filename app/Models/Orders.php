<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Faker\Factory as Faker;

class Orders extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
       'user_id', 'order_number', 'order_status' ,'total_amount', 'order_on', 'order_description', 'delivery_slip'
    ];

    protected $dates =['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orderStatusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }
    
    public static function generateOrderNumber()
    {
        $prefix = 'ORD#';
        $randomNumber = mt_rand(100, 999); 
        return $prefix . $randomNumber;
    }

    public static function generateInvoiceNumber()
    {
        $prefix = '#DS';
        $randomNumber = mt_rand(100, 999); 
        return $prefix . $randomNumber;
    }

    public static function generateRandomData()
    {
        $faker = Faker::create();

        $address = $faker->address;
        $email = $faker->email;
        $phoneNumber = $faker->phoneNumber;

        return [
            'address' => $address,
            'email' => $email,
            'phone_number' => $phoneNumber
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
