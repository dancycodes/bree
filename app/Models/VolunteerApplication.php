<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class VolunteerApplication extends Model
{
    use LogsActivity;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'city_country',
        'areas_of_interest',
        'availability',
        'motivation',
        'admin_notes',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

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
