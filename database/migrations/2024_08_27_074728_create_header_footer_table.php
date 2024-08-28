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
        Schema::create('Header_footer', function (Blueprint $table) {
            $table->id();
           
            $table->string('header_logo')->nullable();
            
            $table->string('column_1_heading_1')->nullable();
            $table->string('column_1_field_1')->nullable();
            $table->string('column_1_field_2')->nullable();
            $table->string('column_1_field_3')->nullable();
            $table->string('column_1_field_4')->nullable();
            
            $table->string('column_2_heading_1')->nullable();
            $table->string('column_2_field_1')->nullable();
            $table->string('column_2_field_2')->nullable();
            $table->string('column_2_field_3')->nullable();
            
            $table->string('column_3_heading_1')->nullable();
            $table->string('column_3_field_1')->nullable();
            $table->string('column_3_field_2')->nullable();
            $table->string('column_3_field_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Header_footer');
    }
};
