<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'desktop_logo',
        'mobile_logo',
        'sticky_logo',
        'dark_logo',
        'light_logo',
        'favicon',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function desktopLogo()
    {
        return $this->belongsTo(Media::class, 'desktop_logo');
    }

    public function mobileLogo()
    {
        return $this->belongsTo(Media::class, 'mobile_logo');
    }

    public function stickyLogo()
    {
        return $this->belongsTo(Media::class, 'sticky_logo');
    }

    public function darkLogo()
    {
        return $this->belongsTo(Media::class, 'dark_logo');
    }

    public function lightLogo()
    {
        return $this->belongsTo(Media::class, 'light_logo');
    }

    public function faviconLogo()
    {
        return $this->belongsTo(Media::class, 'favicon');
    }
}
