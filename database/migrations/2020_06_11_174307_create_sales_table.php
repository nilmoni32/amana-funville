<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id'); 
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('ordersale_id')->nullable();           
            $table->integer('product_quantity')->default(1);
            $table->decimal('unit_price', 8, 2)->nullable();
            
            $table->timestamps();

            $table->foreign('admin_id')
            ->references('id')
            ->on('admins')
            ->onDelete('cascade');

            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');

            $table->foreign('ordersale_id')
            ->references('id')
            ->on('ordersales')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
