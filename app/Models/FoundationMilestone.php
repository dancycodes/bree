<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FoundationMilestone extends Model
{
    use LogsActivity;

    protected $fillable = [
        'year',
        'title_fr',
        'title_en',
        'description_fr',
        'description_en',
        'sort_order',
        'is_active',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'year' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function description(): string
    {
        return app()->getLocale() === 'fr' ? ($this->description_fr ?? '') : ($this->description_en ?? '');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('year')->orderBy('sort_order');
    }
}
