<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HeaderSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'header_style',
        'sticky_header',
        'transparent_header',
        'topbar_enabled',
        'navbar_enabled',
        'search_enabled',
        'cta_button_enabled',
        'cta_button_text',
        'cta_button_url',
        'cta_button_target',
        'mobile_menu_enabled',
        'status',
    ];

    protected $casts = [
        'sticky_header' => 'boolean',
        'transparent_header' => 'boolean',
        'topbar_enabled' => 'boolean',
        'navbar_enabled' => 'boolean',
        'search_enabled' => 'boolean',
        'cta_button_enabled' => 'boolean',
        'mobile_menu_enabled' => 'boolean',
        'status' => 'boolean',
    ];

    public static function getCached(): self
    {
        return Cache::rememberForever('header_settings', fn () => self::firstOrCreate([]));
    }

    public static function clearCache(): void
    {
        Cache::forget('header_settings');
    }

    public function getCtaButtonTargetAttribute(?string $value): string
    {
        return $value ?: '_self';
    }
}
