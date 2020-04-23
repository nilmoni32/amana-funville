<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Auth;

class Cart extends Model
{
    
    protected $fillable = ['product_id', 'user_id', 'order_id', 'product_quantity', 'ip_address' ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function product(){

        return $this->belongsTo(Product::class);
    }

    public function order(){

        return $this->belongsTo(Order::class);
    }

    /**
     * Getting the cart model
     * @return integer the cart model
     */
    public static function totalCarts(){

        if(Auth::check()){
            $cart = Cart::where('user_id', Auth::id())->get();
        }
        else{
            $cart = Cart::where('ip_address', request()->ip())->get(); // getting all cart rows for the guest user.              
        }
        return $cart;
    }

    /**
     * Total items in the cart for a particular user
     * @return integer 
     */

    public static function totalItems(){
        if(Auth::check()){
            $carts = Cart::where('user_id', Auth::id())->get(); // getting all cart rows for the logged user.       
        }
        else{
            $carts = Cart::where('ip_address', request()->ip())->get(); // getting all cart rows for the guest user.              
        }

        $total_cartitems =0 ;

        foreach($carts as $cart){
            $total_cartitems += $cart->product_quantity;   
        }

        return $total_cartitems;
    }

}
