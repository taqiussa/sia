<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gunabayar extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the kategori that owns the Gunabayar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPemasukan::class)->withDefault();
    }

    /**
     * Get the pembayaran that owns the Gunabayar
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class)->withDefault();
    }

    /**
     * Get all of the pembayarans for the Gunabayar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
