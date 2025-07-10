<?php

namespace App\Http\Controllers\Spesis;

use App\Http\Controllers\Controller;
use App\Models\KumpulanKayu;
use App\Models\Spesis;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function spesis()
    {
        if (KumpulanKayu::count() > 0) {

            $breadcrumbs    = [
                ['link' => route('home'), 'name' => "Laman Utama"],
                ['link' => route('spesis', date('Y')), 'name' => "Menu Utama Modul"],
                ['link' => route('spesis', date('Y')), 'name' => "Pengurusan Data Asas"],
                ['link' => route('spesis', date('Y')), 'name' => "Kemaskini Senarai Spesies"],
            ];

            $kembali = route('home');

            $returnArr = [
                'breadcrumbs' => $breadcrumbs,
                'kembali'     => $kembali,
            ];

            return view('admins.spesis.spesis', compact('returnArr'));
        } else {
            abort(403, 'Tiada Data Kumpulan Kayu');
            // return redirect()->back()->with('Error', 'Tiada data Kumpulan Kayu');
        }
    }
}
