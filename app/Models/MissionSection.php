<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MissionSection extends Model
{
    use LogsActivity;

    protected $fillable = [
        'vision_fr', 'vision_en',
        'mission_1_fr', 'mission_1_en', 'mission_1_icon',
        'mission_2_fr', 'mission_2_en', 'mission_2_icon',
        'mission_3_fr', 'mission_3_en', 'mission_3_icon',
        'mission_4_fr', 'mission_4_en', 'mission_4_icon',
        'mission_5_fr', 'mission_5_en', 'mission_5_icon',
        'is_active',
    ];

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
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
     * Get the localized vision statement.
     */
    public function vision(): string
    {
        return app()->getLocale() === 'en' ? $this->vision_en : $this->vision_fr;
    }

    /**
     * Get all 5 mission items as an array with localized text and icon.
     *
     * @return array<int, array{text: string, icon: string}>
     */
    public function missions(): array
    {
        $locale = app()->getLocale();

        return array_map(function (int $i) use ($locale): array {
            $key = "mission_{$i}";

            return [
                'text' => $locale === 'en' ? $this->{"{$key}_en"} : $this->{"{$key}_fr"},
                'icon' => $this->{"{$key}_icon"},
            ];
        }, range(1, 5));
    }

    /**
     * Get the active mission section, or null if none.
     */
    public static function active(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
