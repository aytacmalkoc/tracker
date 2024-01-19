<?php

namespace Aytacmalkoc\Tracker;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aytacmalkoc\Tracker\Skeleton\SkeletonClass
 */
class TrackerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tracker';
    }
}
