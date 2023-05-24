<?php

namespace App\Http\Controllers;

use App\Models\User;

class DownloadQrCodeController extends Controller
{
    public function index()
    {
        return inertia('Guru/DownloadQrCode', [
            'listUser' => User::where('username', '!=', null)
                ->where('username', '!=', 'admin')
                ->orderBy('name')
                ->get()
        ]);
    }
}
