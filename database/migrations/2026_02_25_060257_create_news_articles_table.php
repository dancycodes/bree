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
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_fr');
            $table->string('title_en');
            $table->text('excerpt_fr')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_fr')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('category_fr')->default('Actualités');
            $table->string('category_en')->default('News');
            $table->string('thumbnail_path')->nullable();
            $table->string('status')->default('draft'); // draft | published
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
