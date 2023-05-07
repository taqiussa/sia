<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianSkor extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the kelas that owns the PenilaianSkor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the siswa that owns the PenilaianSkor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the skor that owns the PenilaianSkor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skors(): BelongsTo
    {
        return $this->belongsTo(Skor::class, 'skor_id', 'id')->withDefault();
    }

    /**
     * Get the user that owns the PenilaianSkor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
