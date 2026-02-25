<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    /** Return the category name in the current locale. */
    public function name(): string
    {
        return app()->getLocale() === 'fr' ? $this->name_fr : $this->name_en;
    }

    /** Count of published articles using this category slug. */
    public function articlesCount(): int
    {
        return NewsArticle::where('category_slug', $this->slug)->count();
    }
}
