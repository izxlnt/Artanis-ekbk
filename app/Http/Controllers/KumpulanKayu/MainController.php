<?php

namespace App\Http\Controllers\KumpulanKayu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function kumpulan_kayu()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('kumpulan-kayu', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('kumpulan-kayu', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('kumpulan-kayu', date('Y')), 'name' => "Kemaskini Senarai Kumpulan Kayu Kayan"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.kumpulan-kayu.kumpulan-kayu', compact('returnArr'));
    }
}
