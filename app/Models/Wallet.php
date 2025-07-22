<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Wallet extends Model
{
    protected $fillable = [
        'holder_type',
        'holder_id',
        'name',
        'slug',
        'uuid',
        'description',
        'meta',
        'balance',
        'decimal_places',
    ];

    protected $casts = [
        'meta' => 'array',
        'balance' => 'decimal:2',
    ];

    /**
     * Get the entity that owns the wallet (polymorphic).
     */
    public function holder(): MorphTo
    {
        return $this->morphTo();
    }
}
