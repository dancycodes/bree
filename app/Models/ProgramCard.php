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
        ];
    }

    /** Return the name in the current locale. */
    public function name(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->name_fr : $this->name_en;
    }

    /** Return the description in the current locale. */
    public function description(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->description_fr : $this->description_en;
    }

    /** Scope: only active records, ordered by sort_order. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
