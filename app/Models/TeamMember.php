<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TeamMember extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'title_fr',
        'title_en',
        'bio_fr',
        'bio_en',
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

    /** Return the title in the current locale. */
    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    /** Return the bio in the current locale. */
    public function bio(): ?string
    {
        return app()->getLocale() === 'fr' ? $this->bio_fr : $this->bio_en;
    }

    /** Return the initials (first 2 letters) for the monogram placeholder. */
    public function initials(): string
    {
        return mb_strtoupper(mb_substr($this->name, 0, 2));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }
}
