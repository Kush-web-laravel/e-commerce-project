<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAdmin extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = ['name', 'email', 'password'];

    protected $dates = ['deleted_at'];
}
