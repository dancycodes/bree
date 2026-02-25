<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipApplication extends Model
{
    protected $fillable = [
        'organization_name',
        'contact_name',
        'email',
        'phone',
        'organization_type',
        'proposal',
        'heard_about',
        'status',
    ];

    public function fullName(): string
    {
        return $this->contact_name.' ('.$this->organization_name.')';
    }
}
