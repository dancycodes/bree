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
        Schema::table('partnership_applications', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('heard_about');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partnership_applications', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }
};
