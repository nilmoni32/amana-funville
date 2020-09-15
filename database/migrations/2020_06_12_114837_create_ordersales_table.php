<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordersales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id');  
            $table->string('order_number')->unique();
            $table->decimal('grand_total', 13, 6); 
            $table->string('order_date');
            $table->string('order_tableNo')->nullable();
            $table->decimal('discount', 12, 6)->nullable();
            $table->string('discount_reference')->nullable();
            $table->string('payment_method'); // to store multiple values such as cash, card and mobile banking
            $table->decimal('cash_pay', 13, 6)->nullable();
            $table->decimal('card_pay', 13, 6)->nullable();
            $table->decimal('mobile_banking_pay', 13, 6)->nullable();
            $table->string('customer_name')->nullable(); 
            $table->string('customer_mobile')->nullable(); 
            $table->text('customer_address')->nullable();            
            $table->text('customer_notes')->nullable();

            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordersales');
    }
}
