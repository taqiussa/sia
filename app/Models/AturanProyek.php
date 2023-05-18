<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanProyek extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the dimensi that owns the AturanProyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dimensi(): BelongsTo
    {
        return $this->belongsTo(Dimensi::class)->withDefault();
    }

    /**
     * Get the elemen that owns the AturanProyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function elemen(): BelongsTo
    {
        return $this->belongsTo(Elemen::class)->withDefault();
    }

    /**
     * Get the proyek that owns the AturanProyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class)->withDefault();
    }

    /**
     * Get the subElemen that owns the AturanProyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subElemen(): BelongsTo
    {
        return $this->belongsTo(SubElemen::class)->withDefault();
    }
}
