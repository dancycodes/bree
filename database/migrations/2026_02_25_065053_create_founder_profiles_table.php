<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('founder_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('title_fr', 200);
            $table->string('title_en', 200);
            $table->text('bio_fr');
            $table->text('bio_en');
            $table->text('message_fr')->nullable();
            $table->text('message_en')->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('founder_profiles');
    }
};
