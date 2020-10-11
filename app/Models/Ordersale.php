<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Sale;

class Ordersale extends Model
{
    protected $fillable = [
        'admin_id', 'client_id','director_id', 'order_number', 'grand_total', 'order_date', 'order_tableNo', 'status','discount','reward_discount','payment_method', 'cash_pay', 'card_pay', 'mobile_banking_pay',];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    /**
     * Order have many carts
     */
    public function sales(){
        return $this->hasMany(Sale::class);        
    }
}
