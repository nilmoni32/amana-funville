<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');            
            $table->string('order_number')->unique();           
            $table->enum('status', ['pending', 'processing', 'completed','decline'])->default('pending'); 
            // for sslcommerz          
            $table->boolean('payment_status')->default(0);
            $table->string('payment_method')->default('cash');
            
            // for bkash
            $table->unsignedInteger('payment_number')->nullable();
            $table->string('payment_type_bkash')->nullable();
            $table->string('transaction_id')->nullable(); 
            // for bKash
            $table->decimal('grand_total', 20, 6);
            $table->unsignedInteger('item_count');            
            $table->string('name');   
            $table->string('email');      
            $table->string('phone_no');
            $table->string('address');            
            $table->string('district');
            $table->string('zone');
            $table->string('order_date');
            $table->dateTime('delivery_date');
          
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
