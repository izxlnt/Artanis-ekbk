<?php

namespace App\Http\Controllers\TarafSyarikat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function taraf_syarikat()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('taraf-syarikat', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('taraf-syarikat', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('taraf-syarikat', date('Y')), 'name' => "Kemaskini Senarai Taraf Sah Syarikat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.taraf-syarikat.taraf-syarikat', compact('returnArr'));
    }
}
