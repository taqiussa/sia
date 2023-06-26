<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapSosialController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/RekapSosial', ['initTahun' => $this->data_tahun()]);
    }
}
