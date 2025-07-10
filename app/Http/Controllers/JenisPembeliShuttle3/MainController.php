<?php

namespace App\Http\Controllers\JenisPembeliShuttle3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function jenis_pembeli_shuttle3()
    {
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jenis-pembeli-shuttle3', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('jenis-pembeli-shuttle3', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('jenis-pembeli-shuttle3', date('Y')), 'name' => "Kemaskini Jenis Pembeli - Shuttle 3 (Kilang Papan)"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.jenis-pembeli-shuttle3.jenis-pembeli-shuttle3', compact('returnArr'));
    }
}
