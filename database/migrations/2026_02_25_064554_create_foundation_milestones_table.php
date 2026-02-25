<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foundation_milestones', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('year');
            $table->string('title_fr', 150);
            $table->string('title_en', 150);
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foundation_milestones');
    }
};
