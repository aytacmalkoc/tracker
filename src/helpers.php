<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

if (!function_exists('get_geo')) {
    /**
     * @param string $ip
     * @param string|null $identifier
     * @return object
     */
    function get_geo(string $ip, string|null $identifier = null): object
    {
        $fields = config('tracker.geo.fields');

        return (object) Cache::rememberForever('trackerapp-geo-' . $identifier ?: $ip, function() use($ip, $fields) {
            return Http::get("http://ip-api.com/json/$ip", [
                'fields' => implode(',', $fields),
            ])->object();
        });
    }
}