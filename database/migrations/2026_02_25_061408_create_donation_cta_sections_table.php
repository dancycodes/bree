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
        Schema::create('donation_cta_sections', function (Blueprint $table) {
            $table->id();
            $table->string('headline_fr');
            $table->string('headline_en');
            $table->text('copy_fr');
            $table->text('copy_en');
            $table->string('bg_image_path')->default('images/sections/donate.jpg');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_cta_sections');
    }
};
