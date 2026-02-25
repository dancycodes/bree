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
        Schema::table('program_cards', function (Blueprint $table) {
            $table->json('stats_fr')->nullable()->after('activities_en');
            $table->json('stats_en')->nullable()->after('stats_fr');
        });
    }

    public function down(): void
    {
        Schema::table('program_cards', function (Blueprint $table) {
            $table->dropColumn(['stats_fr', 'stats_en']);
        });
    }
};
