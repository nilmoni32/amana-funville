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
            $table->decimal('grand_total', 20, 6); 
            $table->string('order_date');
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
