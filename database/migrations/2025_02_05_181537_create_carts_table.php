<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('price', 8, 2); 
            $table->decimal('subtotal', 8, 2); 
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedInteger('adults');
            $table->unsignedInteger('children')->nullable();
            $table->timestamps();
            // Foreign key constraint (optional)
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
