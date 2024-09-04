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
        Schema::create('home_content', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('heading_nxt')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();           // Added field for the second image
            $table->string('Sub_heading_2')->nullable();     // Added field for the sub-heading
            $table->string('heading_2')->nullable();         // Added field for the second heading
            $table->text('description_2')->nullable();       // Added field for the second description
            $table->string('button_1')->nullable();          // Added field for the first button
            $table->string('button_2')->nullable();          // Added field for the second button
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_content');
    }
};
