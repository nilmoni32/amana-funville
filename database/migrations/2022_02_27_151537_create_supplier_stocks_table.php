<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id')->index(); 
            $table->unsignedBigInteger('supplier_id')->index();
            $table->string('supplier_product_name');
            $table->string('measurement_unit');
            $table->decimal('unit_cost', 8, 2)->default(0.0);
            $table->decimal('total_qty',8,2)->default(0.0);
            $table->decimal('total_cost', 8, 2)->default(0.0);

            $table->foreign('supplier_id')->references('id')->on('suppliers');            
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_stocks');
    }
}