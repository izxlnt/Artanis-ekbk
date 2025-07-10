<?php

namespace App\Http\Controllers\KategoriPekerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function kategori_pekerja()
    {
        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('kategori-pekerja', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('kategori-pekerja', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('kategori-pekerja', date('Y')), 'name' => "Kemaskini Senarai Kategori Pekerja"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.kategori-pekerja.kategori-pekerja', compact('returnArr'));
    }
}
