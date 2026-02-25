<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class NewsletterSubscriber extends Model
{
    use LogsActivity;

    protected $fillable = [
        'email',
        'locale',
        'subscribed_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
        ];
    }
}
