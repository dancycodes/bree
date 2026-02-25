<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImpactExample extends Model
{
    protected $fillable = [
        'amount',
        'description_fr',
        'description_en',
        'icon',
        'sort_order',
        'is_published',
    ];

    public function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('amount');
    }

    public function description(): string
    {
        return app()->getLocale() === 'fr' ? $this->description_fr : ($this->description_en ?: $this->description_fr);
    }
}
