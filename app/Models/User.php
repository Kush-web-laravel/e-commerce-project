<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cart;
use App\Models\Product;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

     protected $fillable = ['name', 'email','mobile_number','address','city','state','otp','otp_expires_at'];

     public function carts()
     {
         return $this->hasMany(Cart::class);
     }

     public function products()
     {
         return $this->hasMany(Product::class);
     }
}
