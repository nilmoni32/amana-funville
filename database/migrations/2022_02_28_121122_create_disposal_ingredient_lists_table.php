<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposalIngredientListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposal_ingredient_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_disposal_id')->nullable();
            $table->unsignedBigInteger('ingredient_id')->index(); // recipe stock
            $table->unsignedBigInteger('ingredient_supplier_id')->nullable(); //supplier stock
            $table->string('name');
            $table->string('unit');
            $table->decimal('unit_cost', 8, 2);
            $table->decimal('quantity',8,2);
            $table->decimal('stock',8,2);  // supplier stock
            $table->decimal('total', 8, 2); // unit_cost * quantity
            $table->foreign('ingredient_disposal_id')->references('id')->on('ingredient_disposals')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('ingredient_supplier_id')->references('id')->on('ingredient_suppliers');
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
        Schema::dropIfExists('disposal_ingredient_lists');
    }
}
