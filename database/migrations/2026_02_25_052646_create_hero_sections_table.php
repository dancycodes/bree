<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('tagline_fr');
            $table->string('tagline_en');
            $table->text('subtitle_fr');
            $table->text('subtitle_en');
            $table->string('cta1_label_fr');
            $table->string('cta1_label_en');
            $table->string('cta1_url');
            $table->string('cta2_label_fr');
            $table->string('cta2_label_en');
            $table->string('cta2_url');
            $table->string('bg_image_path')->default('images/sections/hero.jpg');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
