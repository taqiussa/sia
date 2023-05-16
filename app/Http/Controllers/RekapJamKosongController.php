<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapJamKosongController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/RekapJamKosong',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
            ]
        );
    }
}
