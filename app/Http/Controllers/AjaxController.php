<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use App\Models\HakMilik;
use App\Models\Negeri;
use App\Models\Warganegara;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function fetch_daerah($kod_negeri){
        $negeri_name= Daerah::where('id',$kod_negeri)->first('negeri'); //Johor
// dd($negeri_name);

        $daerah_hutan = Daerah::select('daerah_hutan','id')->where('negeri', $negeri_name->negeri)->distinct()->orderBy('daerah_hutan')->get()->unique('daerah_hutan');
        // dd($daerah_hutan);
        return response()->json($daerah_hutan);
        exit;
    }

    public function fetch_warganegara($hak_milik){
        // dd($hak_milik);

        $keterangan= HakMilik::where('id',$hak_milik)->first('keterangan');

        // dd($keterangan);
        // $list_daerah = Negeri::where('negeri', $kod_negeri)->get();
        if($keterangan->keterangan == "Warganegara Malaysia"){
            $warganegara = Warganegara::where('keterangan', 'Bumiputera')->orWhere('keterangan', 'Bukan Bumiputera')->get('keterangan');
        }
        elseif($keterangan->keterangan == "Bukan Warganegara Malaysia"){
            $warganegara = Warganegara::where('keterangan', 'Bukan Warganegara')->get('keterangan');
        }
        // dd($warganegara);
        return json_decode($warganegara);
        exit;
    }

    public function poskod($poskod){

        // $list_daerah = Negeri::where('negeri', $kod_negeri)->get();
        // dd($poskod);
        $daerah_hutan= Daerah::where('id',$poskod)->first('daerah_hutan'); //Johor
        // $list_poskod = Negeri::where('poskod', $poskod)->distinct()->get('bandar');

        $list_daerah = Daerah::where('daerah_hutan', $daerah_hutan->daerah_hutan)->distinct()->orderBy('daerah_sivil')->get('daerah_sivil');
// dd($list_daerah);
        return json_decode($list_daerah);
        exit;
    }

    public function poskod_surat_menyurat($poskodsurat){

        // $list_daerah = Negeri::where('negeri', $kod_negeri)->get();

        $list_poskod_surat_menyurat = Negeri::where('poskod', $poskodsurat)->distinct()->get('bandar');


        return json_decode($list_poskod_surat_menyurat);
        exit;
    }
}
