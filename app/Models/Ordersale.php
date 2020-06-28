<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Sale;

class Ordersale extends Model
{
    protected $fillable = [
        'admin_id', 'order_number', 'grand_total', 'order_date', 'customer_name', 'customer_mobile', 'customer_email', 'customer_notes',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    /**
     * Order have many carts
     */
    public function sales(){
        return $this->hasMany(Sale::class);        
    }
}
