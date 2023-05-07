<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class KurikulumMapel extends Model
{
    use HasFactory;
    protected $table = 'kurikulum_mata_pelajaran';
    protected $guarded = [];

    /**
     * Get all of the kd for the KurikulumMapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function kd(): HasManyThrough
    {
        return $this->hasManyThrough(Kd::class, MataPelajaran::class, 'id', 'mata_pelajaran_id', 'mata_pelajaran_id', 'id');
    }

    /**
     * Get the user associated with the KurikulumMapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function kkm(): HasOneThrough
    {
        return $this->hasOneThrough(Kkm::class, MataPelajaran::class, 'id', 'mata_pelajaran_id', 'mata_pelajaran_id', 'id')->withDefault();
    }

    /**
     * Get the mapel that owns the KurikulumMapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id')->withDefault();
    }

    /**
     * Get all of the penilaian for the KurikulumMapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function penilaian(): HasManyThrough
    {
        return $this->hasManyThrough(Penilaian::class, MataPelajaran::class, 'id', 'mata_pelajaran_id', 'mata_pelajaran_id', 'id');
    }
}
