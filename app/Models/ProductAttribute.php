<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id', 'quantity', 'price'
    ]; 

    protected $casts = [
        'product_id' => 'integer',        
    ];


}
