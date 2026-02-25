<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringDonation extends Model
{
    /** @use HasFactory<\Database\Factories\RecurringDonationFactory> */
    use HasFactory;

    protected $fillable = [
        'tx_ref',
        'flutterwave_plan_id',
        'flutterwave_subscription_id',
        'amount',
        'currency',
        'frequency',
        'programme',
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_country',
        'status',
        'flutterwave_data',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'flutterwave_data' => 'array',
            'cancelled_at' => 'datetime',
        ];
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
