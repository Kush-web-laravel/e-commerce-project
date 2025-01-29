<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class Admin extends Authenticatable implements AuthenticatableContract
{
    //
    protected $fillable = ['name','email','address','city','state' ,'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

}
