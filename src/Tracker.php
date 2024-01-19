<?php

namespace Aytacmalkoc\Tracker;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Tracker
{
    /**
     * @return string
     */
    public function createUniqueIdentifier(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * @param string $ip
     * @param string $identifier
     * @return object
     */
    public function getGeoInformation(string $ip, string $identifier): object
    {
        $fields = config('tracker.geo.fields');

        return (object) Cache::rememberForever('trackerapp-geo-' . $identifier ?: $ip, function() use($ip, $fields) {
            return Http::get("http://ip-api.com/json/$ip", [
                'fields' => implode(',', $fields),
            ])->object();
        });
    }
}
