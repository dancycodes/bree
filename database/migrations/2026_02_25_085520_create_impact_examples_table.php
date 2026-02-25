<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_examples', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount'); // in EUR
            $table->string('description_fr');
            $table->string('description_en');
            $table->string('icon')->default('heart'); // heart, book, leaf, shield
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_examples');
    }
};
