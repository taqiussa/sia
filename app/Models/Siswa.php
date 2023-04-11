<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the alamat that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the kelas that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }


    /**
     * Get all of the pembayarans for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'nis', 'nis');
    }
    
    /**
     * Get all of the transaksi for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'nis', 'nis');
    }

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}
