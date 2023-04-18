<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriPengeluaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the pengeluaran for the KategoriPengeluaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pengeluaran(): HasMany
    {
        return $this->hasMany(Pengeluaran::class);
    }
}
