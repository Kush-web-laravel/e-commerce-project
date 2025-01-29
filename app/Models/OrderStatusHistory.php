<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusHistory extends Model
{
    //

    use SoftDeletes;
    
    protected $fillable = [
        'order_number', 'order_status', 'status_updated_on'
    ];

    protected $dates = ['deleted_at'];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
