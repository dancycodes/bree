<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Default values for all known settings. */
    public static array $defaults = [
        'contact_email' => 'contact@breefondation.org',
        'contact_phone' => '+41 22 345 69 89',
        'contact_address' => '',
        'social_facebook' => '',
        'social_instagram' => '',
        'social_linkedin' => '',
        'social_youtube' => '',
        'social_twitter' => '',
        'donation_show_total' => '0',
        'donation_amounts' => '5000,10000,25000,50000',
        'team_section_visible' => '0',
        'payments_enabled' => '0',
    ];

    /** Get a single setting value (cached). */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::allSettings();

        return $all[$key] ?? $default ?? static::$defaults[$key] ?? null;
    }

    /** Set a single setting value and clear cache. */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        cache()->forget('site_settings');
    }

    /** Get all settings as key→value array (cached). */
    public static function allSettings(): array
    {
        return cache()->rememberForever('site_settings', function () {
            $stored = static::pluck('value', 'key')->toArray();

            return array_merge(static::$defaults, $stored);
        });
    }

    /** Update multiple settings at once and clear cache. */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        cache()->forget('site_settings');
    }
}
