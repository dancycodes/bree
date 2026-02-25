<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Partner extends Model
{
    /** @use HasFactory<\Database\Factories\PartnerFactory> */
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'logo_path',
        'description_fr',
        'description_en',
        'website_url',
        'type',
        'is_published',
        'sort_order',
    ];

    public function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('name');
    }

    public function description(): ?string
    {
        return app()->getLocale() === 'fr' ? $this->description_fr : ($this->description_en ?? $this->description_fr);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'financial' => app()->getLocale() === 'fr' ? 'Partenaire Financier' : 'Financial Partner',
            'technical' => app()->getLocale() === 'fr' ? 'Partenaire Technique' : 'Technical Partner',
            default => app()->getLocale() === 'fr' ? 'Partenaire Institutionnel' : 'Institutional Partner',
        };
    }
}
