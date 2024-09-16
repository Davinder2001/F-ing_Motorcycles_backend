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
        Schema::create('product_page', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name')->nullable(); // Name of the product page
            $table->string('seo_title')->nullable(); // SEO title
            $table->text('seo_description')->nullable(); // SEO description, nullable in case it's not provided
            $table->string('seo_keywords')->nullable(); // SEO keywords, nullable
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_page');
    }
};
