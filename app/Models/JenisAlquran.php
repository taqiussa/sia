<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisAlquran extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the penilaian that owns the JenisAlquran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(PenilaianAlquran::class, 'id', 'jenis_alquran_id')->withDefault();
    }
}
