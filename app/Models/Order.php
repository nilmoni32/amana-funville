<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'status', 'name', 'phone_no', 'shipping_address', 'message'
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
