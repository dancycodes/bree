<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('tx_ref')->unique();
            $table->string('flutterwave_id')->nullable();
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('currency', 3)->default('EUR');
            $table->string('type')->default('direct');
            $table->string('programme')->default('general');
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone')->nullable();
            $table->string('donor_country', 2)->default('CM');
            $table->string('status')->default('pending');
            $table->json('flutterwave_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
