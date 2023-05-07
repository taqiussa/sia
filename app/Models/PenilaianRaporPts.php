<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianRaporPts extends Model
{
    use HasFactory;
    protected $guarded  = [];

    /**
     * Get the jenis that owns the PenilaianRaporPts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisPenilaian::class, 'jenis_penilaian_id')->withDefault();
    }
}
