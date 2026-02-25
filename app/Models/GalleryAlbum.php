<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GalleryAlbum extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'slug',
        'title_fr',
        'title_en',
        'description_fr',
        'description_en',
        'cover_photo_path',
        'is_published',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id')->orderBy('sort_order');
    }

    /** Return the cover URL: explicit cover, or first photo, or null. */
    public function coverUrl(): ?string
    {
        if ($this->cover_photo_path) {
            return asset($this->cover_photo_path);
        }

        $first = $this->photos()->first();

        return $first ? asset($first->path) : null;
    }

    /** Return the title in the current locale. */
    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    /** Scope: only published albums ordered newest first. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('created_at');
    }
}
