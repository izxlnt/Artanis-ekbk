<?php

namespace App\Http\Controllers\JenisPembeliShuttle4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function jenis_pembeli_shuttle4()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jenis-pembeli-shuttle4', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('jenis-pembeli-shuttle4', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('jenis-pembeli-shuttle4', date('Y')), 'name' => "Kemaskini Jenis Pembeli - Shuttle 4 (Kilang Papan Lapis/Venir)"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.jenis-pembeli-shuttle4.jenis-pembeli-shuttle4', compact('returnArr'));
    }
}
