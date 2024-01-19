<?php

use Aytacmalkoc\Tracker\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::post('tracker/track', [TrackingController::class, 'track'])->name('tracker.track');
