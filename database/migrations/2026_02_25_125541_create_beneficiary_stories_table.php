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
        Schema::create('beneficiary_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_card_id')->constrained()->cascadeOnDelete();
            $table->text('quote_fr');
            $table->text('quote_en');
            $table->string('author_name')->default('Bénéficiaire anonyme');
            $table->string('photo_path')->nullable();
            $table->boolean('is_published')->default(false);
            $table->smallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiary_stories');
    }
};
