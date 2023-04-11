<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'indonesia_districts';

    /**
     * Get the kota that owns the Kecamatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'code', 'city_code')->withDefault();
    }

    /**
     * Get all of the desa for the Kecamatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desa(): HasMany
    {
        return $this->hasMany(Desa::class, 'code', 'district_code');
    }
}
