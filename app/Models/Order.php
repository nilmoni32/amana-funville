<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cart;
use App\Models\Payment;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'status', 'payment_status','payment_method', 'payment_number', 'payment_type_bkash', 'transaction_id', 'grand_total', 'item_count', 'name', 'email', 'phone_no', 'address','district', 'zone', 'order_date', 'delivery_date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Order have many carts
     */
    public function carts(){
        return $this->hasMany(Cart::class);        
    }

}
