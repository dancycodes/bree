<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FoundationEvent extends Model
{
    use LogsActivity;

    protected $fillable = [
        'slug',
        'title_fr',
        'title_en',
        'description_fr',
        'description_en',
        'location_fr',
        'location_en',
        'event_date',
        'event_time',
        'thumbnail_path',
        'is_published',
        'program_slug',
        'registration_required',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_published' => 'boolean',
            'registration_required' => 'boolean',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    /** Return the title in the current locale. */
    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    /** Return the location in the current locale. */
    public function location(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? ($this->location_fr ?? '') : ($this->location_en ?? '');
    }

    /** Scope: upcoming (today or future) published events ordered ASC. */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date');
    }

    /** Scope: past (before today) published events ordered DESC. */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('event_date', '<', now()->toDateString())
            ->orderByDesc('event_date');
    }
}
