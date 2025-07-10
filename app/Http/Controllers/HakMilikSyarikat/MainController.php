<?php

namespace App\Http\Controllers\HakMilikSyarikat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warganegara;


class MainController extends Controller
{
    public function hak_milik_syarikat()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('hak-milik-syarikat', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('hak-milik-syarikat', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('hak-milik-syarikat', date('Y')), 'name' => "Kemaskini Hak Milik Syarikat"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.Hak-milik-syarikat.hak-milik-syarikat', compact('returnArr'));
    }




    public function hak_milik_syarikat_update()
    {
        // dd('masuk');
        $list = Warganegara::get();



        return view('livewire.hak-milik-syarikat.hak-milik-syarikat-update',compact('list'));
    }


}

