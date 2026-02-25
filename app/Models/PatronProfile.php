<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PatronProfile extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'title_fr',
        'title_en',
        'role_fr',
        'role_en',
        'description_fr',
        'description_en',
        'quote_fr',
        'quote_en',
        'photo_path',
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
        ];
    }

    public function title(): string
    {
        return app()->getLocale() === 'fr' ? $this->title_fr : $this->title_en;
    }

    public function role(): string
    {
        return app()->getLocale() === 'fr' ? $this->role_fr : $this->role_en;
    }

    public function description(): string
    {
        return app()->getLocale() === 'fr' ? ($this->description_fr ?? '') : ($this->description_en ?? '');
    }

    public function quote(): string
    {
        return app()->getLocale() === 'fr' ? ($this->quote_fr ?? '') : ($this->quote_en ?? '');
    }

    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
