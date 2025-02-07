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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('photo'); // Photo for the post
            $table->text('heading'); // Heading for the post
            $table->text('short_content'); // Short content for the post
            $table->text('content'); // Full content for the post
            $table->integer('total_view')->default(0); // Total views for the post (default to 0)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
