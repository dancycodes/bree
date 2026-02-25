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
        Schema::create('donation_pledges', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->decimal('amount', 10, 2)->unsigned()->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->string('nature')->default('monetary'); // monetary, in_kind
            $table->string('programme')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, fulfilled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_pledges');
    }
};
