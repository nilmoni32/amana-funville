<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    protected $fillable = [
        'user_id', 'order_number', 'status', 'grand_total', 'item_count', 'payment_status', 'payment_method', 'f_name', 'l_name', 'city', 'address'
    ];

    protected $casts = [
        'item_count' => 'integer',
        'payment_status'=> 'boolean',        
    ];

   

}
