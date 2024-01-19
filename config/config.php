<?php

return [

    'enabled' => env('TRACKER_ENABLED', true),

    'cache_key' => 'trck-cache-key',

    'cache_ttl' => 5 * 60,

    'rate_limiter' => [
        'key' => 'tracking-app-limiter',
        'per_minute' => 30, // 30 request per minute
    ],

    'logging' => [
        'driver' => 'single',
        'path' => storage_path('logs/tracker.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'replace_placeholders' => true,
    ],

    'identifier_key' => 'tracker-app-user-identifier',

    'geo' => [
        'fields' => [
            'status',
            'message',
            'continent',
            'continentCode',
            'country',
            'countryCode',
            'region',
            'regionName',
            'city',
            'district',
            'zip',
            'lat',
            'lon',
            'timezone',
            'offset',
            'currency',
            'isp',
            'org',
            'as',
            'asname',
            'reverse',
            'mobile',
            'proxy',
            'hosting',
            'query'
        ]
    ],
];
