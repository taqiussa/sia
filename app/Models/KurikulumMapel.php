<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KurikulumMapel extends Model
{
    use HasFactory;
    protected $table = 'kurikulum_mata_pelajaran';
    protected $guarded = [];

    /**
     * Get the mapel that owns the KurikulumMapel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id')->withDefault();
    }
    
}
