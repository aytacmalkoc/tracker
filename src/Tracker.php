<?php

namespace Aytacmalkoc\Tracker;

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
        return get_geo($ip, $identifier);
    }

    /**
     * @return object
     */
    public static function geo(): object
    {
        return get_geo(request()->ip());
    }
}
