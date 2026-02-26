<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->foreignId('news_category_id')
                ->nullable()
                ->after('category_slug')
                ->constrained('news_categories')
                ->nullOnDelete();
        });

        // Data migration: match existing category_slug to news_categories.slug
        DB::table('news_articles')
            ->whereNotNull('category_slug')
            ->update([
                'news_category_id' => DB::raw(
                    '(SELECT id FROM news_categories WHERE news_categories.slug = news_articles.category_slug)'
                ),
            ]);
    }

    public function down(): void
    {
        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropForeign(['news_category_id']);
            $table->dropColumn('news_category_id');
        });
    }
};
