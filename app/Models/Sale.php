<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Ordersale;

class Sale extends Model
{
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'product_id', 'admin_id', 'ordersale_id', 'product_quantity', 'unit_price', 
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function product(){

        return $this->belongsTo(Product::class);
    }

    public function ordersale(){

        return $this->belongsTo(Ordersale::class);
    }
}
