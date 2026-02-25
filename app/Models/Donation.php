<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tx_ref',
        'flutterwave_id',
        'amount',
        'currency',
        'type',
        'programme',
        'donor_name',
        'donor_email',
        'donor_phone',
        'donor_country',
        'status',
        'flutterwave_data',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'flutterwave_data' => 'array',
        ];
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
