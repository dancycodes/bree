<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission_sections', function (Blueprint $table) {
            $table->id();
            $table->text('vision_fr');
            $table->text('vision_en');
            $table->string('mission_1_fr');
            $table->string('mission_1_en');
            $table->text('mission_1_icon');
            $table->string('mission_2_fr');
            $table->string('mission_2_en');
            $table->text('mission_2_icon');
            $table->string('mission_3_fr');
            $table->string('mission_3_en');
            $table->text('mission_3_icon');
            $table->string('mission_4_fr');
            $table->string('mission_4_en');
            $table->text('mission_4_icon');
            $table->string('mission_5_fr');
            $table->string('mission_5_en');
            $table->text('mission_5_icon');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission_sections');
    }
};
