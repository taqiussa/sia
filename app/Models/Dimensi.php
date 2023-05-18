<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dimensi extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the elemen for the Dimensi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elemen(): HasMany
    {
        return $this->hasMany(Elemen::class);
    }
}
