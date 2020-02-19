<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category_name', 'slug', 'description', 'parent_id', 'menu', 'image'
    ];

    protected $casts = [
        'parent_id' =>  'integer',        
        'menu'      =>  'boolean'
    ];

   

}
