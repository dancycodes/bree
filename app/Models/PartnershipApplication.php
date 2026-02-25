<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PartnershipApplication extends Model
{
    use LogsActivity;

    protected $fillable = [
        'organization_name',
        'contact_name',
        'email',
        'phone',
        'organization_type',
        'proposal',
        'heard_about',
        'admin_notes',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function fullName(): string
    {
        return $this->contact_name.' ('.$this->organization_name.')';
    }
}
