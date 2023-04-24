<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiswaEkstra extends Model
{
    use HasFactory;
    protected $guarded = [];


    /**
     * Get the absensi that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(AbsensiEkstra::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the biodata that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biodata(): BelongsTo
    {
        return $this->belongsTo(Biodata::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the ekstrakurikuler that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class)->withDefault();
    }

    /**
     * Get the kelas that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the penilaian that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penilaian(): BelongsTo
    {
        return $this->belongsTo(PenilaianEkstrakurikuler::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the user that owns the SiswaEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}
