<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('news_articles', 'category_slug')) {
            Schema::table('news_articles', function (Blueprint $table) {
                $table->string('category_slug')->nullable()->index()->after('category_en');
            });
        }
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn('category_slug');
        });
    }
};
