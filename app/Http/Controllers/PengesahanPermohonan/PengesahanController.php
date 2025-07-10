<?php

namespace App\Http\Controllers\PengesahanPermohonan;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PengesahanController extends Controller
{
    public function pengesahan_permohonan()
    {
        $user=User::where('kategori_pengguna','BPE')->get();


        $breadcrumbs    = [
            ['link' => route('home-bpm'), 'name' => "Laman Utama"],
            ['link' => route('bpm.pengesahan-permohonan', date('Y')), 'name' => "Profil Pengguna"],
            ['link' => route('bpm.pengesahan-permohonan', date('Y')), 'name' => "Status Pengurusan Pengguna"],
        ];

        $kembali = route('home-bpm');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];





        return view('admins.pengesahan-permohonan.pengesahan-permohonan',compact('returnArr','user'));
    }

}
