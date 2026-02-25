<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patron_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('title_fr', 200);
            $table->string('title_en', 200);
            $table->string('role_fr', 200);
            $table->string('role_en', 200);
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->text('quote_fr')->nullable();
            $table->text('quote_en')->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patron_profiles');
    }
};
