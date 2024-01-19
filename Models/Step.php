<?php

namespace Aytacmalkoc\Tracker\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Step extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $guarded = [];

    protected $casts = [
        'languages' => 'array'
    ];

    public function tracking(): BelongsTo
    {
        return $this->belongsTo(Tracking::class);
    }
}
