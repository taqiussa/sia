<?php

namespace App\Models;

use EnumHari;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanKhususPulang extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $casts = [
    //     'hari' => EnumHari::class
    // ];

    /**
     * Get the user that owns the AturanKhususPulang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
