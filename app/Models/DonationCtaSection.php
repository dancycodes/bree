<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DonationCtaSection extends Model
{
    use LogsActivity;

    protected $fillable = [
        'headline_fr',
        'headline_en',
        'copy_fr',
        'copy_en',
        'bg_image_path',
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

    /** Return the headline in the current locale. */
    public function headline(): string
    {
        return app()->getLocale() === 'fr' ? $this->headline_fr : $this->headline_en;
    }

    /** Return the copy in the current locale. */
    public function copy(): string
    {
        return app()->getLocale() === 'fr' ? $this->copy_fr : $this->copy_en;
    }

    /** Return the first active record or null. */
    public static function active(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
