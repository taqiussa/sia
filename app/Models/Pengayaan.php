<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengayaan extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the details for the Pengayaan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail(): HasMany
    {
        return $this->hasMany(PengayaanDetail::class, 'pengayaan_id');
    }
}
