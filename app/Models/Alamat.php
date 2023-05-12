<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alamat extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the desa that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function desa(): HasMany
    {
        return $this->hasMany(Desa::class, 'code', 'desa');
    }

    /**
     * Get the kabupaten that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kabupaten(): HasMany
    {
        return $this->hasMany(Kabupaten::class, 'code', 'kabupaten');
    }

    /**
     * Get the kecamatan that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kecamatan(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'code', 'kecamatan');
    }

    /**
     * Get the provinsi that owns the Alamat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provinsi(): HasMany
    {
        return $this->hasMany(Provinsi::class, 'code', 'provinsi');
    }
}
