<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $fillable = ['name', 'mobile', 'email', 'designation', 'discount_slab_percentage'];
    
}