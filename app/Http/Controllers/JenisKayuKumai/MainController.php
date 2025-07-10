<?php

namespace App\Http\Controllers\JenisKayuKumai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function jenis_kayu_kumai()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jenis-kayu-kumai', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('jenis-kayu-kumai', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('jenis-kayu-kumai', date('Y')), 'name' => "Kemaskini Jenis Pembeli - Shuttle 5 (Kilang Kayu Kumai)"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.jenis-kayu-kumai.jenis-kayu-kumai', compact('returnArr'));
    }
}
