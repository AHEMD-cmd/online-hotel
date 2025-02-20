<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('logo');
            $table->text('favicon');
            $table->text('top_bar_phone')->nullable();
            $table->text('top_bar_email')->nullable();
            $table->text('home_feature_status');
            $table->text('home_room_total');
            $table->text('home_room_status');
            $table->text('home_testimonial_status');
            $table->text('home_latest_post_total');
            $table->text('home_latest_post_status');
            $table->text('footer_address')->nullable();
            $table->text('footer_phone')->nullable();
            $table->text('footer_email')->nullable();
            $table->text('copyright')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('pinterest')->nullable();
            $table->text('analytic_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
