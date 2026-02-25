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
        Schema::create('founder_sections', function (Blueprint $table) {
            $table->id();
            // Founder (Brenda BIYA)
            $table->string('founder_name');
            $table->string('founder_title_fr');
            $table->string('founder_title_en');
            $table->text('founder_quote_fr');
            $table->text('founder_quote_en');
            $table->string('founder_photo_path')->nullable();
            // Patron (Chantal BIYA)
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('founder_sections');
    }
};
