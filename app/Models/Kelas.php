<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the absensi that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class, 'id', 'kelas_id')->withDefault();
    }

    /**
     * Get all of the absensis for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id', 'kelas_id');
    }

    /**
     * Get all of the siswas for the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class, 'id', 'kelas_id');
    }
}
