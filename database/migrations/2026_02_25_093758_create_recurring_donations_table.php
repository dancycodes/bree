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
        Schema::create('recurring_donations', function (Blueprint $table) {
            $table->id();
            $table->string('tx_ref')->unique();
            $table->string('flutterwave_plan_id')->nullable();
            $table->string('flutterwave_subscription_id')->nullable();
            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('currency', 3)->default('EUR');
            $table->string('frequency')->default('monthly');
            $table->string('programme')->default('general');
            $table->string('donor_name');
            $table->string('donor_email');
            $table->string('donor_phone')->nullable();
            $table->string('donor_country', 2)->default('CM');
            $table->string('status')->default('pending');
            $table->json('flutterwave_data')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_donations');
    }
};
