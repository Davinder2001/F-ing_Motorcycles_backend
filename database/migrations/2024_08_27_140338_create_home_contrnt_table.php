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
            $table->string('s_description_1')->nullable();   // Added field for the first subsection description
            $table->string('s_description_2')->nullable();   // Added field for the second subsection description
            $table->string('s_description_3')->nullable();   // Added field for the third subsection description
            $table->string('third_sec_heading')->nullable(); // Added field for the third section heading
            $table->string('image_1_sec_3')->nullable();     // Added field for the first image in the third section
            $table->text('disc_1_sec_3')->nullable();        // Added field for the first description in the third section
            $table->string('image_2_sec_3')->nullable();     // Added field for the second image in the third section
            $table->text('disc_2_sec_3')->nullable();        // Added field for the second description in the third section
            $table->string('image_3_sec_3')->nullable();     // Added field for the third image in the third section
            $table->text('disc_3_sec_3')->nullable();        // Added field for the third description in the third section
            $table->string('image_4_sec_3')->nullable();     // Added field for the fourth image in the third section
            $table->text('disc_4_sec_3')->nullable();        // Added field for the fourth description in the third section
            $table->string('image_5_sec_3')->nullable();     // Added field for the fifth image in the third section
            $table->text('disc_5_sec_3')->nullable();        // Added field for the fifth description in the third section
            
            // SEO Fields
            $table->string('seo_title')->nullable();         // Added field for SEO title
            $table->text('seo_description')->nullable();     // Added field for SEO description
            $table->string('seo_keywords')->nullable();      // Added field for SEO keywords

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
