<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class NewsCategory extends Model
{
    /** @use HasFactory<\Database\Factories\NewsCategoryFactory> */
    use HasFactory;

    use LogsActivity;

    protected $fillable = [
        'name_fr',
        'name_en',
        'slug',
        'color',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    /** Eloquent relationship: articles belonging to this category. */
    public function articles(): HasMany
    {
        return $this->hasMany(NewsArticle::class, 'news_category_id');
    }

    /** Return the category name in the current locale. */
    public function name(): string
    {
        return app()->getLocale() === 'fr' ? $this->name_fr : $this->name_en;
    }

    /** Count of published articles using the normalized FK relationship. */
    public function articlesCount(): int
    {
        return $this->articles()->where('status', 'published')->count();
    }
}
