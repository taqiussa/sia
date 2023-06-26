<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IbadahDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ibadah()
    {
        return $this->belongsTo(Ibadah::class)->withDefault();
    }
}
