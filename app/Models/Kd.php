<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kd extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the jenis that owns the Kd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisPenilaian::class, 'jenis_penilaian_id')->withDefault();
    }

    /**
     * Get the kategori that owns the Kd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriNilai::class, 'kategori_nilai_id')->withDefault();
    }
}
