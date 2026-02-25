<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class NewsArticle extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'slug',
        'title_fr',
        'title_en',
        'excerpt_fr',
        'excerpt_en',
        'content_fr',
        'content_en',
        'category_fr',
        'category_en',
        'thumbnail_path',
        'status',
        'published_at',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /** Return the title in the current locale. */
    public function title(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->title_fr : $this->title_en;
    }

    /** Return the excerpt in the current locale. */
    public function excerpt(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? ($this->excerpt_fr ?? '') : ($this->excerpt_en ?? '');
    }

    /** Return the category label in the current locale. */
    public function category(): string
    {
        $locale = app()->getLocale();

        return $locale === 'fr' ? $this->category_fr : $this->category_en;
    }

    /** Scope: only published articles ordered by publish date descending. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at');
    }
}
