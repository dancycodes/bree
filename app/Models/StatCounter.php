<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StatCounter extends Model
{
    use LogsActivity;

    protected $fillable = [
        'number',
        'label_fr',
        'label_en',
        'icon_svg',
        'sort_order',
        'is_active',
    ];

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'number' => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('admin');
    }

    /**
     * Get the localized label based on current app locale.
     */
    public function label(): string
    {
        return app()->getLocale() === 'en' ? $this->label_en : $this->label_fr;
    }

    /**
     * Scope to active counters ordered by sort_order.
     */
    public function scopeActive($query): mixed
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
