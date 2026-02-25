<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foundation_events', function (Blueprint $table) {
            $table->boolean('registration_required')->default(false)->after('program_slug');
        });
    }

    public function down(): void
    {
        Schema::table('foundation_events', function (Blueprint $table) {
            $table->dropColumn('registration_required');
        });
    }
};
