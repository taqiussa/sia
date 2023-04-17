<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPemasukan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the pemasukan for the KategoriPemasukan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pemasukan(): HasMany
    {
        return $this->hasMany(Pemasukan::class);
    }
}
