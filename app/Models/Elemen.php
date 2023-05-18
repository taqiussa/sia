<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elemen extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the dimensi that owns the Elemen
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dimensi(): BelongsTo
    {
        return $this->belongsTo(Dimensi::class)->withDefault();
    }

    /**
     * Get all of the subElemen for the Elemen
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subElemen(): HasMany
    {
        return $this->hasMany(SubElemen::class);
    }
}
