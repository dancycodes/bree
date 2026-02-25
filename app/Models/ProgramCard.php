<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'stats_fr',
        'stats_en',
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
            'stats_fr' => 'array',
            'stats_en' => 'array',
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
     * Return the program stats in the current locale.
     * Each stat is ['number' => '1500+', 'label' => 'Bénéficiaires'].
     *
     * @return array<int, array{number: string, label: string}>
     */
    public function stats(): array
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? ($this->stats_fr ?? []) : ($this->stats_en ?? []);
    }

    public function programActivities(): HasMany
    {
        return $this->hasMany(ProgramActivity::class);
    }

    /**
     * Return the activities list in the current locale.
     * Uses ProgramActivity relation if populated, otherwise falls back to JSON.
     *
     * @return array<int, string>
     */
    public function activities(): array
    {
        $locale = app()->getLocale();
        $dbActivities = $this->relationLoaded('programActivities')
            ? $this->programActivities->where('is_active', true)->sortBy('sort_order')
            : $this->programActivities()->ordered()->get();

        if ($dbActivities->isNotEmpty()) {
            return $dbActivities->map(fn (ProgramActivity $a) => $locale === 'fr' ? $a->name_fr : $a->name_en)->values()->toArray();
        }

        return $locale === 'fr' ? ($this->activities_fr ?? []) : ($this->activities_en ?? []);
    }

    /** Scope: only active records, ordered by sort_order. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
