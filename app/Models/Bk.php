<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bk extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the details for the Bk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(BkDetail::class);
    }

    /**
     * Get the user that owns the Bk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
