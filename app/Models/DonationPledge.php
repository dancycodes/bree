<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationPledge extends Model
{
    /** @use HasFactory<\Database\Factories\DonationPledgeFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'phone',
        'email',
        'amount',
        'currency',
        'nature',
        'programme',
        'message',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function fullName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
