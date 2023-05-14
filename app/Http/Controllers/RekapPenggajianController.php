<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\InitTrait;

class RekapPenggajianController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/RekapPenggajian',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
