<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianRapor extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * Get the jenis that owns the PenilaianRapor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisPenilaian::class)->withDefault();
    }

    /**
     * Get the kategori that owns the PenilaianRapor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriNilai::class)->withDefault();
    }
}
