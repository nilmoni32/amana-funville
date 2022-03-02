<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientDisposal extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'remarks', 'reason', 'ingredient_lists',  
    ];

    
}
