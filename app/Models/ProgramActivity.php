<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProgramActivity extends Model
{
    use LogsActivity;

    protected $fillable = [
        'program_card_id',
        'name_fr',
        'name_en',
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
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function programCard(): BelongsTo
    {
        return $this->belongsTo(ProgramCard::class);
    }

    /** Return the activity name in the current locale. */
    public function name(): string
    {
        return app()->getLocale() === 'fr' ? $this->name_fr : $this->name_en;
    }

    /** Scope: active activities ordered by sort_order. */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
