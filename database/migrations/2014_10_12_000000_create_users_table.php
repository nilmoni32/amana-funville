<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');  
            $table->string('mobile')->unique();            
            $table->timestamp('verified_at')->nullable();            
            $table->integer('is_email_verified')->default(0); 
            $table->integer('is_mobile_verified')->default(0);
            $table->string('email_token')->nullable(); 
            $table->string('mobile_token')->nullable();    
            $table->string('address',191)->nullable(); 
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
