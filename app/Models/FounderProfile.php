<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FounderProfile extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'title_fr',
        'title_en',
        'bio_fr',
        'bio_en',
        'message_fr',
        'message_en',
        'photo_path',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function bio(): string
    {
        return app()->getLocale() === 'fr' ? $this->bio_fr : $this->bio_en;
    }

    public function message(): string
    {
        return app()->getLocale() === 'fr' ? ($this->message_fr ?? '') : ($this->message_en ?? '');
    }

    /** Return the active founder profile, or null if none configured. */
    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
