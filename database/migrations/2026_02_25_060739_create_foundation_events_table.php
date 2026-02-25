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
        Schema::create('foundation_events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_fr');
            $table->string('title_en');
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('location_fr')->nullable();
            $table->string('location_en')->nullable();
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foundation_events');
    }
};
