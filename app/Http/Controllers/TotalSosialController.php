<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class TotalSosialController extends Controller
{
    use InitTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/TotalSosial', ['initTahun' => $this->data_tahun()]);
    }
}
