<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   protected $table = 'payments';

   protected $fillable = [
       'order_id', 'payment_status', 'payment_method', 'amount'
   ];

 

}
