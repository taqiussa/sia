<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'indonesia_provinces';

    /**
     * Get all of the kota for the Provinsi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kabupaten(): HasMany
    {
        return $this->hasMany(Kabupaten::class, 'code', 'province_code');
    }
}
