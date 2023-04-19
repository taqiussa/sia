<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliKelas extends Model
{
    use HasFactory;
    protected $table = 'kelas_wali_kelas';
    protected $guarded = [];

    /**
     * Get the kelas that owns the WaliKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get all of the penilaians for the WaliKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penilaians(): HasMany
    {
        return $this->hasMany(PenilaianGuru::class, 'user_id', 'user_id');
    }

    /**
     * Get the user that owns the WaliKelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
