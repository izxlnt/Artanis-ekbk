<?php

namespace App\Http\Livewire\ShuttleFive;

use App\Models\FormC as ModelsFormC;
use App\Models\Kemasukan;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\Shuttle;
use App\Models\Spesis;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FormC extends Component
{
    public $baki_stok,$jumlah_baki_stok,$kayu_masuk,$proses_masuk,$proses_keluar,$jumlah_kayu_masuk,$jumlah_stok_kayu_balak,$baki_stok_kehadapan,$jumlah,$total_stok_kayu_balak,
    $total_kayu_masuk_jentera,$total_kayu_keluar_jentera,$total_kayu_dibawa_bulan_hadapan,$jumlah_besar_baki_stok_bulan_lepas,$jumlah_besar_kemasukan_kayu_ke_kilang,
    $jumlah_besar_stok_kayu_balak,$jumlah_besar_kayu_ke_dalam_jentera,$jumlah_besar_pengeluaran_kayu_daripada_jentera,$jumlah_besar_baki_stok_bulan_depan;
    public $month, $year;

    public function mount($month, $year)
    {
        $this->month = $month;
        $this->year = $year;

        $species   = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $shuttleId = auth()->user()->shuttle_id;

        // Build spesis_id => baki_stok_kehadapan map from previous month's submission
        $prevMonth = $month == 1 ? 12 : $month - 1;
        $prevYear  = $month == 1 ? $year - 1 : $year;
        $carryForward = [];

        $prevFormC = ModelsFormC::where('shuttle_id', $shuttleId)
            ->where('bulan', $prevMonth)
            ->where('tahun', $prevYear)
            ->first();

        if ($prevFormC) {
            KemasukanBahan::where('formcs_id', $prevFormC->id)
                ->get(['spesis_id', 'baki_stok_kehadapan'])
                ->each(function ($row) use (&$carryForward) {
                    $carryForward[$row->spesis_id] = $row->baki_stok_kehadapan;
                });
        }

        foreach ($species as $keySpecies => $data) {
            $this->baki_stok[$keySpecies]              = $carryForward[$data->id] ?? 0;
            $this->kayu_masuk[$keySpecies]             = 0;
            $this->jumlah_stok_kayu_balak[$keySpecies] = 0;
            $this->proses_masuk[$keySpecies]           = 0;
            $this->proses_keluar[$keySpecies]          = 0;
            $this->baki_stok_kehadapan[$keySpecies]    = 0;
        }

        // Load existing saved data so values are restored when user navigates back
        $formc = ModelsFormC::where('shuttle_id', $shuttleId)
            ->where('bulan', $month)
            ->where('tahun', $year)
            ->first();

        if ($formc) {
            $existing = KemasukanBahan::where('formcs_id', $formc->id)
                ->get()
                ->keyBy('spesis_id');

            foreach ($species as $keySpecies => $data) {
                if ($existing->has($data->id)) {
                    $row = $existing[$data->id];
                    $this->baki_stok[$keySpecies]                       = $row->baki_stok;
                    $this->kayu_masuk[$keySpecies]                      = $row->kayu_masuk;
                    $this->jumlah_stok_kayu_balak[$keySpecies]          = $row->jumlah_stok_kayu_balak;
                    $this->proses_masuk[$keySpecies]                    = $row->proses_masuk;
                    $this->proses_keluar[$keySpecies]                   = $row->proses_keluar;
                    $this->baki_stok_kehadapan[$keySpecies]             = $row->baki_stok_kehadapan;
                    $this->jumlah_baki_stok[$keySpecies]                = $row->jumlah_baki_stok;
                    $this->jumlah_kayu_masuk[$keySpecies]               = $row->jumlah_kayu_masuk;
                    $this->total_stok_kayu_balak[$keySpecies]           = $row->total_stok_kayu_balak;
                    $this->total_kayu_masuk_jentera[$keySpecies]        = $row->total_kayu_masuk_jentera;
                    $this->total_kayu_keluar_jentera[$keySpecies]       = $row->total_kayu_keluar_jentera;
                    $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] = $row->total_kayu_dibawa_bulan_hadapan;
                }
            }

            $firstRow = $existing->first();
            if ($firstRow) {
                $this->jumlah_besar_baki_stok_bulan_lepas             = $firstRow->jumlah_besar_baki_stok_bulan_lepas;
                $this->jumlah_besar_kemasukan_kayu_ke_kilang          = $firstRow->jumlah_besar_kemasukan_kayu_ke_kilang;
                $this->jumlah_besar_stok_kayu_balak                   = $firstRow->jumlah_besar_stok_kayu_balak;
                $this->jumlah_besar_kayu_ke_dalam_jentera             = $firstRow->jumlah_besar_kayu_ke_dalam_jentera;
                $this->jumlah_besar_pengeluaran_kayu_daripada_jentera = $firstRow->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $this->jumlah_besar_baki_stok_bulan_depan             = $firstRow->jumlah_besar_baki_stok_bulan_depan;
            }
        }
    }

    public function render()
    {
        $id=auth()->user();
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $kumpulan_kayu = KumpulanKayu::get();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();

        // dd($kumpulan_kayu);
        return view('livewire.shuttle-five.form-c', compact('species', 'kumpulan_kayu','kilang_info'));
    }

    public function store()
    {
        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        // Pass 1: compute row values, group totals, and grand totals
        $rows = [];
        $groupTotals = [];
        $grand = ['baki' => 0, 'masuk' => 0, 'jumlah' => 0, 'pmasuk' => 0, 'pkeluar' => 0, 'kehadapan' => 0];

        foreach ($species as $keySpecies => $data) {
            $gid    = $data->kumpulan_kayu_id;
            $baki   = (float)($this->baki_stok[$keySpecies]    ?? 0);
            $masuk  = (float)($this->kayu_masuk[$keySpecies]   ?? 0);
            $pmasuk = (float)($this->proses_masuk[$keySpecies] ?? 0);
            $pkeluar= (float)($this->proses_keluar[$keySpecies]?? 0);
            $jumlah    = $baki + $masuk;
            $kehadapan = $jumlah - $pmasuk;

            $rows[$keySpecies] = compact('baki', 'masuk', 'jumlah', 'pmasuk', 'pkeluar', 'kehadapan', 'gid');

            if (!isset($groupTotals[$gid])) {
                $groupTotals[$gid] = ['baki' => 0, 'masuk' => 0, 'jumlah' => 0, 'pmasuk' => 0, 'pkeluar' => 0, 'kehadapan' => 0];
            }
            $groupTotals[$gid]['baki']      += $baki;
            $groupTotals[$gid]['masuk']     += $masuk;
            $groupTotals[$gid]['jumlah']    += $jumlah;
            $groupTotals[$gid]['pmasuk']    += $pmasuk;
            $groupTotals[$gid]['pkeluar']   += $pkeluar;
            $groupTotals[$gid]['kehadapan'] += $kehadapan;

            $grand['baki']      += $baki;
            $grand['masuk']     += $masuk;
            $grand['jumlah']    += $jumlah;
            $grand['pmasuk']    += $pmasuk;
            $grand['pkeluar']   += $pkeluar;
            $grand['kehadapan'] += $kehadapan;
        }

        $formcs = ModelsFormC::updateOrCreate(
            [
                'shuttle_id' => $kilang_info->id,
                'bulan'      => $this->month,
                'tahun'      => $this->year,
            ],
            [
                'shuttle_type' => $kilang_info->shuttle_type,
                'status'       => 'Sedang Diproses',
                'nama_kilang'  => $kilang_info->nama_kilang,
                'no_ssm'       => $kilang_info->no_ssm,
                'no_lesen'     => $kilang_info->no_lesen,
            ]
        );

        // Delete old detail records before re-inserting to avoid duplicates on re-submit
        KemasukanBahan::where('formcs_id', $formcs->id)->delete();

        // Pass 2: insert KemasukanBahan records with computed values
        foreach ($species as $keySpecies => $data) {
            $r = $rows[$keySpecies];
            $g = $groupTotals[$r['gid']];

            KemasukanBahan::create([
                'spesis_id'              => $data->id,
                'baki_stok'              => $r['baki'],
                'kayu_masuk'             => $r['masuk'],
                'jumlah_stok_kayu_balak' => $r['jumlah'],
                'proses_masuk'           => $r['pmasuk'],
                'proses_keluar'          => $r['pkeluar'],
                'baki_stok_kehadapan'    => $r['kehadapan'],

                'jumlah_baki_stok'                => $g['baki'],
                'jumlah_kayu_masuk'               => $g['masuk'],
                'total_stok_kayu_balak'           => $g['jumlah'],
                'total_kayu_masuk_jentera'         => $g['pmasuk'],
                'total_kayu_keluar_jentera'        => $g['pkeluar'],
                'total_kayu_dibawa_bulan_hadapan'  => $g['kehadapan'],

                'jumlah_besar_baki_stok_bulan_lepas'             => $grand['baki'],
                'jumlah_besar_kemasukan_kayu_ke_kilang'          => $grand['masuk'],
                'jumlah_besar_stok_kayu_balak'                   => $grand['jumlah'],
                'jumlah_besar_kayu_ke_dalam_jentera'             => $grand['pmasuk'],
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $grand['pkeluar'],
                'jumlah_besar_baki_stok_bulan_depan'             => $grand['kehadapan'],

                'shuttle_id'              => $kilang_info->id,
                'kategori_guna_tenaga_id' => $data->id,
                'bulan'                   => $this->month,
                'tahun'                   => $this->year,
                'formcs_id'               => $formcs->id,
            ]);
        }

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
        return redirect()->route('home-user');
    }

    public function tiadaPengeluaran()
    {
        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        $formcs = ModelsFormC::updateOrCreate(
            [
                'shuttle_id' => $kilang_info->id,
                'bulan'      => $this->month,
                'tahun'      => $this->year,
            ],
            [
                'shuttle_type' => $kilang_info->shuttle_type,
                'status'       => 'Tiada Pengeluaran',
                'nama_kilang'  => $kilang_info->nama_kilang,
                'no_ssm'       => $kilang_info->no_ssm,
                'no_lesen'     => $kilang_info->no_lesen,
            ]
        );

        KemasukanBahan::where('formcs_id', $formcs->id)->delete();

        foreach ($species as $keySpecies => $data) {
            KemasukanBahan::create([
                'spesis_id'              => $data->id,
                'baki_stok'              => 0,
                'kayu_masuk'             => 0,
                'jumlah_stok_kayu_balak' => 0,
                'proses_masuk'           => 0,
                'proses_keluar'          => 0,
                'baki_stok_kehadapan'    => 0,

                'jumlah_baki_stok'                => 0,
                'jumlah_kayu_masuk'               => 0,
                'total_stok_kayu_balak'           => 0,
                'total_kayu_masuk_jentera'        => 0,
                'total_kayu_keluar_jentera'       => 0,
                'total_kayu_dibawa_bulan_hadapan' => 0,

                'jumlah_besar_baki_stok_bulan_lepas'             => 0,
                'jumlah_besar_kemasukan_kayu_ke_kilang'          => 0,
                'jumlah_besar_stok_kayu_balak'                   => 0,
                'jumlah_besar_kayu_ke_dalam_jentera'             => 0,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => 0,
                'jumlah_besar_baki_stok_bulan_depan'             => 0,

                'shuttle_id'              => $kilang_info->id,
                'kategori_guna_tenaga_id' => $data->id,
                'bulan'                   => $this->month,
                'tahun'                   => $this->year,
                'formcs_id'               => $formcs->id,
            ]);
        }

        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
        return redirect()->route('home-user');
    }

    //jumlah total baki stok (02)
    public function calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)

    {
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        $jumlah = 0;

        // dd($jumlah);
        foreach($species as $keySpecies => $data){
            // dd($data->kumpulan_kayu->singkatan);
            if($data->kumpulan_kayu->singkatan == $singkatan){

                $baki_stok =  $this->baki_stok[$keySpecies] ?? 0 ;

            }else{
                $baki_stok = 0;
            }
            $jumlah += $baki_stok;
        }
        // dd($jumlah);
        $this->jumlah_baki_stok[$keyKumpulanKayu] = $jumlah;

        $this->calcJumlahStokKayuBalak($keySpecies);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //jumlah total kemasukan Kayu Balak (03)
    public function calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        $jumlah = 0;

        foreach($species as $keySpecies => $data){
            // dd($data->kumpulan_kayu->singkatan);
            if($data->kumpulan_kayu->singkatan == $singkatan){

                $kayu_masuk =  $this->kayu_masuk[$keySpecies] ?? 0 ;

            }else{
                $kayu_masuk = 0;
            }
            $jumlah += $kayu_masuk;
        }
        // dd($jumlah);
        $this->jumlah_kayu_masuk[$keyKumpulanKayu] = $jumlah;
        $this->calcJumlahStokKayuBalak($keySpecies);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);
        $this->calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan);


    }

     //jumlah total stok Kayu Balak (04)
     public function calcTotalStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan)
     {
         $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

         $jumlah = 0;

         foreach($species as $keySpecies => $data){
             // dd($data->kumpulan_kayu->singkatan);
             if($data->kumpulan_kayu->singkatan == $singkatan){

                 $jumlah_stok_kayu_balak =  $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0 ;

             }else{
                 $jumlah_stok_kayu_balak = 0;
             }
             $jumlah += $jumlah_stok_kayu_balak;
         }
         // dd($jumlah);
        $this->total_stok_kayu_balak[$keyKumpulanKayu] = $jumlah;

        // $this->calcBakiStok($keySpecies, $keyKumpulanKayu, $singkatan);
     }


      //jumlah total stok Kayu Balak (05)
      public function calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan)
      {
          $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

          $jumlah = 0;

          foreach($species as $keySpecies => $data){
              // dd($data->kumpulan_kayu->singkatan);
              if($data->kumpulan_kayu->singkatan == $singkatan){

                  $proses_masuk =  $this->proses_masuk[$keySpecies] ?? 0 ;

              }else{
                  $proses_masuk = 0;
              }
              $jumlah += $proses_masuk;
          }
          // dd($jumlah);
          $this->total_kayu_masuk_jentera[$keyKumpulanKayu] = $jumlah;
          $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);
          $this->calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan);
          $this->calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);

      }

       //jumlah total stok Kayu Balak (06)
       public function calcTotalPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
       {
           $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

           $jumlah = 0;

           foreach($species as $keySpecies => $data){
               // dd($data->kumpulan_kayu->singkatan);
               if($data->kumpulan_kayu->singkatan == $singkatan){

                   $proses_keluar =  $this->proses_keluar[$keySpecies] ?? 0 ;

               }else{
                   $proses_keluar = 0;
               }
               $jumlah += $proses_keluar;
           }
           // dd($jumlah);
           $this->total_kayu_keluar_jentera[$keyKumpulanKayu] = $jumlah;
           $this->calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan);

       }

        //jumlah total stok Kayu Balak (07)
        public function calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
        {
            $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

            $jumlah = 0;

            foreach($species as $keySpecies => $data){
                // dd($data->kumpulan_kayu->singkatan);
                if($data->kumpulan_kayu->singkatan == $singkatan){

                    $baki_stok_kehadapan =  $this->baki_stok_kehadapan[$keySpecies] ?? 0 ;

                }else{
                    $baki_stok_kehadapan = 0;
                }
                $jumlah += $baki_stok_kehadapan;
            }
            // dd($jumlah);
            $this->total_kayu_dibawa_bulan_hadapan[$keyKumpulanKayu] = $jumlah;
        }

    //jumlah Stok Kayu balak = (04)=(02)+(03)
    public function calcJumlahStokKayuBalak($keySpecies)
    {
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        if (empty($this->baki_stok[$keySpecies])) {
            $this->baki_stok[$keySpecies] = 0;
        }
        if (empty($this->kayu_masuk[$keySpecies])) {
            $this->kayu_masuk[$keySpecies] = 0;
        }

        // $this->jumlah_stok_kayu_balak=0;
        // $baki_stok= 0;
        // $kayu_masuk = 0;
        $total_kayu= 0;
        foreach($species as $keySpecies =>$data){
            $baki_stok =  $this->baki_stok[$keySpecies] ?? 0 ;
            $kayu_masuk= $this->kayu_masuk[$keySpecies] ?? 0 ;

            $total_kayu = $baki_stok + $kayu_masuk;

            $this->jumlah_stok_kayu_balak [$keySpecies] = $total_kayu;
            $this->baki_stok_kehadapan[$keySpecies] = $total_kayu - ($this->proses_masuk[$keySpecies] ?? 0);
        }

        // $this->calcBakiStok($key);

    }

    //jumlah  baki stok dibawa ke bulan hadapan (04)-(05)
    public function calcBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)
    {
        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        if (empty($this->jumlah_stok_kayu_balak[$keySpecies])) {
            $this->jumlah_stok_kayu_balak[$keySpecies] = 0;
        }
        if (empty($this->proses_masuk[$keySpecies])) {
            $this->proses_masuk[$keySpecies] = 0;
        }

            $jumlah_stok_kayu_balak=  $this->jumlah_stok_kayu_balak[$keySpecies] ?? 0 ;
            $proses_masuk= $this->proses_masuk[$keySpecies] ?? 0 ;

            // $total_kayu = $jumlah_stok_kayu_balak - $proses_masuk;
            $this->baki_stok_kehadapan [$keySpecies]= $jumlah_stok_kayu_balak - $proses_masuk;

            // $this->baki_stok_kehadapan [$key] = $total_kayu;
            // $this->calcJumlahKayuMasuk($keySpecies, $keyKumpulanKayu, $singkatan);
          $this->calcTotalStokKayuDibawaBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan);

            $this->calcTotalKemasukanKayuBalakJentera($keySpecies, $keyKumpulanKayu, $singkatan);
    }

    //JUMLAH BESAR STOK BULAN LEPAS
    public function calcJumlahBesarStokBulanLepas($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $jumlah =   0;

        foreach($species as $keyKumpulanKayu => $data){

                foreach($species as $keySpecies => $data2){

                    if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                        $jumlah_besar_stok_kayu_balak = $this->jumlah_baki_stok[$keySpecies] ?? 0 ;
                         $jumlah += $jumlah_besar_stok_kayu_balak;
                        }
                    else{
                        $jumlah_besar_stok_kayu_balak = 0;
                    }
                }
            }
            $this->jumlah_besar_baki_stok_bulan_lepas= $jumlah;
    }

    //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM KAWASAN KILANG
    public function calcJumlahBesarKemasukanKayuKeKilang($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $jumlah =   0;

        foreach($species as $keyKumpulanKayu => $data){

                foreach($species as $keySpecies => $data2){

                    if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                        $jumlah_besar_kemasukan_kayu_ke_kilang = $this->jumlah_kayu_masuk[$keySpecies] ?? 0 ;
                         $jumlah += $jumlah_besar_kemasukan_kayu_ke_kilang;
                        }
                    else{
                        $jumlah_besar_kemasukan_kayu_ke_kilang = 0;
                    }
                }
            }
            $this->jumlah_besar_kemasukan_kayu_ke_kilang= $jumlah;
    }

    //JUMLAH BESAR Stok Kayu
    public function calcJumlahBesarStokKayuBalak($keySpecies, $keyKumpulanKayu, $singkatan)
    {

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
        $jumlah =   0;

        foreach($species as $keyKumpulanKayu => $data){

                foreach($species as $keySpecies => $data2){

                    if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                        $jumlah_besar_stok_kayu_balak = $this->total_stok_kayu_balak[$keySpecies] ?? 0 ;
                         $jumlah += $jumlah_besar_stok_kayu_balak;
                        }
                    else{
                        $jumlah_besar_stok_kayu_balak = 0;
                    }
                }
            }
            $this->jumlah_besar_stok_kayu_balak= $jumlah;
    }

     //JUMLAH BESAR KEMASUKAN KAYU BALAK KE DALAM JENTERA MEMPROSES
     public function calcJumlahBesarKayuKeDalamJentera($keySpecies, $keyKumpulanKayu, $singkatan)
     {

         $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
         $jumlah =   0;

         foreach($species as $keyKumpulanKayu => $data){

                 foreach($species as $keySpecies => $data2){

                     if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                         $jumlah_besar_kayu_ke_dalam_jentera = $this->total_kayu_masuk_jentera[$keySpecies] ?? 0 ;
                          $jumlah += $jumlah_besar_kayu_ke_dalam_jentera;
                         }
                     else{
                         $jumlah_besar_kayu_ke_dalam_jentera = 0;
                     }
                 }
             }
             $this->jumlah_besar_kayu_ke_dalam_jentera= $jumlah;
     }

     //JUMLAH BESAR PENGELUARAN KAYU GERGAJI DARIPADA JENTERA MEMPROSES
     public function calcJumlahBesarPengeluaranKayuDaripadaJentera($keySpecies, $keyKumpulanKayu, $singkatan)
     {

         $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
         $jumlah =   0;

         foreach($species as $keyKumpulanKayu => $data){

                 foreach($species as $keySpecies => $data2){

                     if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                         $jumlah_besar_pengeluaran_kayu_daripada_jentera = $this->total_kayu_keluar_jentera[$keySpecies] ?? 0 ;
                          $jumlah += $jumlah_besar_pengeluaran_kayu_daripada_jentera;
                         }
                     else{
                         $jumlah_besar_pengeluaran_kayu_daripada_jentera = 0;
                     }
                 }
             }
             $this->jumlah_besar_pengeluaran_kayu_daripada_jentera= $jumlah;
     }

      //JUMLAH BESAR BAKIK STOK DIBAWA KE BULAN HADAPAN
      public function calcJumlahBesarBakiStokBulanHadapan($keySpecies, $keyKumpulanKayu, $singkatan)
      {

          $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();
          $jumlah =   0;

          foreach($species as $keyKumpulanKayu => $data){

                  foreach($species as $keySpecies => $data2){

                      if($data2->kumpulan_kayu->keyKumpulanKayu == $keyKumpulanKayu){
                          $jumlah_besar_baki_stok_bulan_depan = $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0 ;
                           $jumlah += $jumlah_besar_baki_stok_bulan_depan;
                          }
                      else{
                          $jumlah_besar_baki_stok_bulan_depan = 0;
                      }
                  }
              }
              $this->jumlah_besar_baki_stok_bulan_depan= $jumlah;
      }


}
