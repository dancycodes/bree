<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foundation_events', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('event_time');
            $table->time('end_time')->nullable()->after('end_date');
            $table->unsignedInteger('max_capacity')->nullable()->after('registration_required');
        });
    }

    public function down(): void
    {
        Schema::table('foundation_events', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'end_time', 'max_capacity']);
        });
    }
};
