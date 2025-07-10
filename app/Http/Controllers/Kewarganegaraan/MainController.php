<?php

namespace App\Http\Controllers\Kewarganegaraan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function kewarganegaraan()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('kewarganegaraan', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('kewarganegaraan', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('kewarganegaraan', date('Y')), 'name' => "Kemaskini Senarai Kewarganegaraan"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.kewarganegaraan.kewarganegaraan', compact('returnArr'));
    }
}

