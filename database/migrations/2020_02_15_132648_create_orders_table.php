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
            $table->enum('status', ['pending', 'processing', 'delivered','decline'])->default('pending');
            $table->decimal('grand_total', 20, 6);
            $table->unsignedInteger('item_count');
            $table->boolean('payment_status')->default(1);
            $table->string('payment_method')->nullable();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('city');
            $table->text('address');                  
            $table->timestamps();            

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
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
