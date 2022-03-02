<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionIngredientList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requisition_to_supplier_id', 'ingredient_supplier_id', 'name', 'unit', 'unit_cost', 'quantity', 
        'stock', 'total', 
    ];

    /**
     * Defining inverse relationship  
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Supplier_requisition(){
        return $this->belongsTo(RequisitionToSupplier::class);        
    }


}
