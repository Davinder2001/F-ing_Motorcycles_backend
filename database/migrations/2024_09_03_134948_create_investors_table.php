<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('field1', 1000)->nullable();  // Specify length if needed
            $table->string('field2', 1000)->nullable();  // Increase length for large content
            $table->string('field3', 1000)->nullable();  // Specify length if needed
            $table->string('field4', 1000)->nullable();  // Specify length if needed
            $table->string('field5', 1000)->nullable();  // Specify length if needed
            $table->string('field6', 1000)->nullable();  // Specify length if needed
            $table->string('field7', 1000)->nullable();  // Specify length if needed
            $table->string('field8', 1000)->nullable();  // Specify length if needed
            $table->string('field9', 1000)->nullable();  // Specify length if needed
            $table->string('field10', 1000)->nullable(); // Specify length if needed
            $table->string('image')->nullable();
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
        Schema::dropIfExists('investors');
    }
}
