<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Laporan;
use App\Models\Shuttle;
use App\Models\Spesis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;

use App\Models\GunaTenaga;
use App\Models\JenisKayu;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Negeri;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use PDO;

class LaporanController extends LaporanDataLamaController
{
    public function importExportView()
    {

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('laporan', date('Y')), 'name' => "Laporan"],
        ];

        $kembali = route('home');

        // $year = FormA::where('status', 'lulus')->get();
        $year = FormA::where('status', 'lulus')->distinct()->get('tahun');
        $spesis = Spesis::orderBy('nama_tempatan')->get();

        $spesis_lama = DB::connection('mysql2')->select("Select mkk_spesies.*, mkk_kod_kumpulankayu.kod_singkatan as spesies_kumpulankayu from mkk_spesies
        inner join mkk_kod_kumpulankayu on mkk_spesies.spesies_kumpulankayu_id = mkk_kod_kumpulankayu.kod_id
        where spesies_deleted = 0 and spesies_aktif = 1 order by spesies_kumpulankayu_id, spesies_namatempatan");

        // dd($spesis_lama);

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.laporan.senarai_laporan', compact('returnArr', 'year', 'spesis', 'spesis_lama'));
    }

    public function laporanView(Request $request)
    {
        $title = $request->laporan;
        if ($request->tahunakhir) {
            if ($request->tahun > $request->tahunakhir) {
                $temp = $request->tahun;

                $request->tahun = $request->tahunakhir;

                $request->tahunakhir = $temp;
            }
        }
        if ($request->tahun < 2021) {
            if ($title == "1. Maklumat Penuh Senarai Kilang Papan") {
                $statuspemilik = '0';
                $title = '1';
            } elseif ($title == "2. Senarai Pemilik Kilang Papan Bumiputera") {
                $statuspemilik = '1';
                $title = '2';
            } elseif ($title == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera") {
                $statuspemilik = '2';
                $title = '3';
            } elseif ($title == "4. Senarai Pemilik Kilang Papan Bukan Warganegara") {
                $statuspemilik = '3';
                $title = '4';
            } elseif ($title == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan") {
                $lapisvenir = '1';
                $title = '5';
            } elseif ($title == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak") {
                $title = '6';
            } elseif ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan") {
                $title = '7';
            } elseif ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina") {
                $title = '11';
            } elseif ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan") {
                $title = '12';
            } elseif ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
                $title = '13';
            } elseif ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan") {
                $title = '14';
            } elseif ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
                $title = '15';
            } elseif ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
                $title = '21';
            } elseif ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
                $title = '22';
            } elseif ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
                $title = '23';
            } elseif ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
                $title = '24';
            } elseif ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
                $title = '25';
            } elseif ($title == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
                $title = '31';
            } elseif ($title == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
                $title = '32';
            } elseif ($title == "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
                $title = '33';
            } elseif ($title == "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
                $title = '34';
            } elseif ($title == "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
                $title = '35';
            } elseif ($title == "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
                $title = '36';
            } elseif ($title == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan") {
                $title = '41';
            } elseif ($title == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri") {
                $title = '42';
            } elseif ($title == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan") {
                $title = '43';
            } elseif ($title == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan") {
                $title = '44';
            } elseif ($title == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri") {
                $title = '45';
            } elseif ($title == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa") {
                $title = '46';
            } elseif ($title == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan") {
                $title = '47';
            } elseif ($title == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri") {
                $title = '48';
            }

            //shuttle 5

            elseif ($title == "1. Maklumat Penuh Senarai Kilang Kayu Kumai") {
                $title = '301';
            } elseif ($title == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera") {
                $title = '302';
            } elseif ($title == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera") {
                $title = '303';
            } elseif ($title == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara") {
                $title = '304';
            } elseif ($title == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai") {
                $title = '305';
            } elseif ($title == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai") {
                $title = '306';
            } elseif ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai") {
                $title = '307';
            } elseif ($title == "311") {
                $title = '311';
            } elseif ($title == "312") {
                $title = '312';
            } elseif ($title == "313") {
                $title = '313';
            } elseif ($title == "314") {
                $title = '314';
            } elseif ($title == "315") {
                $title = '315';
            } elseif ($title == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
                $title = '321';
            } elseif ($title == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
                $title = '322';
            } elseif ($title == "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
                $title = '323';
            } elseif ($title == "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan") {
                $title = '324';
            } elseif ($title == "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
                $title = '325';
            } elseif ($title == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
                $title = '331';
            } elseif ($title == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
                $title = '332';
            } elseif ($title == "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan") {
                $title = '333';
            } elseif ($title == "341") {
                $title = '341';
            } elseif ($title == "342") {
                $title = '342';
            } elseif ($title == "393") {
                $title = '343';
            } elseif ($title == "343") {
                $title = '344';
            } elseif ($title == "344") {
                $title = '345';
            }

            //shuttle 4

            elseif ($title == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir") {
                $title = '201';
            } elseif ($title == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera") {
                $title = '202';
            } elseif ($title == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera") {
                $title = '203';
            } elseif ($title == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara") {
                $title = '204';
            } elseif ($title == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir") {
                $title = '205';
            } elseif ($title == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir") {
                $title = '206';
            } elseif ($title == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir") {
                $title = '207';
            } elseif ($title == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir") {
                $title = '208';
            } elseif ($title == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir") {
                $title = '209';
            } elseif ($title == "211") {
                $title = '211';
            } elseif ($title == "212") {
                $title = '212';
            } elseif ($title == "213") {
                $title = '213';
            } elseif ($title == "214") {
                $title = '214';
            } elseif ($title == "215") {
                $title = '215';
            } elseif ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan") {
                $title = '221';
            } elseif ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa") {
                $title = '222';
            } elseif ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
                $title = '223';
            } elseif ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan") {
                $title = '224';
            } elseif ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
                $title = '225';
            } elseif ($title == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan") {
                $title = '231';
            } elseif ($title == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
                $title = '232';
            } elseif ($title == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
                $title = '233';
            } elseif ($title == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa") {
                $title = '234';
            } elseif ($title == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan") {
                $title = '235';
            } elseif ($title == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan") {
                $title = '236';
            } elseif ($title == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
                $title = '237';
            } elseif ($title == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
                $title = '238';
            } elseif ($title == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan") {
                $title = '241';
            } elseif ($title == "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri") {
                $title = '242';
            } elseif ($title == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan") {
                $title = '243';
            } elseif ($title == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan") {
                $title = '244';
            } elseif ($title == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan") {
                $title = '245';
            } elseif ($title == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri") {
                $title = '246';
            } elseif ($title == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa") {
                $title = '247';
            } elseif ($title == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan") {
                $title = '248';
            } elseif ($title == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri") {
                $title = '249';
            }

            return $this->redirectLaporanLama($title, $request->tahun, $request->tahunakhir ?? 0, $request->suku_tahun ?? 0, $request->suku_tahun_akhir ?? 0, $request->spesis_lama ?? 0);
            // return redirect()->route('redirectLaporanLama', [$title, $request->tahun, $request->tahunakhir ?? 0, $request->suku_tahun ?? 0, $request->suku_tahun_akhir ?? 0, $request->spesis_lama ?? 0]);
        }
        if ($title == "1. Maklumat Penuh Senarai Kilang Papan") {
            $view =  $this->laporan_shuttle_3_1($title, $request->tahun);
        } elseif ($title == "2. Senarai Pemilik Kilang Papan Bumiputera") {
            $view =  $this->laporan_shuttle_3_2($title, $request->tahun);
            //    dd($view);
        } elseif ($title == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera") {
            $view =  $this->laporan_shuttle_3_3($title, $request->tahun);
            //    dd($view);
        } elseif ($title == "4. Senarai Pemilik Kilang Papan Bukan Warganegara") {
            $view =  $this->laporan_shuttle_3_4($title, $request->tahun);
            //    dd($view);
        } elseif ($title == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan") {
            $view =  $this->laporan_shuttle_3_5($title, $request->tahun);
            //    dd($view);
        } elseif ($title == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak") {
            //    dd("Spesis ID: " . $request->spesis . " Tahun: " . $request->tahun . " Title: " . $title);
            $view =  $this->laporan_shuttle_3_6($title, $request->tahun, $request->spesis);
        } elseif ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan") {
            $view =  $this->laporan_shuttle_3_7($title, $request->tahun);
        } elseif ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina") {
            $view =  $this->laporan_shuttle_3_11($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan") {
            $view =  $this->laporan_shuttle_3_12($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $view =  $this->laporan_shuttle_3_13($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan") {
            $view =  $this->laporan_shuttle_3_14($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $view =  $this->laporan_shuttle_3_15($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_3_21($title, $request->tahun);
        } elseif ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_3_22($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $view =  $this->laporan_shuttle_3_23($title, $request->tahun);
        } elseif ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $view =  $this->laporan_shuttle_3_24($title, $request->tahun);
        } elseif ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_3_25($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_3_31($title, $request->tahun);
        } elseif ($title == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_3_32($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $view =  $this->laporan_shuttle_3_33($title, $request->tahun);
        } elseif ($title == "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $view =  $this->laporan_shuttle_3_34($title, $request->tahun);
        } elseif ($title == "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_3_35($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_3_36($title, $request->tahun, $request->spesis);
        } elseif ($title == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan") {
            $view =  $this->laporan_shuttle_3_41($title, $request->tahun);
        } elseif ($title == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri") {
            $view =  $this->laporan_shuttle_3_42($title, $request->tahun);
        } elseif ($title == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_3_43($title, $request->tahun);
        } elseif ($title == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan") {
            $view =  $this->laporan_shuttle_3_44($title, $request->tahun);
        } elseif ($title == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri") {
            $view =  $this->laporan_shuttle_3_45($title, $request->tahun);
        } elseif ($title == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_3_46($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan") {
            $view =  $this->laporan_shuttle_3_47($title, $request->tahun);
        } elseif ($title == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri") {
            $view =  $this->laporan_shuttle_3_48($title, $request->tahun);
        }


        // Shuttle 4 - Waniiiii
        elseif ($title == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_1($title, $request->tahun);
        } elseif ($title == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera") {
            $view =  $this->laporan_shuttle_4_2($title, $request->tahun);
        } elseif ($title == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera") {
            $view =  $this->laporan_shuttle_4_3($title, $request->tahun);
        } elseif ($title == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara") {
            $view =  $this->laporan_shuttle_4_4($title, $request->tahun);
        } elseif ($title == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_5($title, $request->tahun);
        } elseif ($title == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_6($title, $request->tahun);
        } elseif ($title == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_7($title, $request->tahun, $request->spesis);
        } elseif ($title == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_8($title, $request->tahun);
        } elseif ($title == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir") {
            $view =  $this->laporan_shuttle_4_9($title, $request->tahun);
        } elseif ($title == "211") {
            $view =  $this->laporan_shuttle_4_11($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "212") {
            $view =  $this->laporan_shuttle_4_12($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "213") {
            $view =  $this->laporan_shuttle_4_13($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "214") {
            $view =  $this->laporan_shuttle_4_14($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "215") {
            $view =  $this->laporan_shuttle_4_15($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_4_21($title, $request->tahun);
        } elseif ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_22($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $view =  $this->laporan_shuttle_4_23($title, $request->tahun);
        } elseif ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $view =  $this->laporan_shuttle_4_24($title, $request->tahun);
        } elseif ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_25($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_4_31($title, $request->tahun);
        } elseif ($title == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_32($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
            $view =  $this->laporan_shuttle_4_33($title, $request->tahun);
        } elseif ($title == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_34($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan") {
            $view =  $this->laporan_shuttle_4_35($title, $request->tahun);
        } elseif ($title == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_4_36($title, $request->tahun);
        } elseif ($title == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_37($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
            $view =  $this->laporan_shuttle_4_38($title, $request->tahun);
        } elseif ($title == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan") {
            $view =  $this->laporan_shuttle_4_41($title, $request->tahun);
        } elseif ($title == "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri") {
            $view =  $this->laporan_shuttle_4_42($title, $request->tahun);
        } elseif ($title == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_4_43($title, $request->tahun);
        } elseif ($title == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_4_44($title, $request->tahun);
        } elseif ($title == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan") {
            $view =  $this->laporan_shuttle_4_45($title, $request->tahun);
        } elseif ($title == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri") {
            $view =  $this->laporan_shuttle_4_46($title, $request->tahun);
        } elseif ($title == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_4_47($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan") {
            $view =  $this->laporan_shuttle_4_48($title, $request->tahun);
        } elseif ($title == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri") {
            $view =  $this->laporan_shuttle_4_49($title, $request->tahun);
        }



        // Shuttle 5 - Waniiiiiiiiiiii
        elseif ($title == "1. Maklumat Penuh Senarai Kilang Kayu Kumai") {
            $view =  $this->laporan_shuttle_5_1($title, $request->tahun);
        } elseif ($title == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera") {
            $view =  $this->laporan_shuttle_5_2($title, $request->tahun);
        } elseif ($title == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera") {
            $view =  $this->laporan_shuttle_5_3($title, $request->tahun);
        } elseif ($title == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara") {
            $view =  $this->laporan_shuttle_5_4($title, $request->tahun);
        } elseif ($title == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai") {
            $view =  $this->laporan_shuttle_5_5($title, $request->tahun);
        } elseif ($title == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai") {
            $view =  $this->laporan_shuttle_5_6($title, $request->tahun, $request->spesis);
        } elseif ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai") {
            $view =  $this->laporan_shuttle_5_7($title, $request->tahun);
        } elseif ($title == "311") {
            $view =  $this->laporan_shuttle_5_11($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "312") {
            $view =  $this->laporan_shuttle_5_12($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "313") {
            $view =  $this->laporan_shuttle_5_13($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "314") {
            $view =  $this->laporan_shuttle_5_14($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "315") {
            $view =  $this->laporan_shuttle_5_15($title, $request->tahun, $request->suku_tahun, $request->suku_tahun_akhir);
        } elseif ($title == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_5_21($title, $request->tahun);
        } elseif ($title == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_5_22($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $view =  $this->laporan_shuttle_5_23($title, $request->tahun);
        } elseif ($title == "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $view =  $this->laporan_shuttle_5_24($title, $request->tahun);
        } elseif ($title == "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_5_25($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $view =  $this->laporan_shuttle_5_31($title, $request->tahun);
        } elseif ($title == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $view =  $this->laporan_shuttle_5_32($title, $request->tahun, $request->tahunakhir);
        } elseif ($title == "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan") {
            $view =  $this->laporan_shuttle_5_33($title, $request->tahun);
        } elseif ($title == "341") {
            $view =  $this->laporan_shuttle_5_41($title, $request->tahun);
        } elseif ($title == "342") {
            $view =  $this->laporan_shuttle_5_42($title, $request->tahun);
        } elseif ($title == "393") {
            $view =  $this->laporan_shuttle_5_43($title, $request->tahun);
        } elseif ($title == "343") {
            $view =  $this->laporan_shuttle_5_44($title, $request->tahun);
        } elseif ($title == "344") {
            $view =  $this->laporan_shuttle_5_45($title, $request->tahun);
        }

        //shuttle 4
        // elseif ($title == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir") {
        //     $view =  $this->laporan_shuttle_4_1($title);
        // }
        // $laporan=Laporan::get();

        return $view;
    }

    public function laporan_shuttle_3_1($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 3 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '3'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '3'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
            sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND form_c_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];


        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum(form_d_s.total_export_laporan)  as export,
            sum(form_d_s.jumlah_pasaran_tempatan_laporan) as domestik

            FROM
            shuttles,
            form_d_s

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_d_s.shuttle_id
            AND form_d_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_3_2($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3')->where('status_warganegara', 'Bumiputera');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bumiputera") diluluskan untuk Shuttle 3 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
        shuttles.*

        FROM
        shuttles,
        form_a_s

        WHERE shuttles.id = form_a_s.shuttle_id
        AND shuttles.shuttle_type = '3'
        AND form_a_s.status = 'Lulus'
    ");


foreach ($data_shuttles as $data_shuttle) {
    $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
    DISTINCT(shuttles.id) as shuttle_id,
    formbs.suku_tahun,

    guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
    guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
    guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
    guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
    guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
    guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

    FROM
    shuttles,
    guna_tenagas,
    formbs

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = formbs.shuttle_id
    AND guna_tenagas.shuttle_id = shuttles.id
    AND guna_tenagas.formbs_id = formbs.id
    AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                        FROM shuttles, guna_tenagas, formbs
                                        WHERE shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND guna_tenagas.shuttle_id = shuttles.id
                                        AND guna_tenagas.formbs_id = formbs.id)

    ORDER BY formbs.suku_tahun DESC
")[0];


$data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
    shuttles.id as shuttle_id,

    sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
    sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

    FROM
    shuttles,
    form_c_s,
    kemasukan_bahans

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_c_s.shuttle_id
    AND form_c_s.id = kemasukan_bahans.formcs_id
    AND form_c_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];


$data_form_d_s[$data_shuttle->id] = DB::select("SELECT
    shuttles.id,
    sum( form_d_s.total_export_laporan)  as export,
    sum( form_d_s.jumlah_pasaran_tempatan_laporan) as domestik

    FROM
    shuttles,
    form_d_s

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_d_s.shuttle_id
    AND form_d_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];

}




        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];


        $title_laporan = "2. Senarai Pemilik Kilang Papan Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_3_3($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3')->where('status_warganegara', 'Bukan Bumiputera');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bukan Bumiputera") diluluskan untuk Shuttle 3 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
        shuttles.*

        FROM
        shuttles,
        form_a_s

        WHERE shuttles.id = form_a_s.shuttle_id
        AND shuttles.shuttle_type = '3'
        AND form_a_s.status = 'Lulus'
    ");

foreach ($data_shuttles as $data_shuttle) {
    $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
    DISTINCT(shuttles.id) as shuttle_id,
    formbs.suku_tahun,

    guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
    guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
    guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
    guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
    guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
    guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

    FROM
    shuttles,
    guna_tenagas,
    formbs

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = formbs.shuttle_id
    AND guna_tenagas.shuttle_id = shuttles.id
    AND guna_tenagas.formbs_id = formbs.id
    AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                        FROM shuttles, guna_tenagas, formbs
                                        WHERE shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND guna_tenagas.shuttle_id = shuttles.id
                                        AND guna_tenagas.formbs_id = formbs.id)

    ORDER BY formbs.suku_tahun DESC
")[0];


$data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
    shuttles.id as shuttle_id,

    sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
    sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

    FROM
    shuttles,
    form_c_s,
    kemasukan_bahans

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_c_s.shuttle_id
    AND form_c_s.id = kemasukan_bahans.formcs_id
    AND form_c_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];


$data_form_d_s[$data_shuttle->id] = DB::select("SELECT
    shuttles.id,
    sum( form_d_s.total_export_laporan)  as export,
    sum( form_d_s.jumlah_pasaran_tempatan_laporan) as domestik

    FROM
    shuttles,
    form_d_s

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_d_s.shuttle_id
    AND form_d_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];

}

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',


            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "3. Senarai Pemilik Kilang Papan Bukan Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_3_4($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3')->where('status_warganegara', 'Bukan Warganegara');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bukan Warganegara") diluluskan untuk Shuttle 3 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '3'
            AND form_a_s.status = 'Lulus'
        ");

foreach ($data_shuttles as $data_shuttle) {
    $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
    DISTINCT(shuttles.id) as shuttle_id,
    formbs.suku_tahun,

    guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
    guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
    guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
    guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
    guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
    guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

    FROM
    shuttles,
    guna_tenagas,
    formbs

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = formbs.shuttle_id
    AND guna_tenagas.shuttle_id = shuttles.id
    AND guna_tenagas.formbs_id = formbs.id
    AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                        FROM shuttles, guna_tenagas, formbs
                                        WHERE shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND guna_tenagas.shuttle_id = shuttles.id
                                        AND guna_tenagas.formbs_id = formbs.id)

    ORDER BY formbs.suku_tahun DESC
")[0];


$data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
    shuttles.id as shuttle_id,

    sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
    sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

    FROM
    shuttles,
    form_c_s,
    kemasukan_bahans

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_c_s.shuttle_id
    AND form_c_s.id = kemasukan_bahans.formcs_id
    AND form_c_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];


$data_form_d_s[$data_shuttle->id] = DB::select("SELECT
    shuttles.id,
    sum( form_d_s.total_export_laporan)  as export,
    sum( form_d_s.jumlah_pasaran_tempatan_laporan) as domestik

    FROM
    shuttles,
    form_d_s

    WHERE shuttles.id = '$data_shuttle->id'
    AND shuttles.id = form_d_s.shuttle_id
    AND form_d_s.tahun = '$tahun'

    GROUP BY shuttles.id
")[0];

}





        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];


        $title_laporan = "4. Senarai Pemilik Kilang Papan Bukan Warganegara";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_3_5($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 3 untuk menjana laporan');
        }

        $datas_formc = DB::select("SELECT
                                    form_a_s.*,
                                    shuttles.*,
                                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                    sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                    FROM
                                    shuttles,
                                    form_a_s,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus

                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '3'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'

                                    AND form_a_s.status = 'Lulus'
                                    AND form_a_s.tahun = '$tahun'
                                    AND form_a_s.shuttle_id = shuttles.id

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;
        ");

        // dd($datas_formc);

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',

            // 'Nilai Harta Tetap Pada Tahun Berakhir',
            // 'Tarikh Terakhir Kemaskini',

            // 'Guna Tenaga',

            // 'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-5', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
        ));
    }

    public function laporan_shuttle_3_6($title, $tahun, $spesies)
    {
        // dd("function laporan 6");

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '3');
            })
            ->get();

        $datas_formc = DB::select("SELECT
                                    form_a_s.*,
                                    shuttles.*,
                                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                    sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                    FROM
                                    shuttles,
                                    form_a_s,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus

                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '3'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'
                                    AND spesis.id = '$spesies'

                                    AND form_a_s.status = 'Lulus'
                                    AND form_a_s.tahun = '$tahun'
                                    AND form_a_s.shuttle_id = shuttles.id

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;
        ");

        // dd($datas_formc);

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',

            // 'Nilai Harta Tetap Pada Tahun Berakhir',
            // 'Tarikh Terakhir Kemaskini',

            // 'Guna Tenaga',

            // 'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-5', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
            'spesies',
        ));
    }

    public function laporan_shuttle_3_7($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        // $datas =  DB::select("SELECT negeri_id as negeri, SUM(nilai_harta) as jumlah FROM `shuttles` GROUP BY negeri_id;");

        $datas =  DB::select("SELECT shuttles.negeri_id as negeri,
        SUM(shuttles.nilai_harta) as jumlah
        FROM shuttles, form_a_s
        WHERE form_a_s.shuttle_id = shuttles.id
        AND shuttles.shuttle_type = '3'
        AND form_a_s.status = 'Lulus'
        AND form_a_s.tahun = $tahun
        GROUP BY shuttles.negeri_id;");

        $jumlah_setiap_negeri = 0;

        foreach ($datas as $data) {
            $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
        }

        $columns = [
            'Bil',
            'Negeri',
            'Nilai Harta Tetap Pada Tahun Berakhir',
        ];

        $title_laporan = "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-7', compact(
            'title',
            'columns',
            'negeri_list',
            'datas',
            'jumlah_setiap_negeri',
            'returnArr',
            'tahun',
        ));
    }

    public function laporan_shuttle_3_11($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        // dd($suku_tahun . $suku_tahun_akhir);

        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd(" tahun : " . $tahun . " start : " . $start_date . " end : " . $end_date);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {

                $datas[$i][$negeri->negeri] = DB::select("SELECT DISTINCT(shuttles.id), shuttles.negeri_id as negeri,
                    (guna_tenagas.total_pekerja_lelaki_laporan) as total_pekerja_lelaki,
                    (guna_tenagas.total_pekerja_perempuan_laporan) as total_pekerja_perempuan,
                    (guna_tenagas.jumlah_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                    (guna_tenagas.jumlah_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                    FROM guna_tenagas, shuttles, formbs

                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                    AND formbs.shuttle_id = shuttles.id
                    AND formbs.status = 'Lulus'
                    AND formbs.suku_tahun = '$i'
                    AND formbs.tahun = '$tahun'

                    AND shuttles.shuttle_type = '3'
                    AND shuttles.negeri_id = '$negeri->negeri'
                ");
            }
        }
        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-11', compact(
            'title',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_3_12($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $datas[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(round(guna_tenagas.jumlah_lelaki_laporan)) as jumlah_lelaki,
                                        sum(round(guna_tenagas.jumlah_perempuan_laporan)) as jumlah_perempuan,
                                        sum(round(guna_tenagas.total_gaji_lelaki_laporan)) as jumlah_gaji_lelaki,
                                        sum(round(guna_tenagas.total_gaji_perempuan_laporan)) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($kategori);
        // dd($datas);

        $columns = [
            'Bil',
            'Kategori',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-12', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',

        ));
    }

    public function laporan_shuttle_3_13($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        // dd($kategori);
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {

            foreach ($kategori as $key => $data) {
                $jumlah[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                                        sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }

        foreach ($jumlah as $key => $value) {
            foreach ($value as $key => $data) {
                // dd($data[0]);
            }
        }

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-13', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'jumlah',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_3_14($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {

        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {
                $datas[$i][$negeri->negeri] = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                    sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan
                     FROM guna_tenagas,
                     shuttles,
                     formbs
                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                     AND shuttles.id = formbs.shuttle_id
                     AND shuttles.shuttle_type = '3'
                     AND formbs.status = 'Lulus'
                     AND formbs.tahun = $tahun
                     AND formbs.suku_tahun = '$i'
                     AND shuttles.negeri_id = '$negeri->negeri'
                     AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')
                     GROUP BY shuttles.negeri_id
                     ");
            }
        }

        $columns = [
            'Bil',
            'Negeri',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];


        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-14', compact(
            'title',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            // 'null_flag',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_3_15($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        // dd($jumlah_suku_tahun);

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $jumlah[$i][$key] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(round(guna_tenagas.pekerja_wargabumi_lelaki_laporan)) as jumlah_bumiputera_lelaki,
                                        sum(round(guna_tenagas.pekerja_wargabumi_perempuan_laporan)) as jumlah_bumiputera_perempuan,
                                        sum(round(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan)) as jumlah_bukan_bumiputera_lelaki,
                                        sum(round(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan)) as jumlah_bukan_bumiputera_perempuan,
                                        sum(round(guna_tenagas.pekerja_asing_lelaki_laporan)) as jumlah_bukan_warganegara_lelaki,
                                        sum(round(guna_tenagas.pekerja_asing_perempuan_laporan)) as jumlah_bukan_warganegara_perempuan,
                                        sum(round(guna_tenagas.jumlah_lelaki_laporan)) as jumlah_lelaki,
                                        sum(round(guna_tenagas.jumlah_perempuan_laporan)) as jumlah_perempuan,
                                        sum(round(guna_tenagas.total_gaji_lelaki_laporan)) as jumlah_gaji_lelaki,
                                        sum(round(guna_tenagas.total_gaji_perempuan_laporan)) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '3'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah Guna Tenaga',
            'Pendapatan (RM)',
            'Purata Pendapatan (RM)',

        ];


        $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-15', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'kategori',
            'jumlah',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    //wani side template
    public function laporan_shuttle_3_21($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan,
                    form_c_s.bulan as bulan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$month'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->jumlah_penggunaan = 0;
                    $datas[$negeri->negeri][$month][0]->bulan = $month;
                }
            }
        }
        // dd($datas);
        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah',

        ];

        $title_laporan = "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-21', compact(
            'columns',
            'title',
            'negeri_list',
            'datas',
            'returnArr',
            'tahun',
        ));
    }

    public function laporan_shuttle_3_22($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $grandtotal[$x] = 0;
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_penggunaan = 0;
                }
                $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_penggunaan;
            }
        }

        // dd($datas);

        $grandtotal[$x] = 0;
        foreach ($grandtotal as $value) {
            $grandtotal[$x] += $value;
        }

        $columns = [
            'Bil',
            'Negeri',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';



        $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-22', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'grandtotal',
            'returnArr'
        ));
    }
    public function laporan_shuttle_3_23($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    foreach ($negeri_list as $negeri) {
                        $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '3'
                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    shuttles.negeri_id
                    ;");

                        if ($data) {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri] = $data;
                        } else {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0] = (object)[];
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->negeri = $negeri->negeri;
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->jumlah_penggunaan = 0;
                        }
                    }
                }
            }
        }
        // dd($datas['KKB / HHW']['Balau']);
        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Selangor',
            'Terengganu',
            'W.P. Kuala Lumpur',
            'Jumlah (m³)',

        ];

        $title_laporan = "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-23', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'datas',
            'tahun'
        ));
    }
    public function laporan_shuttle_3_24($title, $tahun)
    {

        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($i = 1; $i < 13; $i++) {
            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan][$i] = DB::select("SELECT
                    form_c_s.bulan as bulan,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$i'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    form_c_s.bulan
                    ;");
                    }
                }
            }
        }


        // dd($datas["KKB / HHW"]["Balau"]["2"][0]);


        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-24', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'kumpulan_kayu',
        ));
    }

    public function laporan_shuttle_3_25($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $total_tahun = $tahun_akhir + 1;
        // $tahun_mula = "2018";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan] = DB::select("SELECT
                        form_c_s.tahun as tahun,
                        sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                        FROM
                        shuttles,
                        form_c_s,
                        kemasukan_bahans,
                        spesis,
                        kumpulan_kayus

                        WHERE form_c_s.shuttle_id = shuttles.id
                        AND form_c_s.id = kemasukan_bahans.formcs_id
                        AND kemasukan_bahans.spesis_id = spesis.id
                        AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                        AND shuttles.shuttle_type = '3'
                        AND form_c_s.status = 'Lulus'
                        AND kumpulan_kayus.keterangan = '$kk->keterangan'
                        AND spesis.nama_tempatan = '$sp->nama_tempatan'
                        AND kemasukan_bahans.tahun = '$x'

                        GROUP BY
                        form_c_s.tahun
                        ;");
                    }
                }
            }
        }



        // dd($datas);

        $columns = [
            'Bil',
            'Kumpulan Kayu',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-25', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'kumpulan_kayu',
            'datas',
        ));
    }

    public function laporan_shuttle_3_31($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '3'
                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                }
                else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-31', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }

    public function laporan_shuttle_3_32($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $tahun_mula . " / Tahun akhir : " . $tahun_akhir);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $grandtotal[$x] = 0;
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran = 0;
                }
                $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran;
            }
        }

        $grandtotal[$x] = 0;
        foreach ($grandtotal as $value) {
            $grandtotal[$x] += $value;
        }

        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';

        $title_laporan = "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-32', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'grandtotal',
            'returnArr'
        ));
    }
    public function laporan_shuttle_3_33($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    foreach ($negeri_list as $negeri) {

                        $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    shuttles.negeri_id
                    ;");
                        if ($data) {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri] = $data;
                        } else {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0] = (object)[];
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->negeri = $negeri->negeri;
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->jumlah_pengeluaran = 0;
                        }
                    }
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Selangor',

            'Terengganu',
            'W.P. Kuala Lumpur',
            'Jumlah (m³)',

        ];

        $title_laporan = "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-33', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'datas',
            'tahun'
        ));
    }

    public function laporan_shuttle_3_34($title, $tahun)
    {
        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($i = 1; $i < 13; $i++) {
            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan][$i] = DB::select("SELECT
                            form_c_s.bulan as bulan,
                            sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                            FROM
                            shuttles,
                            form_c_s,
                            kemasukan_bahans,
                            spesis,
                            kumpulan_kayus

                            WHERE form_c_s.shuttle_id = shuttles.id
                            AND form_c_s.id = kemasukan_bahans.formcs_id
                            AND kemasukan_bahans.spesis_id = spesis.id
                            AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                            AND shuttles.shuttle_type = '3'
                            AND form_c_s.status = 'Lulus'
                            AND form_c_s.tahun = '$tahun'
                            AND form_c_s.bulan = '$i'
                            AND kumpulan_kayus.keterangan = '$kk->keterangan'
                            AND spesis.nama_tempatan = '$sp->nama_tempatan'

                            GROUP BY
                            form_c_s.bulan
                            ;");
                    }
                }
            }
        }

        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-34', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'kumpulan_kayu',
        ));
    }
    public function laporan_shuttle_3_35($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        // $tahun_mula = "2018";

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    $datas[$kk->singkatan][$sp->nama_tempatan] = DB::select("SELECT
                    form_c_s.tahun as tahun,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '3'
                    AND form_c_s.status = 'Lulus'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'
                    AND (date(kemasukan_bahans.created_at) BETWEEN '$start_date' AND '$end_date')

                    GROUP BY
                    form_c_s.tahun
                    ;");
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Kumpulan Kayu',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-35', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'kumpulan_kayu',
            'datas',
        ));
    }
    public function laporan_shuttle_3_36($title, $tahun, $spesis)
    {
        $carian_spesis = Spesis::findorfail($spesis);

        $nama_spesis = $carian_spesis->nama_tempatan;

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        $title = str_replace("Tertentu ", "$nama_spesis ", $title);

        for ($x = 1; $x <= 12; $x++) {
            foreach ($negeri_list as $key => $negeri) {
                $datas[$negeri->negeri][$x] = DB::select("SELECT
                             shuttles.negeri_id as negeri,
                             sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran
                             FROM
                             shuttles,
                             form_c_s,
                             kemasukan_bahans
                             WHERE form_c_s.shuttle_id = shuttles.id
                             AND form_c_s.id = kemasukan_bahans.formcs_id

                             AND shuttles.shuttle_type = '3'
                             AND form_c_s.status = 'Lulus'
                             AND form_c_s.tahun = '$tahun'
                             AND form_c_s.bulan = '$x'

                             AND kemasukan_bahans.spesis_id = '$spesis'
                             AND shuttles.negeri_id = '$negeri->negeri'

                             GROUP BY
                             shuttles.negeri_id;
                ");
            }
        }

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',
        ];

        $title_laporan = "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-36', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'negeri_list',
            'nama_spesis',
            'spesis'
        ));
    }

    public function laporan_shuttle_3_41($title, $tahun)
    {
        // ganti total_export with total_export_laporan, jumlah_pasaran_tempatan with jumlah_pasaran_tempatan_laporan
        for ($i = 1; $i <= 12; $i++) {
            $data = DB::select("SELECT
            form_d_s.bulan as bulan,
            sum(form_d_s.total_export_laporan)  as export,
            sum(form_d_s.jumlah_pasaran_tempatan_laporan) as domestik,
            sum(form_d_s.total_export_laporan + form_d_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan


            FROM
            shuttles,
            form_d_s

            WHERE form_d_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '3'
            AND form_d_s.status = 'Lulus'
            AND form_d_s.tahun = '$tahun'
            AND form_d_s.bulan = '$i'
            GROUP BY
            form_d_s.bulan
            ;");

            if ($data) {
                $datas[$i] = $data;
            } else {
                $datas[$i][0] = (object)[];
                $datas[$i][0]->bulan = $i;
                $datas[$i][0]->export = 0;
                $datas[$i][0]->domestik = 0;
                $datas[$i][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);
        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];


        $columns = [
            'Bil',
            'Bulan',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "41. Jualan Domestik Kayu Gergaji Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-41', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'bulan_senarai',
            'datas',
        ));
    }


    public function laporan_shuttle_3_42($title, $tahun)
    {
        // dd($tahun);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            shuttles.negeri_id as negeri,
            sum(form_d_s.total_export_laporan)  as export,
            sum(round(form_d_s.jumlah_pasaran_tempatan_laporan)) as domestik,
            sum(form_d_s.total_export_laporan + form_d_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form_d_s

            WHERE form_d_s.shuttle_id = shuttles.id

            AND shuttles.negeri_id = '$negeri->negeri'
            AND shuttles.shuttle_type = '3'
            AND form_d_s.status = 'Lulus'
            AND form_d_s.tahun = '$tahun'

            GROUP BY
            shuttles.negeri_id
            ;");

            if ($data) {
                $datas[$negeri->negeri] = $data;
            } else {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
                $datas[$negeri->negeri][0]->export = 0;
                $datas[$negeri->negeri][0]->domestik = 0;
                $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Kayu Gergaji Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-42', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }


    public function laporan_shuttle_3_43($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(form_d_s.total_export_laporan)  as export,
                    sum(round(form_d_s.jumlah_pasaran_tempatan_laporan)) as domestik,
                    sum(form_d_s.total_export_laporan + form_d_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

                    FROM
                    shuttles,
                    form_d_s

                    WHERE form_d_s.shuttle_id = shuttles.id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '3'
                    AND form_d_s.status = 'Lulus'
                    AND form_d_s.tahun = '$tahun'
                    AND form_d_s.bulan = '$month'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->export = 0;
                    $datas[$negeri->negeri][$month][0]->domestik = 0;
                    $datas[$negeri->negeri][$month][0]->jumlah_penjualan = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri / Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-43', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',
        ));
    }

    public function laporan_shuttle_3_44($title, $tahun)
    {
        // dd("masuk");
        $pembelis = Pembeli::where('shuttle', '3')->get();

        foreach ($pembelis as $pembeli) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $datas[$pembeli->keterangan][$bulan] = DB::select("SELECT
                pembelis.keterangan as pembeli_keterangan,
                sum(ROUND(penjualan_pembelis.jumlah_jualan_laporan))  as jumlah_jualan,

                form_d_s.bulan as bulan

                FROM
                shuttles,
                form_d_s,
                penjualan_pembelis,
                pembelis

                WHERE form_d_s.shuttle_id = shuttles.id

                AND pembelis.id = $pembeli->id
                AND penjualan_pembelis.formds_id = form_d_s.id
                AND penjualan_pembelis.pembeli_id = pembelis.id

                AND shuttles.shuttle_type = '3'
                AND form_d_s.status = 'Lulus'
                AND form_d_s.tahun = '$tahun'
                AND form_d_s.bulan = '$bulan'

                GROUP BY
                pembelis.keterangan
                ;");
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Jenis Pembeli',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',
        ];

        $title_laporan = "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-44', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'pembelis'
        ));
    }


    public function laporan_shuttle_3_45($title, $tahun)
    {
        $pembeli_list = Pembeli::where('shuttle', '3')->get();

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        // dd($pembeli_list);
        foreach ($negeri_list as $negeri) {
            foreach ($pembeli_list as $pembeli) {

                $data = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(ROUND(penjualan_pembelis.jumlah_jualan_laporan))  as jumlah_jualan

                FROM
                shuttles,
                form_d_s,
                penjualan_pembelis,
                pembelis



                WHERE form_d_s.shuttle_id = shuttles.id

                AND pembelis.id = $pembeli->id
                AND form_d_s.id = penjualan_pembelis.formds_id
                AND penjualan_pembelis.pembeli_id = pembelis.id

                AND shuttles.shuttle_type = '3'
                AND form_d_s.status = 'Lulus'
                AND shuttles.negeri_id = '$negeri->negeri'
                AND form_d_s.tahun = '$tahun'

                GROUP BY
                shuttles.negeri_id
                ;");

                if ($data) {
                    $datas[$pembeli->keterangan][$negeri->negeri] = $data;
                } else {
                    $datas[$pembeli->keterangan][$negeri->negeri][0] = (object)[];
                    $datas[$pembeli->keterangan][$negeri->negeri][0]->negeri = $negeri->negeri;
                    $datas[$pembeli->keterangan][$negeri->negeri][0]->jumlah_jualan = 0;
                }
            }
        }

        // dd($datas);


        $columns = [
            'Bil',
            'Jenis Pembeli',
        ];

        foreach ($negeri_list as $negeri) {
            $columns[] = $negeri->negeri;
        }

        $columns[] = 'Jumlah (m³)';

        // dd($columns);

        $title_laporan = "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];


        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-45', compact(
            'columns',
            'title',
            'returnArr',
            'pembeli_list',
            'datas',
            'negeri_list',
            'tahun',
        ));
    }


    public function laporan_shuttle_3_46($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }


        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";


        $pembeli_list = Pembeli::where('shuttle', '3')->get();

        foreach ($pembeli_list as $pembeli) {
            for ($curr_year = $tahun_mula; $curr_year <= $tahun_akhir; $curr_year++) {

                $datas[$pembeli->keterangan][$curr_year] =
                    DB::select("SELECT
                    pembelis.keterangan as pembeli_keterangan,
                    sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as jumlah_jualan

                    FROM
                    shuttles,
                    form_d_s,
                    penjualan_pembelis,
                    pembelis


                    WHERE form_d_s.shuttle_id = shuttles.id
                    AND pembelis.id = $pembeli->id
                    AND form_d_s.id = penjualan_pembelis.formds_id
                    AND penjualan_pembelis.pembeli_id = pembelis.id

                    AND shuttles.shuttle_type = '3'
                    AND form_d_s.status = 'Lulus'
                    AND form_d_s.tahun = '$curr_year'

                    GROUP BY
                    shuttles.negeri_id
            ;");
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Jenis Pembeli',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';

        $title_laporan = "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-46', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'pembeli_list',
            'datas',

        ));
    }

    public function laporan_shuttle_3_47($title, $tahun)
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $datas[$bulan] = DB::select("SELECT
            shuttles.negeri_id as negeri,
            sum(round(form_d_s.total_export_laporan))  as export,
            sum(form_d_s.jumlah_pasaran_tempatan_laporan) as domestik,
            sum(form_d_s.total_export_laporan + form_d_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form_d_s

            WHERE form_d_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '3'
            AND form_d_s.status = 'Lulus'
            AND form_d_s.tahun = '$tahun'
            AND form_d_s.bulan = '$bulan'

            GROUP BY
            shuttles.negeri_id
            ;");
        }

        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];

        // dd($datas);



        $columns = [
            'Bil',
            'Bulan',
            'Kayu Gergaji (m³)',
        ];

        $title_laporan = "47. Jualan Eksport Kayu Gergaji Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-47', compact(
            'columns',
            'title',
            'returnArr',
            'datas',
            'bulan_senarai',
            'tahun',

        ));
    }

    public function laporan_shuttle_3_48($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {
            $datas[$negeri->negeri] = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(round(form_d_s.total_export_laporan))  as export,
                sum(form_d_s.jumlah_pasaran_tempatan_laporan) as domestik,
                sum(form_d_s.total_export_laporan + form_d_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

                FROM
                shuttles,
                form_d_s

                WHERE form_d_s.shuttle_id = shuttles.id

                AND shuttles.shuttle_type = '3'
                AND form_d_s.status = 'Lulus'
                AND form_d_s.tahun = '$tahun'
                AND shuttles.negeri_id = '$negeri->negeri'

                GROUP BY
                shuttles.negeri_id
            ;");
        }

        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',

        ];

        $title_laporan = "48. Jualan Eksport Kayu Gergaji Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];
        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle3-48', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',

        ));
    }

    //Shuttle 4 - Waniiiiiii
    public function laporan_shuttle_4_1($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '4'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        //form 4 c
        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.baki_stok_kehadapan) as baki_stok_kehadapan,
            sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND shuttles.shuttle_type = '4'
            AND form_c_s.status = 'Lulus'
            AND form_c_s.tahun = '$tahun'



            GROUP BY shuttles.id
        ")[0];


        //produk pengeluaran
        $produk_pengeluaran[$data_shuttle->id] = DB::select("SELECT
            shuttles.id ,
            sum( distinct produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
            sum( distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
            sum( distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
            sum( distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
            sum( distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
            sum( distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

            FROM
            produk_pengeluarans,
            shuttles,
            form4_d_s

            -- WHERE form4_d_s.shuttle_id = '$data_shuttle->id'
            WHERE shuttles.id  = '$data_shuttle->id'
            AND shuttles.id = form4_d_s.shuttle_id
            AND produk_pengeluarans.form4ds_id = form4_d_s.id
            AND shuttles.shuttle_type = '4'
            AND form4_d_s.status = 'Lulus'
            AND form4_d_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        // dd($produk_pengeluaran);

        //rekod_muka
        $rekod_muka[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
            sum(form4_d_s.rekod_venierteras) as rekod_venierteras

            FROM
            shuttles,
            form4_d_s

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form4_d_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form4_d_s.status = 'Lulus'
            AND form4_d_s.tahun = '$tahun'


            GROUP BY shuttles.id
        ")[0];


        //datas_formd
        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
            sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
            sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form4_e_s

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form4_e_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'


            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Stok Semasa Kayu Balak',
            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
            'Jumlah Pengeluaran Venir Mengikut Jenis',

            'Jualan Eksport',
            'Jualan Tempatan',
        ];

        $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'produk_pengeluaran',
            'rekod_muka',
            'data_form_d_s',

        ));
    }

    public function laporan_shuttle_4_2($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4')->where('status_warganegara', 'Bumiputera');

            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '4'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        //form 4 c
        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.baki_stok_kehadapan) as baki_stok_kehadapan,
            sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND shuttles.shuttle_type = '4'
            AND form_c_s.status = 'Lulus'
            AND form_c_s.tahun = '$tahun'



            GROUP BY shuttles.id
        ")[0];


        //produk pengeluaran
        $produk_pengeluaran[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum( distinct produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
            sum( distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
            sum( distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
            sum( distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
            sum( distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
            sum( distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

            FROM
            produk_pengeluarans,
            shuttles,
            form4_d_s

            WHERE form4_d_s.shuttle_id = shuttles.id
            AND produk_pengeluarans.form4ds_id = form4_d_s.id
            AND shuttles.shuttle_type = '4'
            AND form4_d_s.status = 'Lulus'
            AND form4_d_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        //rekod_muka
        $rekod_muka[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
            sum(form4_d_s.rekod_venierteras) as rekod_venierteras

            FROM
            shuttles,
            form4_d_s

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form4_d_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form4_d_s.status = 'Lulus'
            AND form4_d_s.tahun = '$tahun'


            GROUP BY shuttles.id
        ")[0];


        //datas_formd
        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id,
            sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
            sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
            sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form4_e_s

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form4_e_s.shuttle_id
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'


            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Stok Semasa Kayu Balak',
            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
            'Jumlah Pengeluaran Venir Mengikut Jenis',

            'Jualan Eksport',
            'Jualan Tempatan',
        ];

        $title_laporan = "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'produk_pengeluaran',
            'rekod_muka',
            'data_form_d_s',
        ));
    }

    public function laporan_shuttle_4_3($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4')->where('status_warganegara', 'Bukan Bumiputera');
            })
            ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
            }

            $data_shuttles = DB::select("SELECT
                shuttles.*

                FROM
                shuttles,
                form_a_s

                WHERE shuttles.id = form_a_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form_a_s.status = 'Lulus'
            ");


            foreach ($data_shuttles as $data_shuttle) {
                $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
                DISTINCT(shuttles.id) as shuttle_id,
                formbs.suku_tahun,

                guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
                guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
                guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
                guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
                guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
                guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

                FROM
                shuttles,
                guna_tenagas,
                formbs

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = formbs.shuttle_id
                AND guna_tenagas.shuttle_id = shuttles.id
                AND guna_tenagas.formbs_id = formbs.id
                AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                    FROM shuttles, guna_tenagas, formbs
                                                    WHERE shuttles.id = formbs.shuttle_id
                                                    AND shuttles.shuttle_type = '4'
                                                    AND guna_tenagas.shuttle_id = shuttles.id
                                                    AND guna_tenagas.formbs_id = formbs.id)

                ORDER BY formbs.suku_tahun DESC
            ")[0];


            //form 4 c
            $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
                shuttles.id as shuttle_id,

                sum(kemasukan_bahans.baki_stok_kehadapan) as baki_stok_kehadapan,
                sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

                FROM
                shuttles,
                form_c_s,
                kemasukan_bahans

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form_c_s.shuttle_id
                AND form_c_s.id = kemasukan_bahans.formcs_id
                AND shuttles.shuttle_type = '4'
                AND form_c_s.status = 'Lulus'
                AND form_c_s.tahun = '$tahun'



                GROUP BY shuttles.id
            ")[0];


            //produk pengeluaran
            $produk_pengeluaran[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum( distinct produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
                sum( distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
                sum( distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                sum( distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                sum( distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                sum( distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

                FROM
                produk_pengeluarans,
                shuttles,
                form4_d_s

                WHERE form4_d_s.shuttle_id = shuttles.id
                AND produk_pengeluarans.form4ds_id = form4_d_s.id
                AND shuttles.shuttle_type = '4'
                AND form4_d_s.status = 'Lulus'
                AND form4_d_s.tahun = '$tahun'

                GROUP BY shuttles.id
            ")[0];

            //rekod_muka
            $rekod_muka[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
                sum(form4_d_s.rekod_venierteras) as rekod_venierteras

                FROM
                shuttles,
                form4_d_s

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form4_d_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form4_d_s.status = 'Lulus'
                AND form4_d_s.tahun = '$tahun'


                GROUP BY shuttles.id
            ")[0];


            //datas_formd
            $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
                sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
                sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
                sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
                sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

                FROM
                shuttles,
                form4_e_s

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form4_e_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$tahun'


                GROUP BY shuttles.id
            ")[0];

            }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Stok Semasa Kayu Balak',
            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
            'Jumlah Pengeluaran Venir Mengikut Jenis',

            'Jualan Eksport',
            'Jualan Tempatan',
        ];

        $title_laporan = "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'produk_pengeluaran',
            'rekod_muka',
            'data_form_d_s',
        ));
    }
    public function laporan_shuttle_4_4($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4')->where('status_warganegara', 'Bukan Warganegara');
            })
            ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
            }

            $data_shuttles = DB::select("SELECT
                shuttles.*

                FROM
                shuttles,
                form_a_s

                WHERE shuttles.id = form_a_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form_a_s.status = 'Lulus'
            ");


            foreach ($data_shuttles as $data_shuttle) {
                $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
                DISTINCT(shuttles.id) as shuttle_id,
                formbs.suku_tahun,

                guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
                guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
                guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
                guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
                guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
                guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

                FROM
                shuttles,
                guna_tenagas,
                formbs

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = formbs.shuttle_id
                AND guna_tenagas.shuttle_id = shuttles.id
                AND guna_tenagas.formbs_id = formbs.id
                AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                    FROM shuttles, guna_tenagas, formbs
                                                    WHERE shuttles.id = formbs.shuttle_id
                                                    AND shuttles.shuttle_type = '4'
                                                    AND guna_tenagas.shuttle_id = shuttles.id
                                                    AND guna_tenagas.formbs_id = formbs.id)

                ORDER BY formbs.suku_tahun DESC
            ")[0];


            //form 4 c
            $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
                shuttles.id as shuttle_id,

                sum(kemasukan_bahans.baki_stok_kehadapan) as baki_stok_kehadapan,
                sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

                FROM
                shuttles,
                form_c_s,
                kemasukan_bahans

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form_c_s.shuttle_id
                AND form_c_s.id = kemasukan_bahans.formcs_id
                AND shuttles.shuttle_type = '4'
                AND form_c_s.status = 'Lulus'
                AND form_c_s.tahun = '$tahun'



                GROUP BY shuttles.id
            ")[0];


            //produk pengeluaran
            $produk_pengeluaran[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum( distinct produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
                sum( distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
                sum( distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                sum( distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                sum( distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                sum( distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

                FROM
                produk_pengeluarans,
                shuttles,
                form4_d_s

                WHERE form4_d_s.shuttle_id = shuttles.id
                AND produk_pengeluarans.form4ds_id = form4_d_s.id
                AND shuttles.shuttle_type = '4'
                AND form4_d_s.status = 'Lulus'
                AND form4_d_s.tahun = '$tahun'

                GROUP BY shuttles.id
            ")[0];

            //rekod_muka
            $rekod_muka[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
                sum(form4_d_s.rekod_venierteras) as rekod_venierteras

                FROM
                shuttles,
                form4_d_s

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form4_d_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form4_d_s.status = 'Lulus'
                AND form4_d_s.tahun = '$tahun'


                GROUP BY shuttles.id
            ")[0];


            //datas_formd
            $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
                shuttles.id,
                sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
                sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
                sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
                sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
                sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

                FROM
                shuttles,
                form4_e_s

                WHERE shuttles.id = '$data_shuttle->id'
                AND shuttles.id = form4_e_s.shuttle_id
                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$tahun'


                GROUP BY shuttles.id
            ")[0];

            }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Stok Semasa Kayu Balak',
            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
            'Jumlah Pengeluaran Venir Mengikut Jenis',

            'Jualan Eksport',
            'Jualan Tempatan',
        ];

        $title_laporan = "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'produk_pengeluaran',
            'rekod_muka',
            'data_form_d_s',
        ));
    }

    public function laporan_shuttle_4_5($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
        }

        $datas_formc = DB::select("SELECT
                                form_a_s.*,
                                    shuttles.*,
                                sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                FROM
                                shuttles,
                                form_a_s,
                                form_c_s,
                                kemasukan_bahans,
                                spesis,
                                kumpulan_kayus

                                WHERE form_c_s.shuttle_id = shuttles.id
                                AND form_c_s.id = kemasukan_bahans.formcs_id
                                AND kemasukan_bahans.spesis_id = spesis.id
                                AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                AND shuttles.shuttle_type = '4'
                                AND form_c_s.status = 'Lulus'
                                AND form_c_s.tahun = '$tahun'

                                GROUP BY
                                shuttles.id

                                ORDER BY
                                jumlah_pengeluaran DESC;
    ");

        $produk_pengeluaran = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(distinct produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
                                    sum(distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
                                    sum(distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                                    sum(distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                                    sum(distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                                    sum(distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp



                                    FROM
                                    shuttles,
                                    produk_pengeluarans,
                                    form4_d_s


                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND produk_pengeluarans.form4ds_id = form4_d_s.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;
        ");

        $rekod_muka = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
                                    sum(form4_d_s.rekod_venierteras) as rekod_venierteras

                                    FROM
                                    shuttles,
                                    form4_d_s

                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;

        ");

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
        ];

        $title_laporan = "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-5', compact(
            'title',
            'title_laporan',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
            'produk_pengeluaran',
            'rekod_muka'
        ));
    }

    public function laporan_shuttle_4_6($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
        }

        $datas_formc = DB::select("SELECT
                                form_a_s.*,
                                    shuttles.*,
                                sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                FROM
                                shuttles,
                                form_a_s,
                                form_c_s,
                                kemasukan_bahans,
                                spesis,
                                kumpulan_kayus

                                WHERE form_c_s.shuttle_id = shuttles.id
                                AND form_c_s.id = kemasukan_bahans.formcs_id
                                AND kemasukan_bahans.spesis_id = spesis.id
                                AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                AND shuttles.shuttle_type = '4'
                                AND form_c_s.status = 'Lulus'
                                AND form_c_s.tahun = '$tahun'

                                GROUP BY
                                shuttles.id

                                ORDER BY
                                jumlah_pengeluaran DESC;
    ");

        $produk_pengeluaran = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
                                    sum(produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
                                    sum(produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                                    sum(produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                                    sum(produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                                    sum(produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp



                                    FROM
                                    shuttles,
                                    produk_pengeluarans,
                                    form4_d_s


                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND produk_pengeluarans.form4ds_id = form4_d_s.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;
        ");

        $rekod_muka = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
                                    sum(form4_d_s.rekod_venierteras) as rekod_venierteras

                                    FROM
                                    shuttles,
                                    form4_d_s

                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;

        ");

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Jumlah Pengeluaran Venir Mengikut Jenis'
        ];

        $title_laporan = "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-6', compact(
            'title',
            'title_laporan',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
            'produk_pengeluaran',
            'rekod_muka'
        ));
    }

    public function laporan_shuttle_4_7($title, $tahun, $spesies)
    {
        // dd( $spesies);

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        $datas_formc = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                                    FROM
                                    shuttles,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus

                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '4'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'
                                    AND spesis.id = '$spesies'

                                    GROUP BY
                                    shuttles.id;
        ");

        // dd($datas_formc);

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',

            // 'Nilai Harta Tetap Pada Tahun Berakhir',
            // 'Tarikh Terakhir Kemaskini',

            // 'Guna Tenaga',

            // 'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Balak',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-7', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
            'spesies',
        ));
    }

    public function laporan_shuttle_4_8($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 4 untuk menjana laporan');
        }

        $form_b = FormB::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '4');
            })
            ->get();

        $guna_tenaga = GunaTenaga::where('tahun', $tahun)->get();

        $datas_formc = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                    sum(kemasukan_bahans.baki_stok_kehadapan) as baki_stok_kehadapan

                                    FROM
                                    shuttles,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus


                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '4'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'


                                    GROUP BY
                                    shuttles.id;
        ");

        $produk_pengeluaran = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(produk_pengeluarans.jumlah_besar_mr)  as jumlah_besar_mr,
                                    sum(produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp,
                                    sum(produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                                    sum(produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                                    sum(produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                                    sum(produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp



                                    FROM
                                    shuttles,
                                    produk_pengeluarans,
                                    form4_d_s


                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND produk_pengeluarans.form4ds_id = form4_d_s.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id;
        ");

        $rekod_muka = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(form4_d_s.rekod_veniermuka)  as rekod_veniermuka,
                                    sum(form4_d_s.rekod_venierteras) as rekod_venierteras

                                    FROM
                                    shuttles,
                                    form4_d_s

                                    WHERE form4_d_s.shuttle_id = shuttles.id
                                    AND shuttles.shuttle_type = '4'
                                    AND form4_d_s.status = 'Lulus'
                                    AND form4_d_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id;

        ");

        $datas_formd = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(form4_e_s.total_export_laporan)  as export_papan_lapis,
                                    sum(form4_e_s.jumlah_venier_eksport_laporan)  as export_venier,
                                    sum(form4_e_s.jumlah_pasaran_tempatan_laporan) as domestik_papan_lapis,
                                    sum(form4_e_s.jumlah_venier_tempatan_laporan) as domestik_venier,
                                    sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

                                    FROM
                                    shuttles,
                                    form4_e_s

                                    WHERE form4_e_s.shuttle_id = shuttles.id

                                    AND shuttles.shuttle_type = '4'
                                    AND form4_e_s.status = 'Lulus'
                                    AND form4_e_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id;
        ");

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran Syarikat (SSM)',
            'No. Lesen JPSM',
            'No. Telefon',
            'No. Faks',
            'Emel',

            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik Syarikat',
            'Nilai Harta Tetap Pada Tahun Berakhir'
        ];

        $title_laporan = "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-8', compact(
            'title',
            'columns',
            'shuttle',
            'form_b',
            'tahun',
            'guna_tenaga',
            'returnArr',
            'datas_formc',
            'datas_formd',
            'tahun',
            'produk_pengeluaran',
            'rekod_muka'
        ));
    }

    public function laporan_shuttle_4_9($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        // $datas =  DB::select("SELECT negeri_id as negeri, SUM(nilai_harta) as jumlah FROM `shuttles` GROUP BY negeri_id;");

        $datas =  DB::select("SELECT shuttles.negeri_id as negeri,
        SUM(shuttles.nilai_harta) as jumlah
        FROM shuttles, form_a_s
        WHERE form_a_s.shuttle_id = shuttles.id
        AND shuttles.shuttle_type = '4'
        AND form_a_s.status = 'Lulus'
        AND form_a_s.tahun = $tahun
        GROUP BY shuttles.negeri_id;");

        $jumlah_setiap_negeri = 0;

        foreach ($datas as $data) {
            $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
        }

        $columns = [
            'Bil',
            'Negeri',
            'Nilai Harta Tetap Pada Tahun Berakhir',
        ];

        $title_laporan = "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-9', compact(
            'title',
            'columns',
            'negeri_list',
            'datas',
            'jumlah_setiap_negeri',
            'returnArr',
            'tahun',
        ));
    }

    public function laporan_shuttle_4_11($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        // dd($suku_tahun . $suku_tahun_akhir);

        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd(" tahun : " . $tahun . " start : " . $start_date . " end : " . $end_date);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {

                $datas[$i][$negeri->negeri] = DB::select("SELECT DISTINCT(shuttles.id), shuttles.negeri_id as negeri,
                    (guna_tenagas.total_pekerja_lelaki_laporan) as total_pekerja_lelaki,
                    (guna_tenagas.total_pekerja_perempuan_laporan) as total_pekerja_perempuan,
                    (guna_tenagas.jumlah_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                    (guna_tenagas.jumlah_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                    FROM guna_tenagas, shuttles, formbs

                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                    AND formbs.shuttle_id = shuttles.id
                    AND formbs.status = 'Lulus'
                    AND formbs.suku_tahun = '$i'
                    AND formbs.tahun = '$tahun'

                    AND shuttles.shuttle_type = '4'
                    AND shuttles.negeri_id = '$negeri->negeri'
                ");
            }
        }

        $columns = [
            'Bil',
            'Negeri',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Lapis/Venir Mengikut Negeri Dan Jantina";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-11', compact(
            'title',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
            // 'datas_ktn',
            // 'datas_jhr',
            // 'datas_kdh',
            // 'datas_phg',
            // 'datas_pls',
            // 'datas_kl',
            // 'datas_ns',
            // 'datas_slg',
            // 'datas_trg',
            // 'datas_pp',
            // 'datas_mlk',
            // 'datas_prk'
        ));
    }

    public function laporan_shuttle_4_12($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $datas[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.jumlah_lelaki_laporan) as jumlah_lelaki,
                                        sum(guna_tenagas.jumlah_perempuan_laporan) as jumlah_perempuan,
                                        sum(guna_tenagas.total_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                                        sum(guna_tenagas.total_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '4'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($kategori);
        // dd($datas);

        $columns = [
            'Bil',
            'Kategori',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-12', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_4_13($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        // dd($kategori);
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {

            foreach ($kategori as $key => $data) {
                $jumlah[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                                        sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '4'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')


                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }

        foreach ($jumlah as $key => $value) {
            foreach ($value as $key => $data) {
                // dd($data[0]);
            }
        }

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-13', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'jumlah',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_4_14($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {

        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {
                $datas[$i][$negeri->negeri] = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                    sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan
                     FROM guna_tenagas,
                     shuttles,
                     formbs
                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                     AND shuttles.id = formbs.shuttle_id
                     AND shuttles.shuttle_type = '4'
                     AND formbs.status = 'Lulus'
                     AND formbs.tahun = $tahun
                     AND formbs.suku_tahun = '$i'
                     AND shuttles.negeri_id = '$negeri->negeri'
                     AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                     GROUP BY shuttles.negeri_id
                     ");
            }
        }

        $columns = [
            'Bil',
            'Negeri',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];


        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-14', compact(
            'title',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            // 'null_flag',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_4_15($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        // dd($jumlah_suku_tahun);

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $jumlah[$i][$key] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                                        sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan,
                                        sum(guna_tenagas.jumlah_lelaki_laporan) as jumlah_lelaki,
                                        sum(guna_tenagas.jumlah_perempuan_laporan) as jumlah_perempuan,
                                        sum(guna_tenagas.total_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                                        sum(guna_tenagas.total_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '4'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')


                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah Guna Tenaga',
            'Pendapatan (RM)',
            'Purata Pendapatan (RM)',

        ];


        $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-15', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'kategori',
            'jumlah',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_4_21($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                    form_c_s.bulan as bulan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$month'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->jumlah_penggunaan = 0;
                    $datas[$negeri->negeri][$month][0]->bulan = $month;
                }
            }
        }
        // dd($datas);
        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah',

        ];

        $title_laporan = "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-21', compact(
            'columns',
            'title',
            'negeri_list',
            'datas',
            'returnArr',
            'tahun',
        ));
    }

    public function laporan_shuttle_4_22($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $grandtotal[$x] = 0;
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_penggunaan = 0;
                }
                $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_penggunaan;
            }
        }

        $grandtotal[$x] = 0;
        foreach ($grandtotal as $value) {
            $grandtotal[$x] += $value;
        }

        $columns = [
            'Bil',
            'Negeri',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';



        $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-22', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'grandtotal',
            'returnArr'
        ));
    }

    public function laporan_shuttle_4_23($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    foreach ($negeri_list as $negeri) {
                        $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '4'
                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    shuttles.negeri_id
                    ;");

                        if ($data) {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri] = $data;
                        } else {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0] = (object)[];
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->negeri = $negeri->negeri;
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->jumlah_penggunaan = 0;
                        }
                    }
                }
            }
        }
        // dd($datas['KKB / HHW']['Balau']);
        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Selangor',
            'Terengganu',
            'W.P. Kuala Lumpur',
            'Jumlah (m³)',

        ];

        $title_laporan = "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-23', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'datas',
            'tahun'
        ));
    }

    public function laporan_shuttle_4_24($title, $tahun)
    {

        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($i = 1; $i < 13; $i++) {
            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan][$i] = DB::select("SELECT
                    form_c_s.bulan as bulan,
                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '4'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$i'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    form_c_s.bulan
                    ;");
                    }
                }
            }
        }


        // dd($datas["KKB / HHW"]["Balau"]["2"][0]);


        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-24', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'kumpulan_kayu',
        ));
    }

    public function laporan_shuttle_4_25($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $total_tahun = $tahun_akhir + 1;
        // $tahun_mula = "2018";
        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {

            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan] = DB::select("SELECT
                    form_c_s.tahun as tahun,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '4'
                    AND form_c_s.status = 'Lulus'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'
                    AND kemasukan_bahans.tahun = '$x'

                    GROUP BY
                    form_c_s.tahun
                    ;");
                    }
                }
            }
        }


        // dd($datas);

        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-25', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'kumpulan_kayu',
            'datas',
        ));
    }

    public function laporan_shuttle_4_31($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct produk_pengeluarans.jumlah_besar_mr) as jumlah_besar_mr,
                    sum(distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_besar_mr = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_besar_wbp = 0;
                }
            }
        }

        // dd($data);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-31', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }

    public function laporan_shuttle_4_32($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $tahun_mula . " / Tahun akhir : " . $tahun_akhir);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(distinct produk_pengeluarans.jumlah_besar_mr) as jumlah_besar_mr,
                    sum(distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                // dd($data);

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_besar_mr = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_besar_wbp = 0;
                }
                // $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran;
            }
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
            $grandtotal->jumlahpengeluaran['mr'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['wbp'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
                $grandtotal->jumlahpengeluaran['mr'][$gi] += (float)$result[$gi][0]->jumlah_besar_mr;
                $grandtotal->jumlahpengeluaran['wbp'][$gi] += (float)$result[$gi][0]->jumlah_besar_wbp;
            }
        }


        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Jenis'
        ];

        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';

        $title_laporan = "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-32', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'returnArr',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_33($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct produk_pengeluarans.jumlah_besar_mr) as jumlah_besar_mr,
                    sum(distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_besar_mr = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_besar_wbp = 0;
                }
            }
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 12; $gi++) {
            $grandtotal->jumlahpengeluaran['mr'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['wbp'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jumlahpengeluaran['mr'][$gi] += (float)$result[$gi][0]->jumlah_besar_mr;
                $grandtotal->jumlahpengeluaran['wbp'][$gi] += (float)$result[$gi][0]->jumlah_besar_wbp;
            }
        }

        // dd($grandtotal);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Jenis',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-33', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_34($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $tahun_mula . " / Tahun akhir : " . $tahun_akhir);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                    sum(distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                    sum(distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                    sum(distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                // dd($data);

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_kecil_1_mr = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_kecil_1_wbp = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_kecil_2_mr = 0;
                    $datas[$negeri->negeri][$x][0]->jumlah_kecil_2_wbp = 0;
                }
                // $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran;
            }
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
            $grandtotal->jumlahpengeluaran['nipis'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['tebal'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
                $grandtotal->jumlahpengeluaran['nipis'][$gi] += (float)$result[$gi][0]->jumlah_kecil_1_mr + $result[$gi][0]->jumlah_kecil_1_wbp;
                $grandtotal->jumlahpengeluaran['tebal'][$gi] += (float)$result[$gi][0]->jumlah_kecil_2_mr + $result[$gi][0]->jumlah_kecil_2_wbp;
            }
        }


        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Ketebalan'
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';

        $title_laporan = "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-34', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'returnArr',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_35($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct produk_pengeluarans.jumlah_kecil_1_mr) as jumlah_kecil_1_mr,
                    sum(distinct produk_pengeluarans.jumlah_kecil_1_wbp) as jumlah_kecil_1_wbp,
                    sum(distinct produk_pengeluarans.jumlah_kecil_2_mr) as jumlah_kecil_2_mr,
                    sum(distinct produk_pengeluarans.jumlah_kecil_2_wbp) as jumlah_kecil_2_wbp

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_kecil_1_mr = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_kecil_1_wbp = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_kecil_2_mr = 0;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_kecil_2_wbp = 0;
                }
            }
        }


        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 12; $gi++) {
            $grandtotal->jumlahpengeluaran['nipis'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['tebal'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jumlahpengeluaran['nipis'][$gi] += (float)$result[$gi][0]->jumlah_kecil_1_mr + $result[$gi][0]->jumlah_kecil_1_wbp;
                $grandtotal->jumlahpengeluaran['tebal'][$gi] += (float)$result[$gi][0]->jumlah_kecil_2_mr + $result[$gi][0]->jumlah_kecil_2_wbp;
            }
        }

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Ketebalan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-35', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_36($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct form4_d_s.jumlah_pengeluaran) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "36. Pengeluaran Venir Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-36', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }

    public function laporan_shuttle_4_37($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $tahun_mula . " / Tahun akhir : " . $tahun_akhir);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(distinct form4_d_s.rekod_veniermuka) as rekod_veniermuka,
                    sum(distinct form4_d_s.rekod_venierteras) as rekod_venierteras


                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                // dd($data);

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$x][0]->rekod_veniermuka = 0;
                    $datas[$negeri->negeri][$x][0]->rekod_venierteras = 0;
                }
                // $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran;
            }
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
            $grandtotal->jumlahpengeluaran['muka'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['teras'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = $tahun_mula; $gi <= $tahun_akhir; $gi++) {
                $grandtotal->jumlahpengeluaran['muka'][$gi] += (float)$result[$gi][0]->rekod_veniermuka;
                $grandtotal->jumlahpengeluaran['teras'][$gi] += (float)$result[$gi][0]->rekod_venierteras;
            }
        }


        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Jenis'
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        // $columns[] = 'Jumlah (m³)';

        $title_laporan = "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-37', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'returnArr',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_38($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct form4_d_s.rekod_veniermuka) as rekod_veniermuka,
                    sum(distinct form4_d_s.rekod_venierteras) as rekod_venierteras

                    FROM
                    shuttles,
                    form4_d_s,
                    produk_pengeluarans

                    WHERE form4_d_s.shuttle_id = shuttles.id
                    AND form4_d_s.id = produk_pengeluarans.form4ds_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                    $datas[$negeri->negeri][$bulan][0]->rekod_veniermuka = 0;
                    $datas[$negeri->negeri][$bulan][0]->rekod_venierteras = 0;
                }
            }
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 12; $gi++) {
            $grandtotal->jumlahpengeluaran['muka'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['teras'][$gi] = 0;
        }

        foreach ($datas as $result) {
            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jumlahpengeluaran['muka'][$gi] += (float)$result[$gi][0]->rekod_veniermuka;
                $grandtotal->jumlahpengeluaran['teras'][$gi] += (float)$result[$gi][0]->rekod_venierteras;
            }
        }

        // dd($grandtotal);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Jenis',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-38', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
            'grandtotal'
        ));
    }

    public function laporan_shuttle_4_41($title, $tahun)
    {
        // ganti total_export with total_export_laporan, jumlah_pasaran_tempatan with jumlah_pasaran_tempatan_laporan
        for ($i = 1; $i <= 12; $i++) {
            $data = DB::select("SELECT
            form4_e_s.bulan as bulan,
            sum(round(penjualan_pembelis.jumlah_jualan)) as domestik_papan_lapis,
            (round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier

            FROM
            shuttles,
            form4_e_s,
            penjualan_pembelis,
            pembelis

            WHERE form4_e_s.shuttle_id = shuttles.id

            AND penjualan_pembelis.form4es_id = form4_e_s.id
            AND penjualan_pembelis.pembeli_id = pembelis.id
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'
            AND form4_e_s.bulan = '$i'
            GROUP BY
            form4_e_s.bulan
            ;");

            if ($data) {
                $datas[$i] = $data;
            } else {
                $datas[$i][0] = (object)[];
                $datas[$i][0]->bulan = $i;
                $datas[$i][0]->export = 0;
                $datas[$i][0]->domestik_papan_lapis = 0;
                $datas[$i][0]->domestik_venier = 0;
                $datas[$i][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);


        // for ($i = 1; $i <= 12; $i++) {
        //     $data = DB::select("SELECT
        //     form4_e_s.bulan as bulan,
        //     sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
        //     sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
        //     sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
        //     sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
        //     sum(round(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan)) as jumlah_penjualan

        //     FROM
        //     shuttles,
        //     form4_e_s

        //     WHERE form4_e_s.shuttle_id = shuttles.id

        //     AND shuttles.shuttle_type = '4'
        //     AND form4_e_s.status = 'Lulus'
        //     AND form4_e_s.tahun = '$tahun'
        //     AND form4_e_s.bulan = '$i'
        //     GROUP BY
        //     form4_e_s.bulan
        //     ;");

        //     if ($data) {
        //         $datas[$i] = $data;
        //     } else {
        //         $datas[$i][0] = (object)[];
        //         $datas[$i][0]->bulan = $i;
        //         $datas[$i][0]->export = 0;
        //         $datas[$i][0]->domestik_papan_lapis = 0;
        //         $datas[$i][0]->domestik_venier = 0;
        //         $datas[$i][0]->jumlah_penjualan = 0;
        //     }
        // }



        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];


        $columns = [
            'Bil',
            'Bulan',
            'Papan Lapis (m³)',
            'Venir (m³)',
        ];


        $title_laporan = "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-41', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'bulan_senarai',
            'datas',
        ));
    }

    public function laporan_shuttle_4_42($title, $tahun)
    {
        // dd($tahun);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            form4_e_s.id,
            shuttles.negeri_id as negeri,
            sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as domestik_papan_lapis,
            round(form4_e_s.jumlah_venier_tempatan_laporan) as domestik_venier

            FROM
            shuttles,
            form4_e_s,
            penjualan_pembelis,
            pembelis

            WHERE form4_e_s.shuttle_id = shuttles.id

            AND penjualan_pembelis.form4es_id = form4_e_s.id
            AND penjualan_pembelis.pembeli_id = pembelis.id
            AND shuttles.negeri_id = '$negeri->negeri'
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'
            GROUP BY form4_e_s.id
            ;");


            if ($data) {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;

                $domestik_papan_lapis = 0;
                $domestik_venier = 0;

                foreach ($data as $key => $value) {
                    $domestik_venier += $value->domestik_venier;
                    $domestik_papan_lapis += $value->domestik_papan_lapis;
                }

                $datas[$negeri->negeri][0]->domestik_papan_lapis = $domestik_papan_lapis;
                $datas[$negeri->negeri][0]->domestik_venier = $domestik_venier;
            } else {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
                $datas[$negeri->negeri][0]->export = 0;
                $datas[$negeri->negeri][0]->domestik_papan_lapis = 0;
                $datas[$negeri->negeri][0]->domestik_venier = 0;
                $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);


        // foreach ($negeri_list as $negeri) {
        //     $data = DB::select("SELECT
        //     shuttles.negeri_id as negeri,
        //     sum(form4_e_s.total_export_laporan)  as export_papan_lapis,
        //     sum(form4_e_s.jumlah_venier_eksport_laporan)  as export_venier,
        //     sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik_papan_lapis,
        //     sum(round(form4_e_s.jumlah_venier_tempatan_laporan)) as domestik_venier,
        //     sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

        //     FROM
        //     shuttles,
        //     form4_e_s

        //     WHERE form4_e_s.shuttle_id = shuttles.id

        //     AND shuttles.negeri_id = '$negeri->negeri'
        //     AND shuttles.shuttle_type = '4'
        //     AND form4_e_s.status = 'Lulus'
        //     AND form4_e_s.tahun = '$tahun'
        //     GROUP BY
        //     shuttles.negeri_id
        //     ;");

        //     if ($data) {
        //         $datas[$negeri->negeri] = $data;
        //     } else {
        //         $datas[$negeri->negeri][0] = (object)[];
        //         $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
        //         $datas[$negeri->negeri][0]->export = 0;
        //         $datas[$negeri->negeri][0]->domestik_papan_lapis = 0;
        //         $datas[$negeri->negeri][0]->domestik_venier = 0;
        //         $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
        //     }
        // }


        $columns = [
            'Bil',
            'Negeri',
            'Papan Lapis (m³)',
            'Venir (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-42', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }

    public function laporan_shuttle_4_43($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as domestik

                FROM
                shuttles,
                form4_e_s,
                penjualan_pembelis,
                pembelis

                WHERE form4_e_s.shuttle_id = shuttles.id

                AND shuttles.negeri_id = '$negeri->negeri'
                AND penjualan_pembelis.form4es_id= form4_e_s.id
                And penjualan_pembelis.pembeli_id = pembelis.id
                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$tahun'
                AND form4_e_s.bulan = '$month'
                GROUP BY
                shuttles.negeri_id
                ;");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->domestik = 0;
                }
            }
        }

        // dd($datas);




        // for ($month = 1; $month <= 12; $month++) {
        //     foreach ($negeri_list as $negeri) {
        //         $data = DB::select("SELECT
        //         shuttles.negeri_id as negeri,
        //         sum(round(form4_e_s.jumlah_pasaran_tempatan_laporan)) as domestik

        //         FROM
        //         shuttles,
        //         form4_e_s

        //         WHERE form4_e_s.shuttle_id = shuttles.id

        //         AND shuttles.negeri_id = '$negeri->negeri'
        //         AND shuttles.shuttle_type = '4'
        //         AND form4_e_s.status = 'Lulus'
        //         AND form4_e_s.tahun = '$tahun'
        //         AND form4_e_s.bulan = '$month'
        //         GROUP BY
        //         shuttles.negeri_id
        //         ;");

        //         if ($data) {
        //             $datas[$negeri->negeri][$month] = $data;
        //         } else {
        //             $datas[$negeri->negeri][$month][0] = (object)[];
        //             $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
        //             $datas[$negeri->negeri][$month][0]->domestik = 0;
        //         }
        //     }
        // }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri / Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-43', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',
        ));
    }

    public function laporan_shuttle_4_44($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(form4_e_s.jumlah_venier_tempatan_laporan) as domestik

                FROM
                shuttles,
                form4_e_s

                WHERE form4_e_s.shuttle_id = shuttles.id

                AND shuttles.negeri_id = '$negeri->negeri'
                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$tahun'
                AND form4_e_s.bulan = '$month'
                GROUP BY
                shuttles.negeri_id
                ;");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->domestik = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri / Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-44', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',
        ));
    }

    public function laporan_shuttle_4_45($title, $tahun)
    {
        // dd("masuk");
        $pembelis = Pembeli::where('shuttle', '4')->get();

        foreach ($pembelis as $pembeli) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $datas[$pembeli->keterangan][$bulan] = DB::select("SELECT
                pembelis.keterangan as pembeli_keterangan,
                sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as jumlah_jualan,

                -- sepatutnya ini yang betul
                -- sum(penjualan_pembelis.jumlah_jualan_laporan) as jumlah_jualan,
                form4_e_s.bulan as bulan

                FROM
                shuttles,
                form4_e_s,
                penjualan_pembelis,
                pembelis

                WHERE form4_e_s.shuttle_id = shuttles.id

                AND pembelis.id = $pembeli->id
                AND penjualan_pembelis.form4es_id = form4_e_s.id
                AND penjualan_pembelis.pembeli_id = pembelis.id

                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$tahun'
                AND form4_e_s.bulan = '$bulan'

                GROUP BY
                pembelis.keterangan

                ;");

                // if ($data) {
                //     $datas[$pembeli->keterangan][$bulan] = $data;
                // } else {
                //     $datas[$pembeli->keterangan][$bulan][0] = (object)[];
                //     $datas[$pembeli->keterangan][$bulan][0]->pembeli_keterangan = $pembeli->keterangan;
                //     $datas[$pembeli->keterangan][$bulan][0]->domestik = 0;
                //     $datas[$pembeli->keterangan][$bulan][0]->bulan = $bulan;
                // }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Jenis Pembeli',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',
        ];

        $title_laporan = "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-45', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'pembelis'
        ));
    }

    public function laporan_shuttle_4_46($title, $tahun)
    {


        $pembelis = Pembeli::where('shuttle', '4')->get();
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {

            foreach ($pembelis as $pembeli) {

                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as domestik


                -- sepatutnya ini yang betul
                -- sum(penjualan_pembelis.jumlah_jualan_laporan) as jumlah_jualan,

                    FROM
                    shuttles,
                    form4_e_s,
                    penjualan_pembelis,
                    pembelis

                    WHERE form4_e_s.shuttle_id = shuttles.id

                    AND pembelis.id = $pembeli->id
                    AND penjualan_pembelis.pembeli_id = pembelis.id
                    AND penjualan_pembelis.form4es_id = form4_e_s.id

                    AND shuttles.shuttle_type = '4'
                    AND form4_e_s.status = 'Lulus'
                    AND form4_e_s.tahun = '$tahun'

                    AND shuttles.negeri_id = '$negeri->negeri'


                    -- AND pembelis.id = $pembeli->id
                    -- -- AND penjualan_pembelis.pembeli_id = pembelis.id
                    -- AND form4_e_s.id = penjualan_pembelis.form4es_id
                    -- AND penjualan_pembelis.pembeli_id = form4_e_s.id

                    -- AND shuttles.negeri_id = '$negeri->negeri'
                    -- AND shuttles.shuttle_type = '4'
                    -- AND form4_e_s.status = 'Lulus'
                    -- AND form4_e_s.tahun = '$tahun'

                    ;");

                if ($data) {
                    $datas[$pembeli->keterangan][$negeri->negeri] = $data;
                } else {
                    $datas[$pembeli->keterangan][$negeri->negeri][0] = (object)[];
                    $datas[$pembeli->keterangan][$negeri->negeri][0]->pembeli_keterangan = $pembeli->keterangan;
                    $datas[$pembeli->keterangan][$negeri->negeri][0]->domestik = 0;
                    $datas[$pembeli->keterangan][$negeri->negeri][0]->negeri = $negeri->negeri;
                }
            }
        }

        // dd($datas);


        $columns = [
            'Bil',
            'Jenis Pembeli',
        ];

        foreach ($negeri_list as $negeri) {
            $columns[] = $negeri->negeri;
        }

        $columns[] = 'Jumlah (m³)';

        // dd($columns);

        $title_laporan = "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];


        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-46', compact(
            'columns',
            'title',
            'returnArr',
            'pembelis',
            'datas',
            'negeri_list',
            'tahun',
        ));
    }

    public function laporan_shuttle_4_47($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }


        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";


        $pembeli_list = Pembeli::where('shuttle', '4')->get();

        foreach ($pembeli_list as $pembeli) {
            for ($curr_year = $tahun_mula; $curr_year <= $tahun_akhir; $curr_year++) {

                $datas[$pembeli->keterangan][$curr_year] =
                    DB::select("SELECT
                pembelis.keterangan as pembeli_keterangan,
                sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as jumlah_jualan


                -- sepatutnya ini yang betul
                -- sum(penjualan_pembelis.jumlah_jualan_laporan) as jumlah_jualan,

                FROM
                shuttles,
                form4_e_s,
                penjualan_pembelis,
                pembelis

                WHERE form4_e_s.shuttle_id = shuttles.id

                AND pembelis.id = $pembeli->id
                AND penjualan_pembelis.pembeli_id = pembelis.id
                AND penjualan_pembelis.form4es_id = form4_e_s.id

                AND shuttles.shuttle_type = '4'
                AND form4_e_s.status = 'Lulus'
                AND form4_e_s.tahun = '$curr_year'



                    GROUP BY
                    shuttles.negeri_id
            ;");
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Jenis Pembeli',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-47', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'pembeli_list',
            'datas',

        ));
    }

    public function laporan_shuttle_4_48($title, $tahun)
    {
        // ganti total_export with total_export_laporan, jumlah_pasaran_tempatan with jumlah_pasaran_tempatan_laporan
        for ($i = 1; $i <= 12; $i++) {
            $data = DB::select("SELECT
            form4_e_s.bulan as bulan,
            sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
            sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form4_e_s

            WHERE form4_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'
            AND form4_e_s.bulan = '$i'
            GROUP BY
            form4_e_s.bulan
            ;");



            if ($data) {
                $datas[$i] = $data;
            } else {
                $datas[$i][0] = (object)[];
                $datas[$i][0]->bulan = $i;
                $datas[$i][0]->export = 0;
                $datas[$i][0]->domestik_papan_lapis = 0;
                $datas[$i][0]->domestik_venier = 0;
                $datas[$i][0]->export_papan_lapis = 0;
                $datas[$i][0]->export_venier = 0;
                $datas[$i][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);



        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];


        $columns = [
            'Bil',
            'Bulan',
            'Papan Lapis (m³)',
            'Venir (m³)',
        ];

        // dd($datas);

        $title_laporan = "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-48', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'bulan_senarai',
            'datas',
        ));
    }

    public function laporan_shuttle_4_49($title, $tahun)
    {
        // dd($tahun);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            shuttles.negeri_id as negeri,
            sum(round(form4_e_s.total_export_laporan))  as export_papan_lapis,
            sum(round(form4_e_s.jumlah_venier_eksport_laporan))  as export_venier,
            sum(form4_e_s.jumlah_pasaran_tempatan_laporan) as domestik_papan_lapis,
            sum(form4_e_s.jumlah_venier_tempatan_laporan) as domestik_venier,
            sum(form4_e_s.total_export_laporan + form4_e_s.jumlah_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form4_e_s

            WHERE form4_e_s.shuttle_id = shuttles.id

            AND shuttles.negeri_id = '$negeri->negeri'
            AND shuttles.shuttle_type = '4'
            AND form4_e_s.status = 'Lulus'
            AND form4_e_s.tahun = '$tahun'
            GROUP BY
            shuttles.negeri_id
            ;");

            if ($data) {
                $datas[$negeri->negeri] = $data;
            } else {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
                $datas[$negeri->negeri][0]->export = 0;
                $datas[$negeri->negeri][0]->domestik_papan_lapis = 0;
                $datas[$negeri->negeri][0]->domestik_venier = 0;
                $datas[$negeri->negeri][0]->export_papan_lapis = 0;
                $datas[$negeri->negeri][0]->export_venier = 0;
                $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri',
            'Papan Lapis (m³)',
            'Venir (m³)',
        ];

        // dd($datas);

        $title_laporan = "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle4-49', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }





    // Shuttle 5 - Waniiiiiiiiiii
    public function laporan_shuttle_5_1($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '5'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '5'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
            sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND form_c_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];


        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,
            sum( form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum( form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum( form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Gergaji',
            'Jumlah Pengeluaran Kayu Kumai',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "1. Maklumat Penuh Senarai Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_5_2($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5')->where('status_warganegara', 'Bumiputera');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '5'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '5'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
            sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND form_c_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];


        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,
            sum( form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum( form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum( form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        }




       $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',

            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Gergaji',
            'Jumlah Pengeluaran Kayu Kumai',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];


        $title_laporan = "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }
    public function laporan_shuttle_5_3($title, $tahun)
    {

        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5')->where('status_warganegara', 'Bukan Bumiputera');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '5'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '5'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
            sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND form_c_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];


        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,
            sum( form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum( form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum( form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',


            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Gergaji',
            'Jumlah Pengeluaran Kayu Kumai',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }

    public function laporan_shuttle_5_4($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5')->where('status_warganegara', 'Bukan Warganegara');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
        }

        $data_shuttles = DB::select("SELECT
            shuttles.*

            FROM
            shuttles,
            form_a_s

            WHERE shuttles.id = form_a_s.shuttle_id
            AND shuttles.shuttle_type = '5'
            AND form_a_s.status = 'Lulus'
        ");


        foreach ($data_shuttles as $data_shuttle) {
            $data_guna_tenagas[$data_shuttle->id] = DB::select("SELECT
            DISTINCT(shuttles.id) as shuttle_id,
            formbs.suku_tahun,

            guna_tenagas.total_bumi_lelaki_laporan as pekerja_wargabumi_lelaki_laporan,
            guna_tenagas.total_bumi_perempuan_laporan as pekerja_wargabumi_perempuan_laporan,
            guna_tenagas.total_bukanbumi_lelaki_laporan as pekerja_bukan_wargabumi_lelaki_laporan,
            guna_tenagas.total_bukanbumi_perempuan_laporan as pekerja_bukan_wargabumi_perempuan_laporan,
            guna_tenagas.total_asing_lelaki_laporan as pekerja_asing_lelaki_laporan,
            guna_tenagas.total_asing_perempuan_laporan as pekerja_asing_perempuan_laporan

            FROM
            shuttles,
            guna_tenagas,
            formbs

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = formbs.shuttle_id
            AND guna_tenagas.shuttle_id = shuttles.id
            AND guna_tenagas.formbs_id = formbs.id
            AND formbs.suku_tahun = (SELECT MAX(formbs.suku_tahun)
                                                FROM shuttles, guna_tenagas, formbs
                                                WHERE shuttles.id = formbs.shuttle_id
                                                AND shuttles.shuttle_type = '5'
                                                AND guna_tenagas.shuttle_id = shuttles.id
                                                AND guna_tenagas.formbs_id = formbs.id)

            ORDER BY formbs.suku_tahun DESC
        ")[0];


        $data_kemasukan_bahans[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,

            sum(kemasukan_bahans.total_kayu_masuk_jentera) as jumlah_penggunaan,
            sum(kemasukan_bahans.total_kayu_keluar_jentera) as jumlah_pengeluaran

            FROM
            shuttles,
            form_c_s,
            kemasukan_bahans

            WHERE shuttles.id = '$data_shuttle->id'
            AND shuttles.id = form_c_s.shuttle_id
            AND form_c_s.id = kemasukan_bahans.formcs_id
            AND form_c_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];


        $data_form_d_s[$data_shuttle->id] = DB::select("SELECT
            shuttles.id as shuttle_id,
            sum( form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum( form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum( form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY shuttles.id
        ")[0];

        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',


            'Alamat Surat Menyurat 1',
            'Alamat Surat Menyurat 2',
            'Poskod',
            'Daerah',

            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Nilai Harta Tetap Pada Tahun Berakhir',
            'Tarikh Terakhir Kemaskini',

            'Guna Tenaga',

            'Jumlah Penggunaan Kayu Gergaji',
            'Jumlah Pengeluaran Kayu Kumai',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];


        $title_laporan = "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-1', compact(
            'title',
            'columns',
            'shuttle',
            'tahun',
            'returnArr',
            'data_shuttles',
            'data_guna_tenagas',
            'data_kemasukan_bahans',
            'data_form_d_s'
        ));
    }
    public function laporan_shuttle_5_5($title, $tahun)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5');
            })
            ->get();

        if ($shuttle->count() == 0) {
            return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
        }

        $datas_formc = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                    sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                    FROM
                                    shuttles,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus

                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '5'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;


        ");

        // dd($datas_formc);

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',

            // 'Nilai Harta Tetap Pada Tahun Berakhir',
            // 'Tarikh Terakhir Kemaskini',

            // 'Guna Tenaga',

            // 'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Kumai',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-5', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
        ));
    }

    public function laporan_shuttle_5_6($title, $tahun, $spesies)
    {
        $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
            ->whereHas('shuttle', function ($q) {
                $q->where('shuttle_type', '5');
            })
            ->get();

        $datas_formc = DB::select("SELECT
                                    shuttles.id as shuttle_id,
                                    sum(kemasukan_bahans.proses_masuk) as jumlah_penggunaan,
                                    sum(kemasukan_bahans.proses_keluar) as jumlah_pengeluaran

                                    FROM
                                    shuttles,
                                    form_c_s,
                                    kemasukan_bahans,
                                    spesis,
                                    kumpulan_kayus

                                    WHERE form_c_s.shuttle_id = shuttles.id
                                    AND form_c_s.id = kemasukan_bahans.formcs_id
                                    AND kemasukan_bahans.spesis_id = spesis.id
                                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                                    AND shuttles.shuttle_type = '5'
                                    AND form_c_s.status = 'Lulus'
                                    AND form_c_s.tahun = '$tahun'
                                    AND spesis.id = '$spesies'

                                    GROUP BY
                                    shuttles.id

                                    ORDER BY
                                    jumlah_pengeluaran DESC;

        ");

        // dd($datas_formc);

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',

            // 'Nilai Harta Tetap Pada Tahun Berakhir',
            // 'Tarikh Terakhir Kemaskini',

            // 'Guna Tenaga',

            // 'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Kumai',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $title_laporan = "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-5', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'datas_formc',
            'tahun',
            'spesies',
        ));
    }

    public function laporan_shuttle_5_7($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        // $datas =  DB::select("SELECT negeri_id as negeri, SUM(nilai_harta) as jumlah FROM `shuttles` GROUP BY negeri_id;");

        $datas =  DB::select("SELECT shuttles.negeri_id as negeri,
        SUM(shuttles.nilai_harta) as jumlah
        FROM shuttles, form_a_s
        WHERE form_a_s.shuttle_id = shuttles.id
        AND shuttles.shuttle_type = '5'
        AND form_a_s.status = 'Lulus'
        AND form_a_s.tahun = $tahun
        GROUP BY shuttles.negeri_id;");

        $jumlah_setiap_negeri = 0;

        foreach ($datas as $data) {
            $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
        }

        $columns = [
            'Bil',
            'Negeri',
            'Nilai Harta Tetap Pada Tahun Berakhir',
        ];

        $title_laporan = "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-7', compact(
            'title',
            'columns',
            'negeri_list',
            'datas',
            'jumlah_setiap_negeri',
            'returnArr',
            'tahun',
        ));
    }

    public function laporan_shuttle_5_11($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd(" tahun : " . $tahun . " start : " . $start_date . " end : " . $end_date);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {

                $datas[$i][$negeri->negeri] = DB::select("SELECT DISTINCT(shuttles.id), shuttles.negeri_id as negeri,
                    (guna_tenagas.total_pekerja_lelaki_laporan) as total_pekerja_lelaki,
                    (guna_tenagas.total_pekerja_perempuan_laporan) as total_pekerja_perempuan,
                    (guna_tenagas.jumlah_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                    (guna_tenagas.jumlah_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                    FROM guna_tenagas, shuttles, formbs

                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                    AND formbs.shuttle_id = shuttles.id
                    AND formbs.status = 'Lulus'
                    AND formbs.suku_tahun = '$i'
                    AND formbs.tahun = '$tahun'

                    AND shuttles.shuttle_type = '5'
                    AND shuttles.negeri_id = '$negeri->negeri'
                ");
            }
        }

        $columns = [
            'Bil',
            'Negeri',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Kayu Kumai Mengikut Negeri Dan Jantina";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-11', compact(
            'title',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir'
        ));
    }

    public function laporan_shuttle_5_12($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $datas[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.jumlah_lelaki_laporan) as jumlah_lelaki,
                                        sum(guna_tenagas.jumlah_perempuan_laporan) as jumlah_perempuan,
                                        sum(guna_tenagas.total_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                                        sum(guna_tenagas.total_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '5'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')


                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($kategori);
        // dd($datas);

        $columns = [
            'Bil',
            'Kategori',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-12', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'datas',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',

        ));
    }

    public function laporan_shuttle_5_13($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        // dd($kategori);
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {

            foreach ($kategori as $key => $data) {
                $jumlah[$i][$data->keterangan] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                                        sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '5'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')


                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }

        foreach ($jumlah as $key => $value) {
            foreach ($value as $key => $data) {
                // dd($data[0]);
            }
        }

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-13', compact(
            'title',
            'title_laporan',
            'columns',
            'kategori',
            'jumlah',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'tahun',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_5_14($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {

        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($negeri_list as $key => $negeri) {
                $datas[$i][$negeri->negeri] = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                    sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                    sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                    sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan
                     FROM guna_tenagas,
                     shuttles,
                     formbs
                    WHERE shuttles.id = guna_tenagas.shuttle_id
                    AND guna_tenagas.formbs_id = formbs.id

                     AND shuttles.id = formbs.shuttle_id
                     AND shuttles.shuttle_type = '5'
                     AND formbs.status = 'Lulus'
                     AND formbs.tahun = $tahun
                     AND formbs.suku_tahun = '$i'
                     AND shuttles.negeri_id = '$negeri->negeri'
                     AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')

                     GROUP BY shuttles.negeri_id
                     ");
            }
        }

        $columns = [
            'Bil',
            'Negeri',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah',
        ];

        $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];


        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-14', compact(
            'title',
            'title_laporan',
            'title_laporan',
            'columns',
            'negeri_list',
            'datas',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            // 'null_flag',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_5_15($title, $tahun, $suku_tahun, $suku_tahun_akhir)
    {
        if ($suku_tahun > $suku_tahun_akhir) {
            $temp = $suku_tahun;

            $suku_tahun = $suku_tahun_akhir;

            $suku_tahun_akhir = $temp;
        }

        $jumlah_suku_tahun = ($suku_tahun_akhir - $suku_tahun) + 1;

        // dd($jumlah_suku_tahun);

        if ($suku_tahun == 1) {
            $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($suku_tahun == 2) {
            $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($suku_tahun == 3) {
            $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($suku_tahun == 4) {
            $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($suku_tahun_akhir == 1) {
            $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($suku_tahun_akhir == 2) {
            $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($suku_tahun_akhir == 3) {
            $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($suku_tahun_akhir == 4) {
            $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $kategori = KategoriGunaTenaga::get();
        for ($i = $suku_tahun; $i <= $jumlah_suku_tahun; $i++) {
            foreach ($kategori as $key => $data) {
                $jumlah[$i][$key] = DB::select("SELECT
                                        kategori_guna_tenagas.keterangan as kategori,
                                        sum(guna_tenagas.pekerja_wargabumi_lelaki_laporan) as jumlah_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_wargabumi_perempuan_laporan) as jumlah_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_lelaki_laporan) as jumlah_bukan_bumiputera_lelaki,
                                        sum(guna_tenagas.pekerja_bukan_wargabumi_perempuan_laporan) as jumlah_bukan_bumiputera_perempuan,
                                        sum(guna_tenagas.pekerja_asing_lelaki_laporan) as jumlah_bukan_warganegara_lelaki,
                                        sum(guna_tenagas.pekerja_asing_perempuan_laporan) as jumlah_bukan_warganegara_perempuan,
                                        sum(guna_tenagas.jumlah_lelaki_laporan) as jumlah_lelaki,
                                        sum(guna_tenagas.jumlah_perempuan_laporan) as jumlah_perempuan,
                                        sum(guna_tenagas.total_gaji_lelaki_laporan) as jumlah_gaji_lelaki,
                                        sum(guna_tenagas.total_gaji_perempuan_laporan) as jumlah_gaji_perempuan

                                        FROM
                                        kategori_guna_tenagas,
                                        guna_tenagas,
                                        formbs,
                                        shuttles

                                        WHERE kategori_guna_tenagas.id = '$data->id'
                                        AND guna_tenagas.kategori_guna_tenaga_id = kategori_guna_tenagas.id
                                        AND formbs.id = guna_tenagas.formbs_id
                                        AND shuttles.id = formbs.shuttle_id
                                        AND shuttles.shuttle_type = '5'
                                        AND formbs.status = 'Lulus'
                                        AND formbs.tahun = '$tahun'
                                        AND formbs.suku_tahun = '$i'
                                        AND (formbs.suku_tahun BETWEEN '$suku_tahun' AND '$suku_tahun_akhir')


                                        GROUP BY
                                        kategori_guna_tenagas.keterangan;
                                    ");
            }
        }
        // dd($tahun . " / " . $suku_tahun . " / " . $start_date . " / " . $end_date . " / " . $nama_suku_tahun );

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah Guna Tenaga',
            'Pendapatan (RM)',
            'Purata Pendapatan (RM)',

        ];


        $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-15', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'kategori',
            'jumlah',
            'returnArr',
            'suku_tahun',
            'suku_tahun_akhir',
        ));
    }

    public function laporan_shuttle_5_21($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan,
                    form_c_s.bulan as bulan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '5'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$month'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->jumlah_penggunaan = 0;
                    $datas[$negeri->negeri][$month][0]->bulan = $month;
                }
            }
        }
        // dd($datas);
        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah',

        ];

        $title_laporan = "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-21', compact(
            'columns',
            'title',
            'negeri_list',
            'datas',
            'returnArr',
            'tahun',
        ));
    }
    public function laporan_shuttle_5_22($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $grandtotal[$x] = 0;
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '5'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_penggunaan = 0;
                }
                $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_penggunaan;
            }
        }

        $grandtotal[$x] = 0;
        foreach ($grandtotal as $value) {
            $grandtotal[$x] += $value;
        }

        $columns = [
            'Bil',
            'Negeri',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';



        $title_laporan = "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-22', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'grandtotal',
            'returnArr'
        ));
    }

    public function laporan_shuttle_5_23($title, $tahun)
    {

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    foreach ($negeri_list as $negeri) {
                        $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '5'
                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    shuttles.negeri_id
                    ;");

                        if ($data) {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri] = $data;
                        } else {
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0] = (object)[];
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->negeri = $negeri->negeri;
                            $datas[$kk->singkatan][$sp->nama_tempatan][$negeri->negeri][0]->jumlah_penggunaan = 0;
                        }
                    }
                }
            }
        }
        // dd($datas['KKB / HHW']['Balau']);
        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Johor',
            'Kedah',
            'Kelantan',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Perak',
            'Perlis',
            'Pulau Pinang',
            'Selangor',
            'Terengganu',
            'W.P. Kuala Lumpur',
            'Jumlah (m³)',

        ];

        $title_laporan = "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-23', compact(
            'columns',
            'title',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'datas',
            'tahun'
        ));
    }

    public function laporan_shuttle_5_24($title, $tahun)
    {

        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        for ($i = 1; $i < 13; $i++) {
            foreach ($kumpulan_kayu as $count_kk => $kk) {
                foreach ($spesis as $count_spesis => $sp) {
                    if ($sp->kumpulan_kayu_id == $kk->id) {
                        $datas[$kk->singkatan][$sp->nama_tempatan][$i] = DB::select("SELECT
                    form_c_s.bulan as bulan,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '5'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$i'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'

                    GROUP BY
                    form_c_s.bulan
                    ;");
                    }
                }
            }
        }


        // dd($datas["KKB / HHW"]["Balau"]["2"][0]);


        $columns = [
            'Bil',
            'Kumpulan Kayu',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-24', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'kumpulan_kayu',
        ));
    }

    public function laporan_shuttle_5_25($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $total_tahun = $tahun_akhir + 1;
        // $tahun_mula = "2018";
        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $start_date . " / Tahun akhir : " . $end_date);


        $kumpulan_kayu = KumpulanKayu::get();

        $spesis = Spesis::get();

        //count by spesis
        foreach ($kumpulan_kayu as $count_kk => $kk) {
            foreach ($spesis as $count_spesis => $sp) {
                if ($sp->kumpulan_kayu_id == $kk->id) {
                    $datas[$kk->singkatan][$sp->nama_tempatan] = DB::select("SELECT
                    form_c_s.tahun as tahun,
                    sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '5'
                    AND form_c_s.status = 'Lulus'
                    AND kumpulan_kayus.keterangan = '$kk->keterangan'
                    AND spesis.nama_tempatan = '$sp->nama_tempatan'
                    AND (date(kemasukan_bahans.created_at) BETWEEN '$start_date' AND '$end_date')

                    GROUP BY
                    form_c_s.tahun
                    ;");
                }
            }
        }


        // dd($datas);

        $columns = [
            'Bil',
            'Kumpulan Kayu',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-25', compact(
            'columns',
            'title',
            'returnArr',
            'tahun_mula',
            'tahun_akhir',
            'kumpulan_kayu',
            'datas',
        ));
    }

    public function laporan_shuttle_5_31($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans,
                    spesis,
                    kumpulan_kayus

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id
                    AND kemasukan_bahans.spesis_id = spesis.id
                    AND spesis.kumpulan_kayu_id = kumpulan_kayus.id

                    AND shuttles.shuttle_type = '5'
                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$tahun'
                    AND form_c_s.bulan = '$bulan'


                    GROUP BY
                    shuttles.negeri_id
                    ;");

                if ($data) {
                    $datas[$negeri->negeri][$bulan] = $data;
                } else {
                    $datas[$negeri->negeri][$bulan][0] = (object)[];
                    $datas[$negeri->negeri][$bulan][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$bulan][0]->jumlah_pengeluaran = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri/Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];
        $title_laporan = "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-31', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }

    public function laporan_shuttle_5_32($title, $tahun_mula, $tahun_akhir)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";

        // dd("Tahun mula : " . $tahun_mula . " / Tahun akhir : " . $tahun_akhir);

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $grandtotal[$x] = 0;
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT shuttles.negeri_id as negeri,
                    sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran

                    FROM
                    shuttles,
                    form_c_s,
                    kemasukan_bahans

                    WHERE form_c_s.shuttle_id = shuttles.id
                    AND form_c_s.id = kemasukan_bahans.formcs_id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '5'
                    AND form_c_s.status = 'Lulus'
                    AND form_c_s.tahun = '$x'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$x] = $data;
                } else {
                    $datas[$negeri->negeri][$x][0] = (object)[];
                    $datas[$negeri->negeri][$x][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran = 0;
                }
                $grandtotal[$x] += $datas[$negeri->negeri][$x][0]->jumlah_pengeluaran;
            }
        }

        $grandtotal[$x] = 0;
        foreach ($grandtotal as $value) {
            $grandtotal[$x] += $value;
        }

        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumain Mengikut Negeri Bagi Siri Masa";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-32', compact(
            'columns',
            'title',
            'tahun_mula',
            'tahun_akhir',
            'negeri_list',
            'datas',
            'grandtotal',
            'returnArr'
        ));
    }

    public function laporan_shuttle_5_33($title, $tahun)
    {
        // dd("masuk");
        $jenis_kayus = JenisKayu::where('aktif', '1')->get();

        foreach ($jenis_kayus as $jenis_kayu) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $datas[$jenis_kayu->keterangan][$bulan] = DB::select("SELECT
                jenis_kayus.keterangan as jenis_kayu_keterangan,
                sum(round(pengeluaran_form5_d_s.pengeluaran_kayu))  as jumlah_jualan,
                form5_d_s.bulan as bulan

                FROM
                shuttles,
                form5_d_s,
                jenis_kayus,
                pengeluaran_form5_d_s

                WHERE form5_d_s.shuttle_id = shuttles.id

                AND jenis_kayus.id = $jenis_kayu->id
                AND pengeluaran_form5_d_s.form5ds_id = form5_d_s.id
                AND pengeluaran_form5_d_s.jenis_kayu_id = jenis_kayus.id

                AND shuttles.shuttle_type = '5'
                AND form5_d_s.status = 'Lulus'
                AND form5_d_s.tahun = '$tahun'
                AND form5_d_s.bulan = '$bulan'

                GROUP BY
                jenis_kayus.keterangan
                ;");
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Jenis Kayu',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',
        ];

        $title_laporan = "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-33', compact(
            'columns',
            'title',
            'returnArr',
            'tahun',
            'datas',
            'jenis_kayus'
        ));
    }

    public function laporan_shuttle_5_41($title, $tahun)
    {
        // ganti total_export with total_export_laporan, jumlah_pasaran_tempatan with jumlah_pasaran_tempatan_laporan
        for ($i = 1; $i <= 12; $i++) {
            $data = DB::select("SELECT
            form5_e_s.bulan as bulan,
            sum(form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum(form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum(form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan


            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'
            AND form5_e_s.bulan = '$i'
            GROUP BY
            form5_e_s.bulan
            ;");

            if ($data) {
                $datas[$i] = $data;
            } else {
                $datas[$i][0] = (object)[];
                $datas[$i][0]->bulan = $i;
                $datas[$i][0]->export = 0;
                $datas[$i][0]->domestik = 0;
                $datas[$i][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);
        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];


        $columns = [
            'Bil',
            'Bulan',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "41. Jualan Domestik Kayu Kumai Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-41', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'tahun',
            'bulan_senarai',
            'datas',
        ));
    }


    public function laporan_shuttle_5_42($title, $tahun)
    {
        // dd($tahun);
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            shuttles.negeri_id as negeri,
            sum(form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum(form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum(form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.negeri_id = '$negeri->negeri'
            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY
            shuttles.negeri_id
            ;");

            if ($data) {
                $datas[$negeri->negeri] = $data;
            } else {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
                $datas[$negeri->negeri][0]->export = 0;
                $datas[$negeri->negeri][0]->domestik = 0;
                $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Kayu Kumai Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-42', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'tahun',
            'negeri_list',
            'datas',
        ));
    }


    public function laporan_shuttle_5_43($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(form5_e_s.jumlah_jualan_eksport_laporan)  as export,
                    sum(form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
                    sum(form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

                    FROM
                    shuttles,
                    form5_e_s

                    WHERE form5_e_s.shuttle_id = shuttles.id

                    AND shuttles.negeri_id = '$negeri->negeri'
                    AND shuttles.shuttle_type = '5'
                    AND form5_e_s.status = 'Lulus'
                    AND form5_e_s.tahun = '$tahun'
                    AND form5_e_s.bulan = '$month'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                if ($data) {
                    $datas[$negeri->negeri][$month] = $data;
                } else {
                    $datas[$negeri->negeri][$month][0] = (object)[];
                    $datas[$negeri->negeri][$month][0]->negeri = $negeri->negeri;
                    $datas[$negeri->negeri][$month][0]->export = 0;
                    $datas[$negeri->negeri][$month][0]->domestik = 0;
                    $datas[$negeri->negeri][$month][0]->jumlah_penjualan = 0;
                }
            }
        }

        // dd($datas);

        $columns = [
            'Bil',
            'Negeri / Bulan',
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
            'Jumlah (m³)',

        ];

        $title_laporan = "43. Jualan Domestik Kayu Kumai Mengikut Negeri Dan Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-43', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',
        ));
    }

    public function laporan_shuttle_5_44($title, $tahun)
    {
        for ($i = 1; $i <= 12; $i++) {
            $data = DB::select("SELECT
            form5_e_s.bulan as bulan,
            sum(form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum(form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum(form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan


            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'
            AND form5_e_s.bulan = '$i'
            GROUP BY
            form5_e_s.bulan
            ;");

            if ($data) {
                $datas[$i] = $data;
            } else {
                $datas[$i][0] = (object)[];
                $datas[$i][0]->bulan = $i;
                $datas[$i][0]->export = 0;
                $datas[$i][0]->domestik = 0;
                $datas[$i][0]->jumlah_penjualan = 0;
            }
        }

        $bulan_senarai = [
            'Januari',
            'Februari',
            'Mac',
            'April',
            'Mei',
            'Jun',
            'Julai',
            'Ogos',
            'September',
            'Oktober',
            'November',
            'Disember',
        ];

        // dd($bulan_senarai);



        $columns = [
            'Bil',
            'Bulan',
            'Kayu Kumai (m³)',
        ];

        $title_laporan = "44. Jualan Eksport Kayu Kumai Mengikut Bulan";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-44', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'datas',
            'bulan_senarai',
            'tahun',

        ));
    }

    public function laporan_shuttle_5_45($title, $tahun)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            shuttles.negeri_id as negeri,
            sum(form5_e_s.jumlah_jualan_eksport_laporan)  as export,
            sum(form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as domestik,
            sum(form5_e_s.jumlah_jualan_eksport_laporan + form5_e_s.jumlah_jualan_pasaran_tempatan_laporan) as jumlah_penjualan

            FROM
            shuttles,
            form5_e_s

            WHERE form5_e_s.shuttle_id = shuttles.id

            AND shuttles.negeri_id = '$negeri->negeri'
            AND shuttles.shuttle_type = '5'
            AND form5_e_s.status = 'Lulus'
            AND form5_e_s.tahun = '$tahun'

            GROUP BY
            shuttles.negeri_id
            ;");

            if ($data) {
                $datas[$negeri->negeri] = $data;
            } else {
                $datas[$negeri->negeri][0] = (object)[];
                $datas[$negeri->negeri][0]->negeri = $negeri->negeri;
                $datas[$negeri->negeri][0]->export = 0;
                $datas[$negeri->negeri][0]->domestik = 0;
                $datas[$negeri->negeri][0]->jumlah_penjualan = 0;
            }
        }

        // dd($datas);
        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',

        ];

        $title_laporan = "45. Jualan Eksport Kayu Gergaji Mengikut Negeri";

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];
        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan.laporanpopup.laporan-shuttle5-45', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'datas',
            'tahun',

        ));
    }

    public function redirectLaporanLama($title, $tahun, $tahun_akhir, $suku_tahun, $suku_tahun_akhir, $spesis)
    {
        if ($title == "1") {
            $shuttle = 'shuttle3';
            $statuspemilik = '0';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "2") {
            $shuttle = 'shuttle3';
            $statuspemilik = '1';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "3") {
            $shuttle = 'shuttle3';
            $statuspemilik = '2';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "4") {
            $shuttle = 'shuttle3';
            $statuspemilik = '3';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "5") {
            $shuttle = 'shuttle3';
            $lapisvenir = '1';
            return redirect()->route('getreport_top10pengeluar', [$shuttle, $tahun, $lapisvenir, $title]);
        } elseif ($title == "6") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_top10pengguna', [$shuttle, $tahun, $spesis, $title]);
        } elseif ($title == "7") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jumlahpelaburan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "11") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_gunatenagadanpendapatan_bynegeri', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "12") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_gunatenagadanpendapatan_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "13") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_gunatenaga_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "14") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_gunatenaga_bynegeri', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "15") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pecahangunatenagadanpendapatan_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "21") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_penggunaan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "22") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_penggunaan_bynegeri_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "23") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "24") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "25") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "31") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaran_bynegeri_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "32") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaran_bynegeri_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "33") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaran_bykumpulankayu_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "34") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaran_bykumpulankayu_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "35") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaran_bykumpulankayu_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "36") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_pengeluaranspesies_bynegeri_bybulan', [$shuttle, $tahun, $spesis, $title]);
        } elseif ($title == "41") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "42") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "43") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bynegeridanbulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "44") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bypembeli_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "45") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bypembeli_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "46") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bypembeli_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "47") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "48") {
            $shuttle = 'shuttle3';
            return redirect()->route('getreport_jualan_bynegeri', [$shuttle, $tahun, $title]);
        }

        //shuttle 5
        if ($title == "301") {
            $shuttle = 'shuttle5';
            $statuspemilik = '0';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "302") {
            $shuttle = 'shuttle5';
            $statuspemilik = '1';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "303") {
            $shuttle = 'shuttle5';
            $statuspemilik = '2';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "304") {
            $shuttle = 'shuttle5';
            $statuspemilik = '3';
            return redirect()->route('getreport_senaraikilang', [$shuttle, $statuspemilik, $tahun = $tahun, $title]);
        } elseif ($title == "305") {
            $shuttle = 'shuttle5';
            $lapisvenir = '1';
            return redirect()->route('getreport_top10pengeluar', [$shuttle, $tahun, $lapisvenir, $title]);
        } elseif ($title == "306") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_top10pengguna', [$shuttle, $tahun, $spesis, $title]);
        } elseif ($title == "307") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jumlahpelaburan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "311") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_gunatenagadanpendapatan_bynegeri', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "312") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_gunatenagadanpendapatan_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "313") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_gunatenaga_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "314") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_gunatenaga_bynegeri', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "315") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_pecahangunatenagadanpendapatan_bykategori', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title]);
        } elseif ($title == "321") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_penggunaan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "322") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_penggunaan_bynegeri_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "323") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "324") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "325") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_penggunaan_bykumpulankayu_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "331") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_pengeluaran_bynegeri_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "332") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_pengeluaran_bynegeri_bytahun', [$shuttle, $tahun, $tahun_akhir, $title]);
        } elseif ($title == "333") {
            $shuttle = 'shuttle5';
            return $this->getreport_pengeluaran_byproduk_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "341") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jualan_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "342") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jualan_bynegeri', [$shuttle, $tahun, $title]);
        } elseif ($title == "343") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jualan_bynegeridanbulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "344") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jualan_bybulan', [$shuttle, $tahun, $title]);
        } elseif ($title == "345") {
            $shuttle = 'shuttle5';
            return redirect()->route('getreport_jualan_bynegeri', [$shuttle, $tahun, $title]);
        }

        //shuttle 4
        if ($title == "201") {
            $shuttle = 'shuttle4';
            $statuspemilik = '0';
            return $this->getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title);
        } elseif ($title == "202") {
            $shuttle = 'shuttle4';
            $statuspemilik = '1';
            return $this->getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title);
        } elseif ($title == "203") {
            $shuttle = 'shuttle4';
            $statuspemilik = '2';
            return $this->getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title);
        } elseif ($title == "204") {
            $shuttle = 'shuttle4';
            $statuspemilik = '3';
            return $this->getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title);
        } elseif ($title == "205") {
            $shuttle = 'shuttle4';
            $lapisvenir = '1';
            return $this->getreport_top10pengeluar($shuttle, $tahun, $lapisvenir, $title);
        } elseif ($title == "206") {
            $shuttle = 'shuttle4';
            $lapisvenir = '0';
            return $this->getreport_top10pengeluar($shuttle, $tahun, $lapisvenir, $title);
        } elseif ($title == "207") {
            $shuttle = 'shuttle4';
            return $this->getreport_top10pengguna($shuttle, $tahun, $spesis, $title);
        } elseif ($title == "208") {
            $shuttle = 'shuttle4';
            return $this->getreport_jumlahpelaburan($shuttle, $tahun, $title);
        } elseif ($title == "209") {
            $shuttle = 'shuttle4';
            return $this->getreport_jumlahpelaburan_bynegeri($shuttle, $tahun, $title);
        } elseif ($title == "211") {
            $shuttle = 'shuttle4';
            return $this->getreport_gunatenagadanpendapatan_bynegeri($shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title);
        } elseif ($title == "212") {
            $shuttle = 'shuttle4';
            return $this->getreport_gunatenagadanpendapatan_bykategori($shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title);
        } elseif ($title == "213") {
            $shuttle = 'shuttle4';
            return $this->getreport_gunatenaga_bykategori($shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title);
        } elseif ($title == "214") {
            $shuttle = 'shuttle4';
            return $this->getreport_gunatenaga_bynegeri($shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title);
        } elseif ($title == "215") {
            $shuttle = 'shuttle4';
            return $this->getreport_pecahangunatenagadanpendapatan_bykategori($shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title);
        } elseif ($title == "221") {
            $shuttle = 'shuttle4';
            return $this->getreport_penggunaan_bynegeri($shuttle, $tahun, $title);
        } elseif ($title == "222") {
            $shuttle = 'shuttle4';
            return $this->getreport_penggunaan_bynegeri_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "223") {
            $shuttle = 'shuttle4';
            return $this->getreport_penggunaan_bykumpulankayu_bynegeri($shuttle, $tahun, $title);
        } elseif ($title == "224") {
            $shuttle = 'shuttle4';
            return $this->getreport_penggunaan_bykumpulankayu_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "225") {
            $shuttle = 'shuttle4';
            return $this->getreport_penggunaan_bykumpulankayu_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "231") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "232") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "233") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "234") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluarantebal_bynegeri_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "235") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluarantebal_bynegeri_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "236") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "237") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "238") {
            $shuttle = 'shuttle4';
            return $this->getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "241") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "242") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bynegeri($shuttle, $tahun, $title);
        } elseif ($title == "243") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bynegeridanbulan($shuttle, $tahun, $title);
        } elseif ($title == "244") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bynegeridanbulan($shuttle, $tahun, $title);
        } elseif ($title == "245") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bypembeli_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "246") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bypembeli_bynegeri($shuttle, $tahun, $title);
        } elseif ($title == "248") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bybulan($shuttle, $tahun, $title);
        } elseif ($title == "247") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bypembeli_bytahun($shuttle, $tahun, $tahun_akhir, $title);
        } elseif ($title == "249") {
            $shuttle = 'shuttle4';
            return $this->getreport_jualan_bynegeri($shuttle, $tahun, $title);
        }

        dd("ERROR");
    }
}
