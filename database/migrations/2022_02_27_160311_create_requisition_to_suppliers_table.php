<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionToSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_to_suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->index();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->datetime('requisition_date')->nullable();
            $table->datetime('expected_delivery')->nullable();
            $table->string('purpose',191)->nullable();
            $table->string('remarks',191)->nullable();
            $table->integer('total_quantity')->default(1);
            $table->decimal('total_amount', 13, 6)->nullable();
                        
            $table->foreign('admin_id')->references('id')->on('admins'); 
            $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::dropIfExists('requisition_to_suppliers');
    }
}
