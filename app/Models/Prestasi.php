<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prestasi extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the guru that owns the Prestasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Get the kelas that owns the Prestasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the user that owns the Prestasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}
