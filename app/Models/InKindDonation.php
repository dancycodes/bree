<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InKindDonation extends Model
{
    /** @use HasFactory<\Database\Factories\InKindDonationFactory> */
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'organization',
        'email',
        'phone',
        'donation_type',
        'description',
        'estimated_value',
        'programme',
        'availability',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_value' => 'decimal:2',
        ];
    }
}
