<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyek extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get all of the aturanProyek for the Proyek
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aturanProyek(): HasMany
    {
        return $this->hasMany(AturanProyek::class);
    }
}
