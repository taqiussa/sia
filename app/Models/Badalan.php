<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badalan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the badal that owns the Badalan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function badal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'badal_id', 'id')->withDefault();
    }

    /**
     * Get the kelas that owns the Badalan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the mapel that owns the Badalan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class)->withDefault();
    }

    /**
     * Get the user that owns the Badalan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
