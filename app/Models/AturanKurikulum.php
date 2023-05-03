<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanKurikulum extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the kurikulum that owns the AturanKurikulum
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class)->withDefault();
    }
}
