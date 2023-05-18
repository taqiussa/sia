<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubElemen extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the elemen that owns the SubElemen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function elemen(): BelongsTo
    {
        return $this->belongsTo(Elemen::class)->withDefault();
    }
}
