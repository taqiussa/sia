<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the kehadiran that owns the Absensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kehadiran(): BelongsTo
    {
        return $this->belongsTo(Kehadiran::class)->withDefault();
    }

    /**
     * Get the siswa that owns the Absensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the guru that owns the Absensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
