<?php

use App\Models\Admin\BusinessSetting;

if (!function_exists("business_setting")) {
    function business_setting($key, $default = null)
    {
        return BusinessSetting::where('key', $key)->value('value') ?? $default;
    }

    function business_image($key)
    {
        return business_setting($key) ? asset('storage/' . business_setting($key)) : '';
    }
}
