<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\Batch;
use App\Models\FormC;
use Livewire\Component;
use App\Models\Kemasukan;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\UlasanPhd;
use Illuminate\Support\Facades\Session;

class EditForm3C extends Component
{
    public $shuttle_id;
    public $baki_stok,$jumlah_baki_stok,$kayu_masuk,$proses_masuk,$proses_keluar,$jumlah_kayu_masuk,$jumlah_stok_kayu_balak,$baki_stok_kehadapan,$jumlah,$total_stok_kayu_balak,
    $total_kayu_masuk_jentera,$total_kayu_keluar_jentera,$total_kayu_dibawa_bulan_hadapan,$jumlah_besar_baki_stok_bulan_lepas,$jumlah_besar_kemasukan_kayu_ke_kilang,
    $jumlah_besar_stok_kayu_balak,$jumlah_besar_kayu_ke_dalam_jentera,$jumlah_besar_pengeluaran_kayu_daripada_jentera,$jumlah_besar_baki_stok_bulan_depan;

    public function render()
    {
        $species = Spesis::orderBy('kumpulan_kayu_id')->get();
        $kumpulan_kayu = KumpulanKayu::get();
        $formc_id = FormC::findorfail($this->shuttle_id);
        // dd($formc_id);

        // $kilang_info = FormC::where('shuttle_id',$this->shuttle_id)->first();
        $ulasan = UlasanPhd::where('formcs_id',$formc_id->id)->latest('created_at')->first();

        // dd($ulasan);

        return view('livewire.shuttle-three.edit-form3-c',compact('species', 'kumpulan_kayu','formc_id','ulasan'));
    }

    public function loadData(){
        $formC = KemasukanBahan::where('formcs_id',$this->shuttle_id)->get();
        // dd($formC);
        foreach ($formC as $key => $value) {
            $this->baki_stok[$key] = $value->baki_stok;
            $this->jumlah_baki_stok[$key] = $value->jumlah_baki_stok;
            $this->kayu_masuk[$key] = $value->kayu_masuk;
            $this->proses_masuk[$key] = $value->proses_masuk;
            $this->proses_keluar[$key] = $value->proses_keluar;
            $this->jumlah_kayu_masuk[$key] = $value->jumlah_kayu_masuk;
            $this->jumlah_stok_kayu_balak[$key] = $value->jumlah_stok_kayu_balak;
            $this->baki_stok_kehadapan[$key] = $value->baki_stok_kehadapan;

            $this->jumlah[$key] = $value->jumlah;
            $this->total_stok_kayu_balak[$key] = $value->total_stok_kayu_balak;
            $this->total_kayu_masuk_jentera[$key] = $value->total_kayu_masuk_jentera;
            $this->total_kayu_keluar_jentera[$key] = $value->total_kayu_keluar_jentera;
            $this->total_kayu_dibawa_bulan_hadapan[$key] = $value->total_kayu_dibawa_bulan_hadapan;
            $this->jumlah_besar_baki_stok_bulan_lepas = $value->jumlah_besar_baki_stok_bulan_lepas;
            $this->jumlah_besar_kemasukan_kayu_ke_kilang = $value->jumlah_besar_kemasukan_kayu_ke_kilang;
            $this->jumlah_besar_stok_kayu_balak = $value->jumlah_besar_stok_kayu_balak;
            $this->jumlah_besar_kayu_ke_dalam_jentera = $value->jumlah_besar_kayu_ke_dalam_jentera;
            $this->jumlah_besar_pengeluaran_kayu_daripada_jentera = $value->jumlah_besar_pengeluaran_kayu_daripada_jentera;
            $this->jumlah_besar_baki_stok_bulan_depan = $value->jumlah_besar_baki_stok_bulan_depan;


        }
    }

    public function update()
    {

        // $jenis_pembeli = Pembeli::where('shuttle', 3)->get();
        $shuttle_id = Shuttle::first();

        $species = Spesis::orderBy('kumpulan_kayu_id')->get();

        $id=auth()->user();
        $kilang_info = Shuttle::where('id',$id->shuttle_id)->first();

        // dd($kilang_info);
        $status= 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id',$id->shuttle_id)->first();
        // dd($shuttle_id);
        // $formcs = FormC::where('shuttle_id',$this->shuttle_id)->get();
        //     foreach ($formcs as $data) {
        //         $data->status = $status;
        //         $data->save();
        //     }
        $formc_id = FormC::findorfail($this->shuttle_id);
            // dd($formc_id);
        $formc_id->status = $status;
        $formc_id->save();

        $batch = Batch::where('tahun',$formc_id->tahun)->where('bulan', $formc_id->bulan)->where('shuttle_id', $formc_id->shuttle_id)->first();
        $batch->borang_c = "1";
        $batch->save();

        $formC = KemasukanBahan::where('formcs_id',$this->shuttle_id)->get();

        foreach ($formC as $keySpecies => $data) {
            // dd( $this->jumlah_baki_stok);
            $data->update([
                // 'spesis_id' => $data->id,
                'baki_stok' => $this->baki_stok[$keySpecies],
                'kayu_masuk' => $this->kayu_masuk[$keySpecies],
                'jumlah_stok_kayu_balak' => $this->jumlah_stok_kayu_balak[$keySpecies],
                'proses_masuk' => $this->proses_masuk[$keySpecies],
                'proses_keluar' => $this->proses_keluar[$keySpecies],
                'baki_stok_kehadapan' => $this->baki_stok_kehadapan[$keySpecies],


                'jumlah_baki_stok' => $this->jumlah_baki_stok[$keySpecies] ?? 0,
                'jumlah_kayu_masuk' => $this->jumlah_kayu_masuk[$keySpecies] ?? 0,
                'total_stok_kayu_balak' => $this->total_stok_kayu_balak[$keySpecies] ?? 0,
                'total_kayu_masuk_jentera' => $this->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                'total_kayu_keluar_jentera' => $this->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                'total_kayu_dibawa_bulan_hadapan' => $this->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,


                'jumlah_besar_baki_stok_bulan_lepas' => $this->jumlah_besar_baki_stok_bulan_lepas,
                'jumlah_besar_kemasukan_kayu_ke_kilang' => $this->jumlah_besar_kemasukan_kayu_ke_kilang,
                'jumlah_besar_stok_kayu_balak' => $this->jumlah_besar_stok_kayu_balak,
                'jumlah_besar_kayu_ke_dalam_jentera' => $this->jumlah_besar_kayu_ke_dalam_jentera,
                'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $this->jumlah_besar_pengeluaran_kayu_daripada_jentera,
                'jumlah_besar_baki_stok_bulan_depan' => $this->jumlah_besar_baki_stok_bulan_depan,

            ]);
        }
        Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        return redirect()->route('home-user');
    }

     //jumlah total baki stok (02)
     public function calcJumlahBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)

     {
         $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
         $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
          $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
           $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
            $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
             $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
         $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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
         }

         // $this->calcBakiStok($key);

     }

     //jumlah  baki stok dibawa ke bulan hadapan (04)-(05)
     public function calcBakiStok($keySpecies, $keyKumpulanKayu, $singkatan)
     {
         $species = Spesis::orderBy('kumpulan_kayu_id')->get();

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

         $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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

         $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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

         $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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

          $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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

          $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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

           $species = Spesis::orderBy('kumpulan_kayu_id')->get();
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
