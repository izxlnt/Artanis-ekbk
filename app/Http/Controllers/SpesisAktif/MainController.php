<?php

namespace App\Http\Controllers\SpesisAktif;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function spesis_aktif()
    {
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('spesis-aktif', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('spesis-aktif', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('spesis-aktif', date('Y')), 'name' => "Kemaskini Senarai Spesies Aktif"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.spesis-aktif.spesis-aktif', compact('returnArr'));
    }
}
