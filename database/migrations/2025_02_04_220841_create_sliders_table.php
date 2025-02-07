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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->text('photo'); // Slider image
            $table->text('heading')->nullable(); // Slider heading
            $table->text('text')->nullable(); // Slider text
            $table->text('button_text')->nullable(); // Button text
            $table->text('button_url')->nullable(); // Button URL
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};
