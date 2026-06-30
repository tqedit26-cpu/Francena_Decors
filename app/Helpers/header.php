<?php

use App\Models\HeaderLogo;
use App\Models\HeaderSetting;
use App\Models\HeaderTopbar;

if (! function_exists('header_settings')) {
    function header_settings(): HeaderSetting
    {
        return HeaderSetting::getCached();
    }
}

if (! function_exists('header_topbar')) {
    function header_topbar(): HeaderTopbar
    {
        return HeaderTopbar::firstOrCreate([]);
    }
}

if (! function_exists('header_logo')) {
    function header_logo(): HeaderLogo
    {
        return HeaderLogo::firstOrCreate([]);
    }
}
