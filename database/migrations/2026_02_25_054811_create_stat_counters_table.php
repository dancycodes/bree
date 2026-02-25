<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stat_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number');
            $table->string('label_fr');
            $table->string('label_en');
            $table->text('icon_svg');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stat_counters');
    }
};
