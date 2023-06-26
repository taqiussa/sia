<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    use HasFactory;
    public function detail()
    {
        return $this->hasMany(IbadahDetail::class);
    }
}
