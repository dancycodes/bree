<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donation_pledges', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('status');
        });

        Schema::table('in_kind_donations', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('donation_pledges', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });

        Schema::table('in_kind_donations', function (Blueprint $table) {
            $table->dropColumn('admin_notes');
        });
    }
};
