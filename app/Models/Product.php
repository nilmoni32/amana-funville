<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name','slug','description','quantity','price','sale_price','discount','discount_quantity','status','featured'
    ];
    
    protected $casts = [
        'quantity' => 'integer',
         'status' => 'boolean',
         'featured' => 'boolean'
    ];


    

}
