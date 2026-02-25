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
            $table->text('long_description_fr')->nullable()->after('description_en');
            $table->text('long_description_en')->nullable()->after('long_description_fr');
            $table->json('activities_fr')->nullable()->after('long_description_en');
            $table->json('activities_en')->nullable()->after('activities_fr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_cards', function (Blueprint $table) {
            $table->dropColumn(['long_description_fr', 'long_description_en', 'activities_fr', 'activities_en']);
        });
    }
};
