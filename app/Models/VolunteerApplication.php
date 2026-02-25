<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'city_country',
        'areas_of_interest',
        'availability',
        'motivation',
        'status',
    ];

    public function casts(): array
    {
        return [
            'areas_of_interest' => 'array',
        ];
    }

    public function fullName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
