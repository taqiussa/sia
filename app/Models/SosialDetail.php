<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SosialDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the sosial that owns the SosialDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sosial(): BelongsTo
    {
        return $this->belongsTo(Sosial::class)->withDefault();
    }
}
