<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProgramCard extends Model
{
    use LogsActivity;

    protected $fillable = [
        'slug',
        'name_fr',
        'name_en',
        'description_fr',
        'description_en',
        'long_description_fr',
        'long_description_en',
        'activities_fr',
        'activities_en',
        'image_path',
        'color',
        'url',
        'sort_order',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'activities_fr' => 'array',
            'activities_en' => 'array',
        ];
    }

    /** Return the name in the current locale. */
    public function name(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->name_fr : $this->name_en;
    }

    /** Return the short description in the current locale. */
    public function description(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->description_fr : $this->description_en;
    }

    /** Return the long description in the current locale. */
    public function longDescription(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? ($this->long_description_fr ?? '') : ($this->long_description_en ?? '');
    }

    /**
     * Return the activities list in the current locale.
     *
     * @return array<int, string>
     */
    public function activities(): array
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? ($this->activities_fr ?? []) : ($this->activities_en ?? []);
    }

    /** Scope: only active records, ordered by sort_order. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
