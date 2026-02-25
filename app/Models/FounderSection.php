<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FounderSection extends Model
{
    use LogsActivity;

    protected $fillable = [
        'founder_name',
        'founder_title_fr',
        'founder_title_en',
        'founder_quote_fr',
        'founder_quote_en',
        'founder_photo_path',
        'patron_name',
        'patron_title_fr',
        'patron_title_en',
        'patron_quote_fr',
        'patron_quote_en',
        'patron_photo_path',
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

    /** Return the first active record or null. */
    public static function active(): ?self
    {
        return self::where('is_active', true)->first();
    }

    /** Return founder title in current locale. */
    public function founderTitle(): string
    {
        return app()->getLocale() === 'fr' ? $this->founder_title_fr : $this->founder_title_en;
    }

    /** Return founder quote in current locale. */
    public function founderQuote(): string
    {
        return app()->getLocale() === 'fr' ? $this->founder_quote_fr : $this->founder_quote_en;
    }

    /** Return patron title in current locale. */
    public function patronTitle(): string
    {
        return app()->getLocale() === 'fr' ? $this->patron_title_fr : $this->patron_title_en;
    }

    /** Return patron quote in current locale. */
    public function patronQuote(): string
    {
        return app()->getLocale() === 'fr' ? $this->patron_quote_fr : $this->patron_quote_en;
    }

    /**
     * Return initials from a full name (max 2 chars).
     *
     * @return non-empty-string
     */
    public static function initials(string $name): string
    {
        $parts = explode(' ', trim($name));
        $initials = '';
        foreach (array_slice($parts, 0, 2) as $part) {
            $initials .= mb_strtoupper(mb_substr($part, 0, 1));
        }

        return $initials ?: '?';
    }
}
