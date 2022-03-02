<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveIngredientList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receive_from_supplier_id', 'ingredient_id', 'ingredient_supplier_id', 'name', 'unit', 'unit_cost', 'quantity',
        'stock', 'total',
    ];

    /**
     * Defining inverse relationship  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier(){
        return $this->belongsTo(ReceiveFromSupplier::class);        
    }


}
