<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiEkstra extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the biodata that owns the AbsensiEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function biodata(): BelongsTo
    {
        return $this->belongsTo(Biodata::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the ekstrakurikuler that owns the AbsensiEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class)->withDefault();
    }

    /**
     * Get the guru that owns the AbsensiEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Get the kehadiran that owns the AbsensiEkstra
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kehadiran(): BelongsTo
    {
        return $this->belongsTo(Kehadiran::class)->withDefault();
    }
}
