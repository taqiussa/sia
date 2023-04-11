<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alamat extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the desa that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa', 'code')->withDefault();
    }

    /**
     * Get the kabupaten that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten', 'code')->withDefault();
    }

    /**
     * Get the kecamatan that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan', 'code')->withDefault();
    }

    /**
     * Get the provinsi that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'code')->withDefault();
    }
}
