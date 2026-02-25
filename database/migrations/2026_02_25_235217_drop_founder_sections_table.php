<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop the legacy founder_sections table.
     *
     * This table was superseded by founder_profiles (founder data) and
     * patron_profiles (patron data), which provide richer, properly separated
     * models. HomeController now queries those two tables directly.
     */
    public function up(): void
    {
        Schema::dropIfExists('founder_sections');
    }

    /**
     * Restore the founder_sections table for rollback support.
     */
    public function down(): void
    {
        Schema::create('founder_sections', function (Blueprint $table) {
            $table->id();
            $table->string('founder_name');
            $table->string('founder_title_fr');
            $table->string('founder_title_en');
            $table->text('founder_quote_fr');
            $table->text('founder_quote_en');
            $table->string('founder_photo_path')->nullable();
            $table->string('patron_name');
            $table->string('patron_title_fr');
            $table->string('patron_title_en');
            $table->text('patron_quote_fr');
            $table->text('patron_quote_en');
            $table->string('patron_photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};
