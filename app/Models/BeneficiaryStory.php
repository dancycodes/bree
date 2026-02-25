<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BeneficiaryStory extends Model
{
    use LogsActivity;

    protected $fillable = [
        'program_card_id',
        'quote_fr',
        'quote_en',
        'author_name',
        'photo_path',
        'is_published',
        'sort_order',
    ];

    public function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function programCard(): BelongsTo
    {
        return $this->belongsTo(ProgramCard::class);
    }

    /** Return the quote in the current locale. */
    public function quote(): string
    {
        return app()->getLocale() === 'fr' ? $this->quote_fr : $this->quote_en;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
