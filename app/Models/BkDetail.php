<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BkDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the bk that owns the BkDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bk(): BelongsTo
    {
        return $this->belongsTo(Bk::class)->withDefault();
    }

    /**
     * Get the kelas that owns the BkDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the user that owns the BkDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}
