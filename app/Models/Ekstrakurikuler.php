<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstrakurikuler extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * Get the deskripsi that owns the Ekstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deskripsi(): BelongsTo
    {
        return $this->belongsTo(DeskripsiEkstra::class, 'ekstra_id', 'id')->withDefault();
    }
}
