<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengayaanDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the pengayaan that owns the PengayaanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengayaan(): BelongsTo
    {
        return $this->belongsTo(Pengayaan::class)->withDefault();
    }

    /**
     * Get the siswa that owns the PengayaanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the user that owns the PengayaanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}
