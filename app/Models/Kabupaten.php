<?php

namespace App\Models;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = 'indonesia_cities';

    /**
     * Get all of the kecamatan for the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kecamatan(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'code', 'city_code');
    }

    /**
     * Get the provinsi that owns the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'code', 'province_code')->withDefault();
    }
    
}
