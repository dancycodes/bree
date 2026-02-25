<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('in_kind_donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('organization')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('donation_type'); // goods, services, expertise, other
            $table->text('description');
            $table->decimal('estimated_value', 10, 2)->unsigned()->nullable();
            $table->string('programme')->nullable();
            $table->string('availability')->nullable();
            $table->string('status')->default('pending_review'); // pending_review, accepted, declined
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('in_kind_donations');
    }
};
