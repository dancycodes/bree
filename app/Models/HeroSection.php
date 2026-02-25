<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class HeroSection extends Model
{
    use LogsActivity;

    protected $fillable = [
        'tagline_fr',
        'tagline_en',
        'subtitle_fr',
        'subtitle_en',
        'cta1_label_fr',
        'cta1_label_en',
        'cta1_url',
        'cta2_label_fr',
        'cta2_label_en',
        'cta2_url',
        'bg_image_path',
        'is_active',
    ];

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('admin');
    }

    /**
     * Get the localized tagline based on current app locale.
     */
    public function tagline(): string
    {
        return app()->getLocale() === 'en' ? $this->tagline_en : $this->tagline_fr;
    }

    /**
     * Get the localized subtitle based on current app locale.
     */
    public function subtitle(): string
    {
        return app()->getLocale() === 'en' ? $this->subtitle_en : $this->subtitle_fr;
    }

    /**
     * Get the localized CTA1 label.
     */
    public function cta1Label(): string
    {
        return app()->getLocale() === 'en' ? $this->cta1_label_en : $this->cta1_label_fr;
    }

    /**
     * Get the localized CTA2 label.
     */
    public function cta2Label(): string
    {
        return app()->getLocale() === 'en' ? $this->cta2_label_en : $this->cta2_label_fr;
    }

    /**
     * Get the active hero section, or null if none.
     */
    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
