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
     * Get the absensi that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get all of the absensis for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'nis', 'nis');
    }

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
     * Get the analisisAlquran that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function analisisAlqurans(): HasMany
    {
        return $this->hasMany(AnalisisAlquran::class, 'nis', 'nis');
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
     * Get the penilaian that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get all of the penilaians for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'nis', 'nis');
    }

    /**
     * Get the penilaianAlquran that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penilaianAlquran(): BelongsTo
    {
        return $this->belongsTo(PenilaianAlquran::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get all of the penilaianAlqurans for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penilaianAlqurans(): HasMany
    {
        return $this->hasMany(PenilaianAlquran::class, 'nis', 'nis');
    }


    /**
     * Get the siswaEkstra that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswaEkstra(): BelongsTo
    {
        return $this->belongsTo(SiswaEkstra::class, 'nis', 'nis')->withDefault();
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
