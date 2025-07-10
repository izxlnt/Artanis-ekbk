<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Spesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KumpulanKayu;
use App\Models\Daerah;
use App\Models\Laporan;
use App\Models\Pembeli;

class LaporanDataLamaController extends Controller
{
    /* ********************************************************************************
	Report 101-104, 201-204, 301-304
	******************************************************************************** */
    public function getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title)
    {
        if ($shuttle == 'shuttle3') {
            $columns = [
                'Bil',
                'Nama Kilang',
                'No. Pendaftaran SSM',
                'No. Lesen',
                'No. Telefon',
                'No. Faks',
                'Emel',
                'Alamat 1',
                'Alamat 2',
                'Poskod',
                'Daerah Hutan',
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

                'Jumlah Penggunaan Kayu Balak',
                'Jumlah Pengeluaran Kayu Gergaji',
                'Penjualan Kayu Gergaji Eksport',
                'Penjualan Kayu Gergaji Tempatan',
            ];


            if ($statuspemilik == "1") {
                $laporan = Laporan::where('laporan_num', '102')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "2") {
                $laporan = Laporan::where('laporan_num', '103')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "3") {
                $laporan = Laporan::where('laporan_num', '104')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "0") {
                $laporan = Laporan::where('laporan_num', '101')->where('tahun', $tahun)->first();
            }

            if ($title == "1") {
                $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan";
            } else if ($title == "2") {
                $title_laporan = "2. Senarai Pemilik Kilang Papan Bumiputera";
            } else if ($title == "3") {
                $title_laporan = "3. Senarai Pemilik Kilang Papan Bukan Bumiputera";
            } else if ($title == "4") {
                $title_laporan = "4. Senarai Pemilik Kilang Papan Bukan Warganegara";
            }
        } elseif ($shuttle == 'shuttle4') { // IN PROGRESS 15/12/2021
            $columns = [
                'Bil',
                'Nama Kilang',
                'No. Pendaftaran SSM',
                'No. Lesen',
                'No. Telefon',
                'No. Faks',
                'Emel',

                'Alamat 1',
                'Alamat 2',
                'Poskod',
                'Daerah Hutan',
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

                'Jumlah Stok Semasa Kayu Balak',
                'Jumlah Penggunaan Kayu Balak',
                'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
                'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
                'Jumlah Pengeluaran Venir Mengikut Jenis',

                'Jualan Eksport',
                'Jualan Tempatan',
            ];

            if ($statuspemilik == "1") {
                $laporan = Laporan::where('laporan_num', '202')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "2") {
                $laporan = Laporan::where('laporan_num', '203')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "3") {
                $laporan = Laporan::where('laporan_num', '204')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "0") {
                $laporan = Laporan::where('laporan_num', '201')->where('tahun', $tahun)->first();
            }

            $title_laporan = $title;
            if ($title == "201") {
                $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir";
            } else if ($title == "202") {
                $title_laporan = "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera";
            } else if ($title == "203") {
                $title_laporan = "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera";
            } else if ($title == "204") {
                $title_laporan = "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara";
            }
        } else if ($shuttle == 'shuttle5') {
            $columns = [
                'Bil',
                'Nama Kilang',
                'No. Pendaftaran SSM',
                'No. Lesen',
                'No. Telefon',
                'No. Faks',
                'Emel',
                'Alamat 1',
                'Alamat 2',
                'Poskod',
                'Daerah Hutan',
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
                'Penjualan Kayu Kumai Eksport',
                'Penjualan Kayu Kumai Tempatan',
            ];


            if ($statuspemilik == "1") {
                $laporan = Laporan::where('laporan_num', '302')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "2") {
                $laporan = Laporan::where('laporan_num', '303')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "3") {
                $laporan = Laporan::where('laporan_num', '304')->where('tahun', $tahun)->first();
            } else if ($statuspemilik == "0") {
                $laporan = Laporan::where('laporan_num', '301')->where('tahun', $tahun)->first();
            }

            if ($title == "301") {
                $title_laporan = "1. Maklumat Penuh Senarai Kilang Kayu Kumai";
            } else if ($title == "302") {
                $title_laporan = "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera";
            } else if ($title == "303") {
                $title_laporan = "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera";
            } else if ($title == "304") {
                $title_laporan = "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara";
            }
        }



        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', $tahun);

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if (!$laporan) {
        $results = $this->getreport_senaraikilang_proses($shuttle, $statuspemilik, $tahun, $title);
        // } else {
        //     $results = json_decode($laporan->data_laporan);
        // }

        if ($results == "") {
            $results = [];
        }

        // dd($results);

        if ($shuttle == 'shuttle4') {
            return view('admins.laporan-data-lama.201', compact(
                'title',
                'title_laporan',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'statuspemilik',
                'results'
            ));
        } else {
            return view('admins.laporan-data-lama.101', compact(
                'title',
                'title_laporan',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'statuspemilik',
                'results'
            ));
        }
    }

    public function getreport_senaraikilang_proses($shuttle, $statuspemilik, $tahun, $title)
    {
        $pemilikcondition = "";
        if ($statuspemilik == "1") {
            $pemilikcondition = " and A.rekod_statushakmilik_id = 1 and A.rekod_statuswarganegara_id = 1 ";
        } else if ($statuspemilik == "2") {
            $pemilikcondition = " and A.rekod_statushakmilik_id = 1 and A.rekod_statuswarganegara_id = 2 ";
        } else if ($statuspemilik == "3") {
            $pemilikcondition = " and A.rekod_statushakmilik_id = 2 ";
        } else if ($statuspemilik == "0") {
            $pemilikcondition = "";
        }

        $data_kilangs = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun . " " . $pemilikcondition . "
			order by A.rekod_namakilang");

        $rcount = -1;
        // dd($data_kilangs);
        // guna tenaga
        foreach ($data_kilangs as $data_kilang) {
            $rcount++;
            $results[$rcount] = $data_kilang;

            $data_guna_tenagas = DB::connection('mysql2')->select("Select * from
                (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
                sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
                sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p
                from mkk_" . $shuttle . "_gunatenaga A
                inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
                where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
                group by A.rekod_sukutahun) as sub
                order by rekod_sukutahun");
            // dd($data_guna_tenagas);
            foreach ($data_guna_tenagas as $data_guna_tenaga) {
                $results[$rcount]->guna_tenaga = $data_guna_tenaga;
            }

            // penggunaan
            if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {

                $jumlahpenggunaan = DB::connection('mysql2')->select("Select sum(B.bahan_prosesmasuk2) as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
					 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpenggunaan = $jumlahpenggunaan[0]->jumlahpenggunaan;
            } else if ($shuttle == "shuttle4") {

                $results[$rcount]->jumlahpenggunaan = 0;
                for ($i = 1; $i < 13; $i++) {
                    $jumlahpenggunaan = DB::connection('mysql2')->select("Select sum(B.bahan_bakistok2 + B.bahan_kayumasuk2) as jumlahstoksemasa,
						 sum(B.bahan_prosesmasuk2) as jumlahpenggunaan
						 from mkk_" . $shuttle . "_kemasukan A
						 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
						 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $i);

                    if (isset($jumlahpenggunaan[0]->jumlahstoksemasa)) {
                        $results[$rcount]->jumlahstoksemasa = $jumlahpenggunaan[0]->jumlahstoksemasa;
                    }
                    $results[$rcount]->jumlahpenggunaan += $jumlahpenggunaan[0]->jumlahpenggunaan;
                }
            }

            // pengeluaran
            if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {

                $jumlahpengeluaran = DB::connection('mysql2')->select("Select sum(B.bahan_proseskeluar2) as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
					 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran = $jumlahpengeluaran[0]->jumlahpengeluaran;
            } else if ($shuttle == "shuttle4") {

                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran = $sql2[0];

                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2 + B.produk_isipaduwbp2) as jumlahnipis
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.produk_kategori = 0");

                $results[$rcount]->jumlahpengeluaran->nipis = $sql2[0]->jumlahnipis;

                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2 + B.produk_isipaduwbp2) as jumlahtebal
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.produk_kategori = 1");

                $results[$rcount]->jumlahpengeluaran->tebal = $sql2[0]->jumlahtebal;

                $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_veniermuka2) as jumlahmuka, sum(A.rekod_venierteras2) as jumlahteras
					 from mkk_" . $shuttle . "_pengeluaran A
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran->muka = $sql2[0]->jumlahmuka;
                $results[$rcount]->jumlahpengeluaran->teras = $sql2[0]->jumlahteras;
            }
            // penjualan

            if ($shuttle == "shuttle3") {

                $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jumlaheksport from mkk_" . $shuttle . "_penjualan A
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlaheksport = $sql2[0]->jumlaheksport;

                $sql2 = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jumlahtempatan from mkk_" . $shuttle . "_penjualan A
					 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahtempatan = $sql2[0]->jumlahtempatan;
            } else if ($shuttle == "shuttle4") {

                $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jumlaheksportlapis,
					 sum(A.rekod_veniereksport2) as jumlaheksportvenier, sum(A.rekod_veniertempatan2) as jumlahtempatanvenier
					 from mkk_" . $shuttle . "_penjualan A
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlaheksportlapis = $sql2[0]->jumlaheksportlapis;
                $results[$rcount]->jumlaheksportvenier = $sql2[0]->jumlaheksportvenier;
                $results[$rcount]->jumlahtempatanvenier = $sql2[0]->jumlahtempatanvenier;

                $sql2 = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jumlahtempatanlapis from mkk_" . $shuttle . "_penjualan A
					 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahtempatanlapis = $sql2[0]->jumlahtempatanlapis;
                // $results[$rcount]['jumlahtempatanlapis'] = $subrecord['jumlahtempatanlapis'];
            } else if ($shuttle == "shuttle5") {

                $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jumlaheksport, sum(A.rekod_jumlahtempatan2) as jumlahtempatan
					 from mkk_" . $shuttle . "_penjualan A
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlaheksport = $sql2[0]->jumlaheksport;
                $results[$rcount]->jumlahtempatan = $sql2[0]->jumlahtempatan;
            }
        }

        if ($shuttle == 'shuttle3') {

            if ($statuspemilik == "1") {
                $checkLaporan = Laporan::where('laporan_num', '102')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '102',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '102')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "2") {
                $checkLaporan = Laporan::where('laporan_num', '103')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '103',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '103')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "3") {
                $checkLaporan = Laporan::where('laporan_num', '104')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '104',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '104')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "0") {
                $checkLaporan = Laporan::where('laporan_num', '101')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '101',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '101')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            }
        } elseif ($shuttle == 'shuttle4') { // IN PROGRESS 15/12/2021
            if ($statuspemilik == "1") {
                $checkLaporan = Laporan::where('laporan_num', '202')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '202',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '202')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "2") {
                $checkLaporan = Laporan::where('laporan_num', '203')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '203',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '203')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "3") {
                $checkLaporan = Laporan::where('laporan_num', '204')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '204',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '204')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "0") {
                $checkLaporan = Laporan::where('laporan_num', '201')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '201',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '201')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            }
        } elseif ($shuttle == 'shuttle5') {

            if ($statuspemilik == "1") {
                $checkLaporan = Laporan::where('laporan_num', '302')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '302',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '302')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "2") {
                $checkLaporan = Laporan::where('laporan_num', '303')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '303',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '303')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "3") {
                $checkLaporan = Laporan::where('laporan_num', '304')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '304',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '304')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            } else if ($statuspemilik == "0") {
                $checkLaporan = Laporan::where('laporan_num', '301')->where('tahun', $tahun)->count();

                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '301',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results ?? ''),
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '301')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results ?? '');
                    $laporan->save();
                }
            }
        }
        return json_decode($laporan->data_laporan);
    }


    /* ********************************************************************************
	Report 105, 205-206, 305
	******************************************************************************** */
    function getreport_top10pengeluar($shuttle, $tahun, $lapisvenier, $title)
    {
        // dd($title);
        if ($shuttle == 'shuttle3' || $shuttle == 'shuttle5') {
            $columns = [
                'Bil',
                'Nama Kilang',
                'No. Pendaftaran SSM',
                'No. Lesen',
                'No. Telefon',
                'No. Faks',
                'Emel',

                'Alamat 1',
                'Alamat 2',
                'Poskod',
                'Daerah Hutan',
                'Negeri',

                'Alamat Surat Menyurat 1',
                'Alamat Surat Menyurat 2',
                'Poskod',
                'Daerah',

                'Tarikh Kilang Ditubuhkan',
                'Tarikh Kilang Mula Beroperasi',
                'Taraf Sah Syarikat',
                'Status Hak Milik',
                'Jumlah Pengeluaran Kayu Gergaji',
            ];
            if ($shuttle == 'shuttle3') {
                $laporan = Laporan::where('laporan_num', '105')->where('tahun', $tahun)->first();
                $title_laporan = "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan";
            } elseif ($shuttle == 'shuttle5') {
                $laporan = Laporan::where('laporan_num', '305')->where('tahun', $tahun)->first();
                $title_laporan = "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai";
            }
        } else {
            if ($lapisvenier == 1) {
                $columns = [
                    'Bil',
                    'Nama Kilang',
                    'No. Pendaftaran SSM',
                    'No. Lesen',
                    'No. Telefon',
                    'No. Faks',
                    'Emel',

                    'Alamat 1',
                    'Alamat 2',
                    'Poskod',
                    'Daerah Hutan',
                    'Negeri',

                    'Alamat Surat Menyurat 1',
                    'Alamat Surat Menyurat 2',
                    'Poskod',
                    'Daerah',

                    'Tarikh Kilang Ditubuhkan',
                    'Tarikh Kilang Mula Beroperasi',
                    'Taraf Sah Syarikat',
                    'Status Hak Milik',
                    'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
                    'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
                ];

                $laporan = Laporan::where('laporan_num', '205')->where('tahun', $tahun)->first();
                $title_laporan = "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir";
            } else {
                $columns = [
                    'Bil',
                    'Nama Kilang',
                    'No. Pendaftaran SSM',
                    'No. Lesen',
                    'No. Telefon',
                    'No. Faks',
                    'Emel',

                    'Alamat 1',
                    'Alamat 2',
                    'Poskod',
                    'Daerah Hutan',
                    'Negeri',

                    'Alamat Surat Menyurat 1',
                    'Alamat Surat Menyurat 2',
                    'Poskod',
                    'Daerah',

                    'Tarikh Kilang Ditubuhkan',
                    'Tarikh Kilang Mula Beroperasi',
                    'Taraf Sah Syarikat',
                    'Status Hak Milik',
                    'Jumlah Pengeluaran Papan Venir Mengikut Jenis',
                ];

                $laporan = Laporan::where('laporan_num', '206')->where('tahun', $tahun)->first();
                $title_laporan = "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir";
            }
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            [
                'link' => route('laporan'), 'name' => "Laporan"
            ],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', $tahun);

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_top10pengeluar_proses($shuttle, $tahun, $lapisvenier, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }
        // dd($columns);
        if ($shuttle == 'shuttle4') {
            return view('admins.laporan-data-lama.205', compact(
                'title',
                'title_laporan',
                'lapisvenier',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'results'
            ));
        } else {
            return view('admins.laporan-data-lama.105', compact(
                'title',
                'title_laporan',
                'lapisvenier',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'results'
            ));
        }
    }

    function getreport_top10pengeluar_proses($shuttle, $tahun, $lapisvenier, $title)
    {
        $data_kilangs = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun . "
			order by A.rekod_namakilang");

        $rcount = -1;

        foreach ($data_kilangs as $data_kilang) {
            $rcount++;
            $results[$rcount] = $data_kilang;

            if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {

                // TODO: check with user if we need to use pengeluaran table for shuttle 5

                $sql2 = DB::connection('mysql2')->select("Select sum(B.bahan_proseskeluar2) as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
					 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran = $sql2[0]->jumlahpengeluaran;
            } else if ($shuttle == "shuttle4") {

                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran = $sql2[0];

                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2 + B.produk_isipaduwbp2) as jumlahnipis
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.produk_kategori = 0");

                $results[$rcount]->jumlahpengeluaran->nipis = $sql2[0]->jumlahnipis;
                $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2 + B.produk_isipaduwbp2) as jumlahtebal
					 from mkk_" . $shuttle . "_pengeluaran A
					 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.produk_kategori = 1");

                $results[$rcount]->jumlahpengeluaran->tebal = $sql2[0]->jumlahtebal;

                $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_veniermuka2) as jumlahmuka, sum(A.rekod_venierteras2) as jumlahteras
					 from mkk_" . $shuttle . "_pengeluaran A
					 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun);

                $results[$rcount]->jumlahpengeluaran->muka = $sql2[0]->jumlahmuka;
                $results[$rcount]->jumlahpengeluaran->teras = $sql2[0]->jumlahteras;

                $results[$rcount]->jumlahlapis = $results[$rcount]->jumlahpengeluaran->jumlahmr + $results[$rcount]->jumlahpengeluaran->jumlahwbp;
                $results[$rcount]->jumlahvenier = $results[$rcount]->jumlahpengeluaran->muka + $results[$rcount]->jumlahpengeluaran->teras;
            }
        }

        if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {
            $results = $this->array_orderby($results, 'jumlahpengeluaran', SORT_DESC);
        } else if ($shuttle == "shuttle4") {
            if ($lapisvenier == "1") {
                $results = $this->array_orderby($results, 'jumlahlapis', SORT_DESC);
            } else {
                $results = $this->array_orderby($results, 'jumlahvenier', SORT_DESC);
            }
        }

        if ($shuttle == 'shuttle3' || $shuttle == 'shuttle5') {
            if ($shuttle == 'shuttle3') {
                $checkLaporan = Laporan::where('laporan_num', '105')->where('tahun', $tahun)->count();
                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '105',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results) ?? '',
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '105')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results) ?? '';
                    $laporan->save();
                }
            } elseif ($shuttle == 'shuttle5') {
                $checkLaporan = Laporan::where('laporan_num', '305')->where('tahun', $tahun)->count();
                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '305',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results) ?? '',
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '305')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results) ?? '';
                    $laporan->save();
                }
            }
        } else { //shuttle 4
            if ($lapisvenier == 1) {
                $checkLaporan = Laporan::where('laporan_num', '205')->where('tahun', $tahun)->count();
                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '205',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results) ?? '',
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '205')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results) ?? '';
                    $laporan->save();
                }
            } else {
                $checkLaporan = Laporan::where('laporan_num', '206')->where('tahun', $tahun)->count();
                if ($checkLaporan == 0) {
                    $laporan = Laporan::create([ //create laporan data
                        'laporan_num' => '206',
                        'tahun' => $tahun,
                        'shuttle_type' => $shuttle,
                        'data_laporan' => json_encode($results) ?? '',
                    ]);
                } else {
                    $laporan = Laporan::where('laporan_num', '206')->where('tahun', $tahun)->first();
                    $laporan->data_laporan = json_encode($results) ?? '';
                    $laporan->save();
                }
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 106, 207, 306
	******************************************************************************** */
    function getreport_top10pengguna($shuttle, $tahun, $spesies, $title)
    {
        // $spesies_name = Spesis::where('id', $spesies)->first();

        $spesis_lama = DB::connection('mysql2')->select("Select mkk_spesies.*, mkk_kod_kumpulankayu.kod_singkatan as spesies_kumpulankayu from mkk_spesies
        inner join mkk_kod_kumpulankayu on mkk_spesies.spesies_kumpulankayu_id = mkk_kod_kumpulankayu.kod_id
        where spesies_id = '$spesies' order by spesies_kumpulankayu_id, spesies_namatempatan");
        $spesies_name = $spesis_lama[0];

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '106')->where('tahun', $tahun)->where('spesis', $spesies)->first();

            $title_laporan = '6. Top 10 Kilang Papan Dalam Penggunaan Kayu Balak Spesies ' . $spesies_name->spesies_namatempatan;
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '207')->where('tahun', $tahun)->where('spesis', $spesies)->first();

            $title_laporan = '7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir';
        } else {
            $laporan = Laporan::where('laporan_num', '306')->where('tahun', $tahun)->where('spesis', $spesies)->first();

            $title_laporan = 'Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai';
        }

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran SSM',
            'No. Lesen',
            'No. Telefon',
            'No. Faks',
            'Emel',
            'Alamat 1',
            'Alamat 2',
            'Poskod',
            'Daerah Hutan',
            'Negeri',
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Jumlah Penggunaan Kayu Balak',
        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            [
                'link' => route('laporan'), 'name' => "Laporan"
            ],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_top10pengguna_proses($shuttle, $tahun, $spesies, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        return view('admins.laporan-data-lama.106', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'spesies_name',
            'spesies'
        ));
    }

    function getreport_top10pengguna_proses($shuttle, $tahun, $spesies, $title)
    {
        $data_kilangs = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun . "
			order by A.rekod_namakilang");

        $rcount = -1;
        foreach ($data_kilangs as $data_kilang) {
            $rcount++;
            $results[$rcount] = $data_kilang;

            $sql2 = DB::connection('mysql2')->select("Select sum(B.bahan_prosesmasuk2) as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
				 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
				 where A.rekod_nossm = '" . $data_kilang->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
				 and B.bahan_spesies_id = " . $spesies);

            $results[$rcount]->jumlahpenggunaan = $sql2[0]->jumlahpenggunaan;
        }

        $results = $this->array_orderby($results, 'jumlahpenggunaan', SORT_DESC);

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '106')->where('tahun', $tahun)->where('spesis', $spesies)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '106',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'spesis' => $spesies,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '106')->where('tahun', $tahun)->where('spesis', $spesies)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '207')->where('tahun', $tahun)->where('spesis', $spesies)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '207',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'spesis' => $spesies,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '207')->where('tahun', $tahun)->where('spesis', $spesies)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '306')->where('tahun', $tahun)->where('spesis', $spesies)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '306',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'spesis' => $spesies,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '306')->where('tahun', $tahun)->where('spesis', $spesies)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }


        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 208 - shuttle 4 only
	******************************************************************************** */
    function getreport_jumlahpelaburan($shuttle, $tahun, $title)
    {
        $laporan = Laporan::where('laporan_num', '208')->where('tahun', $tahun)->first();

        $title_laporan = "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir";

        $columns = [
            'Bil',
            'Nama Kilang',
            'No. Pendaftaran SSM',
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

            'Nilai Harta Tetap Pada Tahun Berakhir'
        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_jumlahpelaburan_proses($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        // dd($results);
        return view('admins.laporan-data-lama.208', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
        ));
    }

    function getreport_jumlahpelaburan_proses($shuttle, $tahun, $title)
    {
        $results = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun . "
			order by A.rekod_namakilang");

        $checkLaporan = Laporan::where('laporan_num', '208')->where('tahun', $tahun)->count();
        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '208',
                'tahun' => $tahun,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '208')->where('tahun', $tahun)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 107, 209, 307
	******************************************************************************** */
    function getreport_jumlahpelaburan_bynegeri($shuttle, $tahun, $title)
    {
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '107')->where('tahun', $tahun)->first();
            $title_laporan = "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '209')->where('tahun', $tahun)->first();
            $title_laporan = "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir";
        } else {
            $laporan = Laporan::where('laporan_num', '307')->where('tahun', $tahun)->first();
            $title_laporan = "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai";
        }


        $columns = [
            'Bil',
            'Negeri',
            'Nilai Harta Tetap Pada Tahun Berakhir (RM)'
        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_jumlahpelaburan_bynegeri_proses($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        // dd($results);
        return view('admins.laporan-data-lama.107', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
        ));
    }

    function getreport_jumlahpelaburan_bynegeri_proses($shuttle, $tahun, $title)
    {
        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {
            $ncount++;
            $results[$ncount] = $mynegeri;
            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            $results[$ncount]->rekod_nilaiharta = 0;

            $sql = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($sql as $myrecord) {
                $results[$ncount]->rekod_nilaiharta += (float)$myrecord->rekod_nilaiharta;
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '107')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '107',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '107')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '209')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '209',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '209')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '307')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '307',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '307')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 111, 211, 311
	******************************************************************************** */
    function getreport_gunatenagadanpendapatan_bynegeri($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        $quarterdifference = ($sukutahunakhir - $sukutahunmula) + 1;

        if ($sukutahunmula == 1) {
            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            $nama_suku_tahun_akhir = "Keempat";
        }


        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '111')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '211')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Lapis/Venir Mengikut Negeri Dan Jantina";
        } else {
            $laporan = Laporan::where('laporan_num', '311')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Kayu Kumai Mengikut Negeri Dan Jantina";
        }

        $columns = [
            'Bil',
            'Negeri',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)'
        ];


        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_gunatenagadanpendapatan_bynegeri_proses($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $suku_tahun = $sukutahunmula;
        $suku_tahun_akhir = $sukutahunakhir;

        return view('admins.laporan-data-lama.111', compact(
            'title',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'title_laporan'
        ));
    }

    function getreport_gunatenagadanpendapatan_bynegeri_proses($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }


        if ($sukutahunmula == 1) {
            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            $nama_suku_tahun_akhir = "Keempat";
        }

        for ($i = $sukutahunmula; $i <= $sukutahunakhir; $i++) {
            $laporans[$i] = [];

            $mula = $i;
            $akhir = $i;

            $quarterdifference = ($akhir - $mula) + 1;
            $negeris = $this->getnegeri();
            $ncount = -1;

            foreach ($negeris as $mynegeri) {

                $ncount++;
                $results[$ncount] = (object)
                [
                    'gunatenaga' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'pendapatan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'purata' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],

                ];
                $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                foreach ($records as $record) {

                    $gunatenaga_l = 0;
                    $gunatenaga_p = 0;
                    $gunatenaga_all = 0;
                    $pendapatan_l = 0;
                    $pendapatan_p = 0;
                    $pendapatan_all = 0;

                    $sql2 = DB::connection('mysql2')->select("Select * from
					 (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
					 sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
					 sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p,
					 sum(pekerja_gaji_l) as sum_gaji_l, sum(pekerja_gaji_p) as sum_gaji_p
					 from mkk_" . $shuttle . "_gunatenaga A
					 inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
					 where A.rekod_nossm = '" . $record->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 group by A.rekod_sukutahun) as sub
					 order by rekod_sukutahun");

                    foreach ($sql2 as $mysub) {
                        if (($mysub->rekod_sukutahun >= $mula) && ($mysub->rekod_sukutahun <= $akhir)) {
                            // TODO: currently we get guna tenaga based on last examined quarter, to ask
                            // user if this is correct
                            $gunatenaga_l = $mysub->sum_wargabumi_l + $mysub->sum_wargabukanbumi_l + $mysub->sum_bukanwarga_l;
                            $gunatenaga_p = $mysub->sum_wargabumi_p + $mysub->sum_wargabukanbumi_p + $mysub->sum_bukanwarga_p;
                            //$gunatenaga_all = $results[$ncount]['gunatenaga']['l'] + $results[$ncount]['gunatenaga']['p'];
                            $gunatenaga_all = (int)$gunatenaga_l + (int)$gunatenaga_p;
                            $pendapatan_l += (float)$mysub->sum_gaji_l;
                            $pendapatan_p += (float)$mysub->sum_gaji_p;
                            //$pendapatan_all += $results[$ncount]['pendapatan']['l'] + $results[$ncount]['pendapatan']['p'];
                        }
                    }

                    $results[$ncount]->gunatenaga['l'] += (int)$gunatenaga_l;
                    $results[$ncount]->gunatenaga['p'] += (int)$gunatenaga_p;
                    $results[$ncount]->gunatenaga['jumlah'] += (int)$gunatenaga_all;
                    // TODO: currently we average income over quarters for each kilang first, to check with user
                    $results[$ncount]->pendapatan['l'] += (float)$pendapatan_l / $quarterdifference;
                    $results[$ncount]->pendapatan['p'] += (float)$pendapatan_p / $quarterdifference;
                }
                $results[$ncount]->pendapatan['jumlah'] = $results[$ncount]->pendapatan['l'] + $results[$ncount]->pendapatan['p'];
                $results[$ncount]->purata['l'] = ($results[$ncount]->gunatenaga['l'] != 0 ? $results[$ncount]->pendapatan['l'] / $results[$ncount]->gunatenaga['l'] : $results[$ncount]->pendapatan['l']);
                $results[$ncount]->purata['p'] = ($results[$ncount]->gunatenaga['p'] != 0 ? $results[$ncount]->pendapatan['p'] / $results[$ncount]->gunatenaga['p'] : $results[$ncount]->pendapatan['p']);
                $results[$ncount]->purata['jumlah'] = $results[$ncount]->purata['l'] + $results[$ncount]->purata['p'];
            }

            $laporans[$i] = $results;
        }

        // dd($laporans);
        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '111')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '111',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '111')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '211')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '211',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '211')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '311')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '311',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '311')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 112, 212, 312
	******************************************************************************** */

    function getreport_gunatenagadanpendapatan_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        if ($sukutahunmula == 1) {
            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            $nama_suku_tahun_akhir = "Keempat";
        }

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '112')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '212')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan Lapis/Venir";
        } else {
            $laporan = Laporan::where('laporan_num', '312')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Kayu Kumai";
        }


        if (!$laporan) {
            $results = $this->getreport_gunatenagadanpendapatan_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $columns = [
            'Bil',
            'Kategori',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)'
        ];


        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        $suku_tahun = $sukutahunmula;
        $suku_tahun_akhir = $sukutahunakhir;

        // dd($results);

        return view('admins.laporan-data-lama.112', compact(
            'title',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
            'title_laporan'
        ));
    }

    function getreport_gunatenagadanpendapatan_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        for ($i = $sukutahunmula; $i <= $sukutahunakhir; $i++) {
            $laporans[$i] = [];

            $mula = $i;
            $akhir = $i;

            $quarterdifference = ($akhir - $mula) + 1;

            $kategoris = $this->getkategoripekerja();
            $ncount = -1;

            foreach ($kategoris as $mykategori) {

                $ncount++;
                $results[$ncount] = (object)
                [
                    'gunatenaga' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'pendapatan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'purata' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],

                ];

                $results[$ncount]->kod_keterangan = $mykategori->kod_keterangan;

                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun);

                foreach ($records as $record) {
                    $gunatenaga_l = 0;
                    $gunatenaga_p = 0;
                    $gunatenaga_all = 0;
                    $pendapatan_l = 0;
                    $pendapatan_p = 0;
                    $pendapatan_all = 0;

                    $sql2 = DB::connection('mysql2')->select("Select * from
                    (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
                    sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
                    sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p,
                    sum(pekerja_gaji_l) as sum_gaji_l, sum(pekerja_gaji_p) as sum_gaji_p
                    from mkk_" . $shuttle . "_gunatenaga A
                    inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
                    where A.rekod_nossm = '" . $record->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
                    and B.pekerja_kategoripekerja_id = '" . $mykategori->kod_id . "'
                    group by A.rekod_sukutahun) as sub
                    order by rekod_sukutahun");

                    foreach ($sql2 as $mysub) {
                        if (($mysub->rekod_sukutahun >= $mula) && ($mysub->rekod_sukutahun <= $akhir)) {
                            // TODO: currently we get guna tenaga based on last examined quarter, to ask
                            // user if this is correct
                            $gunatenaga_l = (int)$mysub->sum_wargabumi_l + (int)$mysub->sum_wargabukanbumi_l + (int)$mysub->sum_bukanwarga_l;
                            $gunatenaga_p = (int)$mysub->sum_wargabumi_p + (int)$mysub->sum_wargabukanbumi_p + (int)$mysub->sum_bukanwarga_p;
                            //$gunatenaga_all = $results[$ncount]['gunatenaga']['l'] + $results[$ncount]['gunatenaga']['p'];
                            $gunatenaga_all = $gunatenaga_l + $gunatenaga_p;
                            $pendapatan_l += (float)$mysub->sum_gaji_l;
                            $pendapatan_p += (int)$mysub->sum_gaji_p;
                            //$pendapatan_all += $results[$ncount]['pendapatan']['l'] + $results[$ncount]['pendapatan']['p'];
                        }
                    }
                    $results[$ncount]->gunatenaga['l'] += $gunatenaga_l;
                    $results[$ncount]->gunatenaga['p'] += $gunatenaga_p;
                    $results[$ncount]->gunatenaga['jumlah'] += $gunatenaga_all;
                    // TODO: currently we average income over quarters for each kilang first, to check with user
                    $results[$ncount]->pendapatan['l'] += $pendapatan_l / $quarterdifference;
                    $results[$ncount]->pendapatan['p'] += $pendapatan_p / $quarterdifference;
                }
                $results[$ncount]->pendapatan['jumlah'] = $results[$ncount]->pendapatan['l'] + $results[$ncount]->pendapatan['p'];
                $results[$ncount]->purata['l'] = ($results[$ncount]->gunatenaga['l'] != 0 ? $results[$ncount]->pendapatan['l'] / $results[$ncount]->gunatenaga['l'] : $results[$ncount]->pendapatan['l']);
                $results[$ncount]->purata['p'] = ($results[$ncount]->gunatenaga['p'] != 0 ? $results[$ncount]->pendapatan['p'] / $results[$ncount]->gunatenaga['p'] : $results[$ncount]->pendapatan['p']);
                $results[$ncount]->purata['jumlah'] = $results[$ncount]->purata['l'] + $results[$ncount]->purata['p'];
            }

            $laporans[$i] = $results;
        }


        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '112')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '112',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '112')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '212')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '212',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '212')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '312')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '312',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '312')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 113, 213, 313
	******************************************************************************** */

    function getreport_gunatenaga_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        // dd($sukutahunmula);

        if ($sukutahunmula == 1) {
            // $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            // $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            // $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            // $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            // $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            // $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            // $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            // $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah'
        ];

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '113')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '213')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";
        } else {
            $laporan = Laporan::where('laporan_num', '313')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai";
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if (!$laporan) {
            $results = $this->getreport_gunatenaga_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $suku_tahun = $sukutahunmula;
        $suku_tahun_akhir = $sukutahunakhir;

        return view('admins.laporan-data-lama.113', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
        ));
    }

    function getreport_gunatenaga_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        for ($i = $sukutahunmula; $i <= $sukutahunakhir; $i++) {
            $laporans[$i] = [];

            $mula = $i;
            $akhir = $i;

            $quarterdifference = ($akhir - $mula) + 1;
            $kategoris = $this->getkategoripekerja();
            $ncount = -1;

            foreach ($kategoris as $mykategori) {

                $ncount++;
                $results[$ncount] = (object)
                [
                    'wargabumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'wargabukanbumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'bukanwarga' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'keseluruhan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],

                ];
                $results[$ncount]->kod_keterangan = $mykategori->kod_keterangan;

                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun);

                foreach ($records as $myrecord) {

                    $wargabumi_l = 0;
                    $wargabumi_p = 0;
                    $wargabumi_all = 0;
                    $wargabukanbumi_l = 0;
                    $wargabukanbumi_p = 0;
                    $wargabukanbumi_all = 0;
                    $bukanwarga_l = 0;
                    $bukanwarga_p = 0;
                    $bukanwarga_all = 0;

                    $sql2 = DB::connection('mysql2')->select("Select * from
					 (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
					 sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
					 sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p,
					 sum(pekerja_gaji_l) as sum_gaji_l, sum(pekerja_gaji_p) as sum_gaji_p
					 from mkk_" . $shuttle . "_gunatenaga A
					 inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
					 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.pekerja_kategoripekerja_id = " . $mykategori->kod_id . "
					 group by A.rekod_sukutahun) as sub
					 order by rekod_sukutahun");

                    foreach ($sql2 as $mysub) {
                        if (($mysub->rekod_sukutahun >= $mula) && ($mysub->rekod_sukutahun <= $akhir)) {
                            // TODO: currently we get guna tenaga based on last examined quarter, to ask
                            // user if this is correct
                            $wargabumi_l = $mysub->sum_wargabumi_l;
                            $wargabumi_p = $mysub->sum_wargabumi_p;
                            $wargabumi_all = $mysub->sum_wargabumi_l + $mysub->sum_wargabumi_p;
                            $wargabukanbumi_l = $mysub->sum_wargabukanbumi_l;
                            $wargabukanbumi_p = $mysub->sum_wargabukanbumi_p;
                            $wargabukanbumi_all = $mysub->sum_wargabukanbumi_l + $mysub->sum_wargabukanbumi_p;
                            $bukanwarga_l = $mysub->sum_bukanwarga_l;
                            $bukanwarga_p = $mysub->sum_bukanwarga_p;
                            $bukanwarga_all = $mysub->sum_bukanwarga_l + $mysub->sum_bukanwarga_p;
                        }
                    }
                    $results[$ncount]->wargabumi['l'] += $wargabumi_l;
                    $results[$ncount]->wargabumi['p'] += $wargabumi_p;
                    $results[$ncount]->wargabumi['jumlah'] += $wargabumi_all;
                    $results[$ncount]->wargabukanbumi['l'] += $wargabukanbumi_l;
                    $results[$ncount]->wargabukanbumi['p'] += $wargabukanbumi_p;
                    $results[$ncount]->wargabukanbumi['jumlah'] += $wargabukanbumi_all;
                    $results[$ncount]->bukanwarga['l'] += $bukanwarga_l;
                    $results[$ncount]->bukanwarga['p'] += $bukanwarga_p;
                    $results[$ncount]->bukanwarga['jumlah'] += $bukanwarga_all;
                }
                $results[$ncount]->keseluruhan['l'] = $results[$ncount]->wargabumi['l'] + $results[$ncount]->wargabukanbumi['l'] + $results[$ncount]->bukanwarga['l'];
                $results[$ncount]->keseluruhan['p'] = $results[$ncount]->wargabumi['p'] + $results[$ncount]->wargabukanbumi['p'] + $results[$ncount]->bukanwarga['p'];
                $results[$ncount]->keseluruhan['jumlah'] = $results[$ncount]->wargabumi['jumlah'] + $results[$ncount]->wargabukanbumi['jumlah'] + $results[$ncount]->bukanwarga['jumlah'];
            }

            $laporans[$i] = $results;
        }

        // dd($laporans);
        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '113')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '113',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '213')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '213')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '213',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '213')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '313')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '313',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '313')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 114, 214, 314
	******************************************************************************** */
    function getreport_gunatenaga_bynegeri($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        // dd($sukutahunmula);

        if ($sukutahunmula == 1) {
            // $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            // $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            // $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            // $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            // $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            // $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            // $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            // $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        $columns = [
            'Bil',
            'Negeri',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah'
        ];

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '114')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '214')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";
        } else {
            $laporan = Laporan::where('laporan_num', '314')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Kayu Kumai";
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        if (!$laporan) {
            $results = $this->getreport_gunatenaga_bynegeri_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $suku_tahun = $sukutahunmula;
        $suku_tahun_akhir = $sukutahunakhir;

        return view('admins.laporan-data-lama.114', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'tahun',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir'
        ));
    }

    function getreport_gunatenaga_bynegeri_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        for ($i = $sukutahunmula; $i <= $sukutahunakhir; $i++) {
            $laporans[$i] = [];

            $mula = $i;
            $akhir = $i;

            $quarterdifference = ($akhir - $mula) + 1;
            $negeris = $this->getnegeri();
            $ncount = -1;

            foreach ($negeris as $mynegeri) {

                $ncount++;
                $results[$ncount] = (object)
                [
                    'wargabumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'wargabukanbumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'bukanwarga' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'keseluruhan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],

                ];

                $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                foreach ($records as $myrecord) {

                    $wargabumi_l = 0;
                    $wargabumi_p = 0;
                    $wargabumi_all = 0;
                    $wargabukanbumi_l = 0;
                    $wargabukanbumi_p = 0;
                    $wargabukanbumi_all = 0;
                    $bukanwarga_l = 0;
                    $bukanwarga_p = 0;
                    $bukanwarga_all = 0;

                    $sql2 = DB::connection('mysql2')->select("Select * from
					 (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
					 sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
					 sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p,
					 sum(pekerja_gaji_l) as sum_gaji_l, sum(pekerja_gaji_p) as sum_gaji_p
					 from mkk_" . $shuttle . "_gunatenaga A
					 inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
					 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 group by A.rekod_sukutahun) as sub
					 order by rekod_sukutahun");


                    foreach ($sql2 as $mysub) {
                        if (($mysub->rekod_sukutahun >= $mula) && ($mysub->rekod_sukutahun <= $akhir)) {

                            $wargabumi_l = $mysub->sum_wargabumi_l;
                            $wargabumi_p = $mysub->sum_wargabumi_p;
                            $wargabumi_all = $mysub->sum_wargabumi_l + $mysub->sum_wargabumi_p;
                            $wargabukanbumi_l = $mysub->sum_wargabukanbumi_l;
                            $wargabukanbumi_p = $mysub->sum_wargabukanbumi_p;
                            $wargabukanbumi_all = $mysub->sum_wargabukanbumi_l + $mysub->sum_wargabukanbumi_p;
                            $bukanwarga_l = $mysub->sum_bukanwarga_l;
                            $bukanwarga_p = $mysub->sum_bukanwarga_p;
                            $bukanwarga_all = $mysub->sum_bukanwarga_l + $mysub->sum_bukanwarga_p;
                        }
                    }
                    $results[$ncount]->wargabumi['l'] += $wargabumi_l;
                    $results[$ncount]->wargabumi['p'] += $wargabumi_p;
                    $results[$ncount]->wargabumi['jumlah'] += $wargabumi_all;
                    $results[$ncount]->wargabukanbumi['l'] += $wargabukanbumi_l;
                    $results[$ncount]->wargabukanbumi['p'] += $wargabukanbumi_p;
                    $results[$ncount]->wargabukanbumi['jumlah'] += $wargabukanbumi_all;
                    $results[$ncount]->bukanwarga['l'] += $bukanwarga_l;
                    $results[$ncount]->bukanwarga['p'] += $bukanwarga_p;
                    $results[$ncount]->bukanwarga['jumlah'] += $bukanwarga_all;
                }
                $results[$ncount]->keseluruhan['l'] = $results[$ncount]->wargabumi['l'] + $results[$ncount]->wargabukanbumi['l'] + $results[$ncount]->bukanwarga['l'];
                $results[$ncount]->keseluruhan['p'] = $results[$ncount]->wargabumi['p'] + $results[$ncount]->wargabukanbumi['p'] + $results[$ncount]->bukanwarga['p'];
                $results[$ncount]->keseluruhan['jumlah'] = $results[$ncount]->wargabumi['jumlah'] + $results[$ncount]->wargabukanbumi['jumlah'] + $results[$ncount]->bukanwarga['jumlah'];
            }
            $laporans[$i] = $results;
        }
        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '114')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '114',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '114')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '214')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '214',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '214')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '314')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '314',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '314')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        }
        // dd($laporans);


        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 115, 215, 315
	******************************************************************************** */

    function getreport_pecahangunatenagadanpendapatan_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        // dd($sukutahunmula);

        if ($sukutahunmula == 1) {
            // $start_date = $tahun . "-01-01";

            $nama_suku_tahun = "Pertama";
        } elseif ($sukutahunmula == 2) {
            // $start_date = $tahun . "-04-01";

            $nama_suku_tahun = "Kedua";
        } elseif ($sukutahunmula == 3) {
            // $start_date = $tahun . "-07-01";

            $nama_suku_tahun = "Ketiga";
        } elseif ($sukutahunmula == 4) {
            // $start_date = $tahun . "-10-01";

            $nama_suku_tahun = "Keempat";
        }

        if ($sukutahunakhir == 1) {
            // $end_date = $tahun . "-03-31";

            $nama_suku_tahun_akhir = "Pertama";
        } elseif ($sukutahunakhir == 2) {
            // $end_date = $tahun . "-06-30";

            $nama_suku_tahun_akhir = "Kedua";
        } elseif ($sukutahunakhir == 3) {
            // $end_date = $tahun . "-09-30";

            $nama_suku_tahun_akhir = "Ketiga";
        } elseif ($sukutahunakhir == 4) {
            // $end_date = $tahun . "-12-31";

            $nama_suku_tahun_akhir = "Keempat";
        }

        $columns = [
            'Bil',
            'Kategori',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah Guna Tenaga',
            'Pendapatan (RM)',
            'Purata Pendapatan (RM)'
        ];

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '115')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '215')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir";
        } else {
            $laporan = Laporan::where('laporan_num', '315')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
            $title_laporan = "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai";
        }

        $suku_tahun = $sukutahunmula;
        $suku_tahun_akhir = $sukutahunakhir;

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // if (!$laporan) {
            $results = $this->getreport_pecahangunatenagadanpendapatan_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title);
        // } else {
        //     $results = json_decode($laporan->data_laporan);
        // }

        // dd($results);

        return view('admins.laporan-data-lama.115', compact(
            'title',
            'title_laporan',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'suku_tahun',
            'suku_tahun_akhir',
            'nama_suku_tahun',
            'nama_suku_tahun_akhir',
        ));
    }

    function getreport_pecahangunatenagadanpendapatan_bykategori_process($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title)
    {
        if ($sukutahunmula > $sukutahunakhir) {
            $temp = $sukutahunmula;

            $sukutahunmula = $sukutahunakhir;

            $sukutahunakhir = $temp;
        }

        for ($i = $sukutahunmula; $i <= $sukutahunakhir; $i++) {
            $laporans[$i] = [];

            $mula = $i;
            $akhir = $i;

            $quarterdifference = ($akhir - $mula) + 1;
            $kategoris = $this->getkategoripekerja();
            $ncount = -1;

            foreach ($kategoris as $mykategori) {

                $ncount++;
                $results[$ncount] = (object)
                [
                    'wargabumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'wargabukanbumi' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'bukanwarga' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'keseluruhan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'pendapatan' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],
                    'purata' =>
                    [
                        'l' => 0,
                        'p' => 0,
                        'jumlah' => 0
                    ],

                ];
                $results[$ncount]->kod_keterangan = $mykategori->kod_keterangan;

                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun);

                foreach ($records as $myrecord) {

                    $wargabumi_l = 0;
                    $wargabumi_p = 0;
                    $wargabumi_all = 0;
                    $wargabukanbumi_l = 0;
                    $wargabukanbumi_p = 0;
                    $wargabukanbumi_all = 0;
                    $bukanwarga_l = 0;
                    $bukanwarga_p = 0;
                    $bukanwarga_all = 0;
                    $pendapatan_l = 0;
                    $pendapatan_p = 0;
                    $pendapatan_all = 0;

                    $sql2 = DB::connection('mysql2')->select("Select * from
					 (Select A.rekod_sukutahun, sum(pekerja_wargabumi_l) as sum_wargabumi_l, sum(pekerja_wargabumi_p) as sum_wargabumi_p,
					 sum(pekerja_wargabukanbumi_l) as sum_wargabukanbumi_l, sum(pekerja_wargabukanbumi_p) as sum_wargabukanbumi_p,
					 sum(pekerja_bukanwarga_l) as sum_bukanwarga_l, sum(pekerja_bukanwarga_p) as sum_bukanwarga_p,
					 sum(pekerja_gaji_l) as sum_gaji_l, sum(pekerja_gaji_p) as sum_gaji_p
					 from mkk_" . $shuttle . "_gunatenaga A
					 inner join mkk_" . $shuttle . "_gunatenaga_pekerja B on A.rekod_id = B.pekerja_rekod_id
					 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
					 and B.pekerja_kategoripekerja_id = " . $mykategori->kod_id . "
					 group by A.rekod_sukutahun) as sub
					 order by rekod_sukutahun");

                    foreach ($sql2 as $mysub) {
                        if (($mysub->rekod_sukutahun >= $mula) && ($mysub->rekod_sukutahun <= $akhir)) {
                            // TODO: currently we get guna tenaga based on last examined quarter, to ask
                            // user if this is correct
                            $wargabumi_l = $mysub->sum_wargabumi_l;
                            $wargabumi_p = $mysub->sum_wargabumi_p;
                            $wargabumi_all = $mysub->sum_wargabumi_l + $mysub->sum_wargabumi_p;
                            $wargabukanbumi_l = $mysub->sum_wargabukanbumi_l;
                            $wargabukanbumi_p = $mysub->sum_wargabukanbumi_p;
                            $wargabukanbumi_all = $mysub->sum_wargabukanbumi_l + $mysub->sum_wargabukanbumi_p;
                            $bukanwarga_l = $mysub->sum_bukanwarga_l;
                            $bukanwarga_p = $mysub->sum_bukanwarga_p;
                            $bukanwarga_all = $mysub->sum_bukanwarga_l + $mysub->sum_bukanwarga_p;
                            $pendapatan_l += $mysub->sum_gaji_l;
                            $pendapatan_p += $mysub->sum_gaji_p;
                        }
                    }
                    $results[$ncount]->wargabumi['l'] += $wargabumi_l;
                    $results[$ncount]->wargabumi['p'] += $wargabumi_p;
                    $results[$ncount]->wargabumi['jumlah'] += $wargabumi_all;
                    $results[$ncount]->wargabukanbumi['l'] += $wargabukanbumi_l;
                    $results[$ncount]->wargabukanbumi['p'] += $wargabukanbumi_p;
                    $results[$ncount]->wargabukanbumi['jumlah'] += $wargabukanbumi_all;
                    $results[$ncount]->bukanwarga['l'] += $bukanwarga_l;
                    $results[$ncount]->bukanwarga['p'] += $bukanwarga_p;
                    $results[$ncount]->bukanwarga['jumlah'] += $bukanwarga_all;
                    $results[$ncount]->pendapatan['l'] += $pendapatan_l / $quarterdifference;
                    $results[$ncount]->pendapatan['p'] += $pendapatan_p / $quarterdifference;
                    // $quarterdifference is ALWAYS 1 anyway (same for reports 112 et al)

                }
                $results[$ncount]->keseluruhan['l'] = $results[$ncount]->wargabumi['l'] + $results[$ncount]->wargabukanbumi['l'] + $results[$ncount]->bukanwarga['l'];
                $results[$ncount]->keseluruhan['p'] = $results[$ncount]->wargabumi['p'] + $results[$ncount]->wargabukanbumi['p'] + $results[$ncount]->bukanwarga['p'];
                $results[$ncount]->keseluruhan['jumlah'] = $results[$ncount]->wargabumi['jumlah'] + $results[$ncount]->wargabukanbumi['jumlah'] + $results[$ncount]->bukanwarga['jumlah'];

                $results[$ncount]->pendapatan['jumlah'] = $results[$ncount]->pendapatan['l'] + $results[$ncount]->pendapatan['p'];
                $results[$ncount]->purata['l'] = ($results[$ncount]->keseluruhan['l'] != 0 ? $results[$ncount]->pendapatan['l'] / $results[$ncount]->keseluruhan['l'] : $results[$ncount]->pendapatan['l']);
                $results[$ncount]->purata['p'] = ($results[$ncount]->keseluruhan['p'] != 0 ? $results[$ncount]->pendapatan['p'] / $results[$ncount]->keseluruhan['p'] : $results[$ncount]->pendapatan['p']);
                //$results[$ncount]['purata']['jumlah'] = $results[$ncount]['purata']['l'] + $results[$ncount]['purata']['p'];
                $results[$ncount]->purata['jumlah'] = $results[$ncount]->pendapatan['jumlah'] / ($results[$ncount]->keseluruhan['jumlah'] != 0 ? $results[$ncount]->keseluruhan['jumlah'] : 1);
            }

            $laporans[$i] = $results;
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '115')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '115',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '115')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '215')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '215',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '215')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '315')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '315',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'suku_tahun' => $sukutahunmula,
                    'suku_tahun_akhir' => $sukutahunakhir,
                    'data_laporan' => json_encode($laporans) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '315')->where('tahun', $tahun)->where('suku_tahun', $sukutahunmula)->where('suku_tahun_akhir', $sukutahunakhir)->first();
                $laporan->data_laporan = json_encode($laporans) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 121, 221, 321
	******************************************************************************** */

    function getreport_penggunaan_bynegeri($shuttle, $tahun, $title)
    {
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '121')->where('tahun', $tahun)->first();
            $title_laporan = "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '221')->where('tahun', $tahun)->first();
            $title_laporan = "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan";
        } else {
            $laporan = Laporan::where('laporan_num', '321')->where('tahun', $tahun)->first();
            $title_laporan = "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan";
        }

        if (!$laporan) {
            $results = $this->getreport_penggunaan_bynegeri_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jumlahpenggunaan' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jumlahpenggunaan[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                $grandtotal->jumlahpenggunaan[$gi] += $result->jumlahpenggunaan->$gi;
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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.121', compact(
            'title_laporan',
            'title',
            'columns',
            'tahun',
            'shuttle',
            'returnArr',
            'results',
            'grandtotal'
        ));
    }

    function getreport_penggunaan_bynegeri_process($shuttle, $tahun, $title)
    {
        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {
            $ncount++;

            $results[$ncount] = (object)[
                'negeri_keterangan' => '',
                'jumlahpenggunaan' => [],
            ];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jumlahpenggunaan[$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    $sql2 = DB::connection('mysql2')->select("Select sum(B.bahan_prosesmasuk2) as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
						 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                    $results[$ncount]->jumlahpenggunaan[$bi] += $sql2[0]->jumlahpenggunaan;
                    $results[$ncount]->jumlahpenggunaan[13] += $sql2[0]->jumlahpenggunaan;
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '121')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '121',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '121')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '221')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '221',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '221')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '321')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '321',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '321')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }
    /* ********************************************************************************
	Report 122, 222, 322
	******************************************************************************** */
    function getreport_penggunaan_bynegeri_bytahun($shuttle, $tahun, $tahunakhir, $title)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '122')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '222')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa";
        } else {
            $laporan = Laporan::where('laporan_num', '322')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";
        }

        if (!$laporan) {
            $results = $this->getreport_penggunaan_bynegeri_bytahun_process($shuttle, $tahun, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        // dd($results);

        $grandtotal = (object)[
            'jumlahpenggunaan' => [],
        ];

        $tahunjumlah = $tahunakhir + 1;

        for ($gi = $tahun; $gi <= $tahunjumlah; $gi++) {
            $grandtotal->jumlahpenggunaan[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = $tahun; $gi <= $tahunjumlah; $gi++) {
                $grandtotal->jumlahpenggunaan[$gi] += $result->jumlahpenggunaan->$gi;
            }
        }

        $columns = [
            'Bil',
            'Negeri',
        ];
        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.122', compact(
            'title_laporan',
            'title',
            'columns',
            'tahun',
            'tahunakhir',
            'shuttle',
            'returnArr',
            'results',
            'grandtotal'
        ));
    }

    function getreport_penggunaan_bynegeri_bytahun_process($shuttle, $tahun, $tahunakhir, $title)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[
                'jumlahpenggunaan' => []
            ];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);
            for ($bi = $tahun; $bi <= $tahunjumlah; $bi++) {
                $results[$ncount]->jumlahpenggunaan[$bi] = 0;
            }

            for ($bi = $tahun; $bi <= $tahunakhir; $bi++) {
                if ($bi < 2021) {
                    $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
					mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
					mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
					mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
					pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
					from mkk_" . $shuttle . "_index I
					inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
					inner join negeri on A.rekod_negeri_id = negeri.negeri_id
					inner join daerah on A.rekod_daerah_id = daerah.daerah_id
					inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
					inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
					left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
					inner join negara on A.rekod_negara_id = negara.negara_id
					inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
					inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
					where A.rekod_tahun = " . $bi . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                    foreach ($records as $myrecord) {
                        $subrecord = DB::connection('mysql2')->select("Select sum(B.bahan_prosesmasuk2) as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
						 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi);

                        $results[$ncount]->jumlahpenggunaan[$bi] += $subrecord[0]->jumlahpenggunaan;
                        $results[$ncount]->jumlahpenggunaan[$tahunjumlah] += $subrecord[0]->jumlahpenggunaan;
                    }
                } else {
                    if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {
                        if ($shuttle == "shuttle3") {
                            $shuttle_id = '3';
                        } elseif ($shuttle == "shuttle5") {
                            $shuttle_id = '5';
                        }
                        $records = DB::select("SELECT shuttles.negeri_id as negeri,
                        sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                        FROM
                        shuttles,
                        form_c_s,
                        kemasukan_bahans

                        WHERE form_c_s.shuttle_id = shuttles.id
                        AND form_c_s.id = kemasukan_bahans.formcs_id

                        AND shuttles.shuttle_type = '$shuttle_id'
                        AND form_c_s.status = 'Lulus'
                        AND form_c_s.tahun = '$bi'
                        AND shuttles.negeri_id = '$mynegeri->negeri_keterangan'
                        GROUP BY
                        shuttles.negeri_id;
                    ");
                        foreach ($records as $myrecord) {
                            $results[$ncount]->jumlahpenggunaan[$bi] += $myrecord->jumlah_penggunaan;
                            $results[$ncount]->jumlahpenggunaan[$tahunjumlah] += $myrecord->jumlah_penggunaan;
                        }
                    } elseif ($shuttle == "shuttle4") {
                        if ($shuttle == "shuttle4") {
                            $shuttle_id = '4';
                        $records = DB::select("SELECT shuttles.negeri_id as negeri,
                        sum(round(kemasukan_bahans.proses_masuk)) as jumlah_penggunaan

                        FROM
                        shuttles,
                        form_c_s,
                        kemasukan_bahans

                        WHERE form_c_s.shuttle_id = shuttles.id
                        AND form_c_s.id = kemasukan_bahans.formcs_id

                        AND shuttles.shuttle_type = '$shuttle_id'
                        AND form_c_s.status = 'Lulus'
                        AND form_c_s.tahun = '$bi'
                        AND shuttles.negeri_id = '$mynegeri->negeri_keterangan'
                        GROUP BY
                        shuttles.negeri_id;
                    ");
                        foreach ($records as $myrecord) {
                            $results[$ncount]->jumlahpenggunaan[$bi] += $myrecord->jumlah_penggunaan;
                            $results[$ncount]->jumlahpenggunaan[$tahunjumlah] += $myrecord->jumlah_penggunaan;
                        }
                    }
                }
            }
        }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '122')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '122',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '122')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '222')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '222',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '222')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '322')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '322',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '322')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 123, 223, 323
	******************************************************************************** */

    function getreport_penggunaan_bykumpulankayu_bynegeri($shuttle, $tahun, $title)
    {

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '123')->where('tahun', $tahun)->first();
            $title_laporan = "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '223')->where('tahun', $tahun)->first();
            $title_laporan = "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";
        } else {
            $laporan = Laporan::where('laporan_num', '323')->where('tahun', $tahun)->first();
            $title_laporan = "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan";
        }

        if (!$laporan) {
            $results = $this->getreport_penggunaan_bykumpulankayu_bynegeri_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }
        $negeri_list = Daerah::distinct()->get('negeri');

        $kumpulan_kayu = KumpulanKayu::get();

        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
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

        return view('admins.laporan-data-lama.123', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'results',
            'tahun',
            'shuttle',
        ));
    }

    function getreport_penggunaan_bykumpulankayu_bynegeri_process($shuttle, $tahun, $title)
    {
        $tempnegeris = $this->getnegeri();
        $ssms = "";
        $nid = -1;
        foreach ($tempnegeris as $mytempnegeri) {
            $nid++;
            $negeris[$nid] = (object)[];
            // dd($mytempnegeri);
            $negeris[$nid] = $mytempnegeri;

            $negeris[$nid]->ssms = "";
            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mytempnegeri->negeri_id);

            foreach ($records as $myrecord) {
                $ssmstate[$myrecord->rekod_nossm] = (object)[];

                $negeris[$nid]->ssms .= ",'" . $myrecord->rekod_nossm . "'";
                // june 2021
                $ssms .= ",'" . $myrecord->rekod_nossm . "'";
                $ssmstate[$myrecord->rekod_nossm] = $nid;
            }
            if ($negeris[$nid]->ssms != "") {
                $negeris[$nid]->ssms = substr($negeris[$nid]->ssms, 1);
            } else {
                $negeris[$nid]->ssms = "''";
            }
        }
        // june 2021
        if ($ssms != "") {
            $ssms = substr($ssms, 1);
        } else {
            $ssms = "''";
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;
            $results[$scount]->jumlahkeseluruhan = 0;

            $ncount = -1;
            foreach ($negeris as $mynegeri) {
                $ncount++;
                $results[$scount]->jumlahpenggunaan[$ncount] = 0;
            }

            $subrecords = DB::connection('mysql2')->select("Select B.bahan_prosesmasuk2 as jumlahpenggunaan, A.rekod_nossm as rekod_nossm from mkk_" . $shuttle . "_kemasukan A
				 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
				 where A.rekod_nossm in (" . $ssms . ") and A.rekod_tahun = " . $tahun . "
				 and B.bahan_spesies_id = " . $myspesies->spesies_id);

            foreach ($subrecords as $subrec) {
                $stateindex = $ssmstate[$subrec->rekod_nossm] ?? 0;
                $results[$scount]->jumlahpenggunaan[$stateindex] += $subrec->jumlahpenggunaan;
                $results[$scount]->jumlahkeseluruhan += $subrec->jumlahpenggunaan;
            }
        }

        if ($shuttle == 'shuttle3') {

            $checkLaporan = Laporan::where('laporan_num', '123')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '123',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '123')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {

            $checkLaporan = Laporan::where('laporan_num', '223')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '223',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '223')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {

            $checkLaporan = Laporan::where('laporan_num', '323')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '323',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '323')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 124, 224, 324
	******************************************************************************** */
    function getreport_penggunaan_bykumpulankayu_bybulan($shuttle, $tahun, $title)
    {

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '124')->where('tahun', $tahun)->first();
            $title_laporan = "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '224')->where('tahun', $tahun)->first();
            $title_laporan = "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan";
        } else {
            $laporan = Laporan::where('laporan_num', '324')->where('tahun', $tahun)->first();
            $title_laporan = "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan";
        }

        if (!$laporan) {
            $results = $this->getreport_penggunaan_bykumpulankayu_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $kumpulan_kayu = KumpulanKayu::get();

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

        // dd($results);

        return view('admins.laporan-data-lama.124', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'kumpulan_kayu',
            'results',
            'tahun',
            'shuttle',
        ));
    }

    function getreport_penggunaan_bykumpulankayu_bybulan_process($shuttle, $tahun)
    {
        $records = DB::connection('mysql2')->select(
            "Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun
        );

        foreach ($records as $myrecord) {
            $ssms[$myrecord->rekod_nossm] = (object)[];
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$scount]->jumlahpenggunaan[$bi] = 0;
            }

            $subrecords = DB::connection('mysql2')->select("Select A.rekod_bulan, B.bahan_prosesmasuk2 as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
				 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
				 where A.rekod_tahun = " . $tahun . "
				 and B.bahan_spesies_id = " . $myspesies->spesies_id . "
                                 order by A.rekod_bulan ASC");

            foreach ($subrecords as $subrec) {
                $bindex = intval($subrec->rekod_bulan);
                $results[$scount]->jumlahpenggunaan[$bindex] += $subrec->jumlahpenggunaan;
                $results[$scount]->jumlahpenggunaan[13] += $subrec->jumlahpenggunaan;
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '124')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '124',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '124')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '224')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '224',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '224')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '324')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '324',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '324')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 125, 225, 325
	******************************************************************************** */
    function getreport_penggunaan_bykumpulankayu_bytahun($shuttle, $tahun, $tahunakhir, $title)
    {

        // dd('masuk');
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '125')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '225')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";
        } else {
            $laporan = Laporan::where('laporan_num', '325')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";
        }

        if (!$laporan) {
            $results = $this->getreport_penggunaan_bykumpulankayu_bytahun_process($shuttle, $tahun, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $kumpulan_kayu = KumpulanKayu::get();


        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
        ];

        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

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

        // dd($results);

        return view('admins.laporan-data-lama.125', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'kumpulan_kayu',
            'results',
            'tahun',
            'tahunakhir',
            'shuttle',
        ));
    }

    function getreport_penggunaan_bykumpulankayu_bytahun_process($shuttle, $tahun, $tahunakhir, $title)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        // june 2021 - compile full ssm list as well
        $ssmfull = "";
        $tahuns = "";
        for ($ti = $tahun; $ti <= $tahunakhir; $ti++) {
            if ($ti < 2021) {
                $tahuns .= "," . $ti;
            }
        }
        if ($tahuns != "") {
            $tahuns = substr($tahuns, 1);
        } else {
            $tahuns = "''";
        }
        // dd($tahuns);
        // 17/1/2017 - compile company ssms according to tahun first (instead of in species loop)
        $ssms = array();
        for ($bi = $tahun; $bi <= $tahunakhir; $bi++) {
            $ssms[$bi] = "";
            if ($bi < 2021) {
                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $bi);
                foreach ($records as $myrecord) {
                    $ssms[$bi] .= ",'" . $myrecord->rekod_nossm . "'";
                    // june 2021
                    $ssmfull .= ",'" . $myrecord->rekod_nossm . "'";
                }
                if ($ssms[$bi] != "") {
                    $ssms[$bi] = substr($ssms[$bi], 1);
                } else {
                    $ssms[$bi] = "''";
                }
            }
        }
        // june 2021
        if ($ssmfull != "") {
            $ssmfull = substr($ssmfull, 1);
        } else {
            $ssmfull = "''";
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;

            for ($bi = $tahun; $bi <= $tahunjumlah; $bi++) {
                $results[$scount]->jumlahpenggunaan[$bi] = 0;
            }
            $subrecords = DB::connection('mysql2')->select("Select A.rekod_tahun, B.bahan_prosesmasuk2 as jumlahpenggunaan from mkk_" . $shuttle . "_kemasukan A
                    inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
                    where A.rekod_nossm in (" . $ssmfull . ") and A.rekod_tahun in (" . $tahuns . ")
                    and B.bahan_spesies_id = " . $myspesies->spesies_id);

            foreach ($subrecords as $subrec) {
                $tindex = intval($subrec->rekod_tahun);
                $results[$scount]->jumlahpenggunaan[$tindex] += $subrec->jumlahpenggunaan;
                $results[$scount]->jumlahpenggunaan[$tahunjumlah] += $subrec->jumlahpenggunaan;
            }
            for ($i = 2021; $i < $tahunjumlah; $i++) {
                if ($shuttle == 'shuttle3') {
                    $shuttle_type = '3';
                } elseif ($shuttle == 'shuttle4') {
                    $shuttle_type = '4';
                } else {
                    $shuttle_type = '5';
                }

                $spesis = Spesis::where('nama_tempatan', $myspesies->spesies_namatempatan)->first();
                // dd($myspesies);
                // $kumpulan_kayu = KumpulanKayu::where('singkatan', $myspesies->spesies_kumpulankayu)->first();

                //data baru
                if ($spesis) {
                    $data = DB::select("SELECT
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

                        AND shuttles.shuttle_type = '$shuttle_type'
                        AND form_c_s.status = 'Lulus'
                        -- AND kumpulan_kayus.keterangan = '$spesis->keterangan'
                        AND spesis.nama_tempatan = '$spesis->nama_tempatan'
                        AND kemasukan_bahans.tahun = '$i'

                        GROUP BY
                        form_c_s.tahun
                    ;");
                    $results[$scount]->jumlahpenggunaan[$i] += $data[0]->jumlah_penggunaan ?? 0;
                    $results[$scount]->jumlahpenggunaan[$tahunjumlah] += $data[0]->jumlah_penggunaan ?? 0;
                } else {
                    $results[$scount]->jumlahpenggunaan[$i] += 0;
                    $results[$scount]->jumlahpenggunaan[$tahunjumlah] += 0;
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '125')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '125',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '125')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '225')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '225',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '225')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '325')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '325',
                    'tahun' => $tahun,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '325')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 131, 231/233/236/238, 331
	******************************************************************************** */

    function getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title)
    {

        // dd($shuttle);
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '131')->where('tahun', $tahun)->first();
            $title_laporan = "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '231')->where('tahun', $tahun)->first();
            if ($title == '231') {
                $title_laporan = "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan";
            } elseif ($title == '233') {
                $title_laporan = "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri dan Bulan Mengikut Jenis";
            } elseif ($title == '236') {
                $title_laporan = "36. Pengeluaran Venir Mengikut Negeri Dan Bulan";
            } elseif ($title == '238') {
                $title_laporan = "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis";
            }
        } else {
            $laporan = Laporan::where('laporan_num', '331')->where('tahun', $tahun)->first();
            $title_laporan = "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan";
        }

        if (!$laporan) {
            $results = $this->getreport_pengeluaran_bynegeri_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jumlahpengeluaran[$gi] = 0;
            $grandtotal->jumlahpengeluaran['mr'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['wbp'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['muka'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['teras'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['venier'][$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                $grandtotal->jumlahpengeluaran[$gi] += $result->jumlahpengeluaran->$gi;
                $grandtotal->jumlahpengeluaran['mr'][$gi] += (float)$result->jumlahpengeluaran->mr->$gi;
                $grandtotal->jumlahpengeluaran['wbp'][$gi] += (float)$result->jumlahpengeluaran->wbp->$gi;
                $grandtotal->jumlahpengeluaran['muka'][$gi] += (float)$result->jumlahpengeluaran->muka->$gi;
                $grandtotal->jumlahpengeluaran['teras'][$gi] += (float)$result->jumlahpengeluaran->teras->$gi;
                $grandtotal->jumlahpengeluaran['venier'][$gi] += (float)$result->jumlahpengeluaran->venier->$gi;
            }
        }
        if ($title == '233' || $title == '238') {
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
        } else {
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
        }


        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($results);

        if ($title == '233' || $title == '238') {
            return view('admins.laporan-data-lama.233', compact(
                'title',
                'title_laporan',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'results',
                'grandtotal'
            ));
        } else {
            return view('admins.laporan-data-lama.131', compact(
                'title',
                'title_laporan',
                'columns',
                'tahun',
                'shuttle',
                'returnArr',
                'results',
                'grandtotal'
            ));
        }
    }

    function getreport_pengeluaran_bynegeri_bybulan_process($shuttle, $tahun, $title)
    {

        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[
                'jumlahpengeluaran' => []
            ];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);
            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jumlahpengeluaran[$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['mr'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['wbp'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['muka'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['teras'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['venier'][$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    if ($shuttle == "shuttle3") {

                        $sql2 = DB::connection('mysql2')->select("Select sum(B.bahan_proseskeluar2) as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
							 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi);
                        $results[$ncount]->jumlahpengeluaran[$bi] += $sql2[0]->jumlahpengeluaran;
                        $results[$ncount]->jumlahpengeluaran[13] += $sql2[0]->jumlahpengeluaran;
                    } else if ($shuttle == "shuttle5") {

                        $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadu2) as jumlahpengeluaran from mkk_" . $shuttle . "_pengeluaran A
							 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi);
                        $results[$ncount]->jumlahpengeluaran[$bi] += $sql2[0]->jumlahpengeluaran;
                        $results[$ncount]->jumlahpengeluaran[13] += $sql2[0]->jumlahpengeluaran;
                    } else if ($shuttle == "shuttle4") {

                        $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
							 from mkk_" . $shuttle . "_pengeluaran A
							 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi);
                        $results[$ncount]->jumlahpengeluaran[$bi] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                        $results[$ncount]->jumlahpengeluaran[13] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                        $results[$ncount]->jumlahpengeluaran['mr'][$bi] += $sql2[0]->jumlahmr;
                        $results[$ncount]->jumlahpengeluaran['wbp'][$bi] += $sql2[0]->jumlahwbp;
                        $results[$ncount]->jumlahpengeluaran['mr'][13] += $sql2[0]->jumlahmr;
                        $results[$ncount]->jumlahpengeluaran['wbp'][13] += $sql2[0]->jumlahwbp;

                        $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_veniermuka2) as jumlahmuka, sum(A.rekod_venierteras2) as jumlahteras
							 from mkk_" . $shuttle . "_pengeluaran A
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi);
                        $results[$ncount]->jumlahpengeluaran['muka'][$bi] += $sql2[0]->jumlahmuka;
                        $results[$ncount]->jumlahpengeluaran['teras'][$bi] += $sql2[0]->jumlahteras;
                        $results[$ncount]->jumlahpengeluaran['venier'][$bi] += $sql2[0]->jumlahmuka + $sql2[0]->jumlahteras;
                        $results[$ncount]->jumlahpengeluaran['muka'][13] += $sql2[0]->jumlahmuka;
                        $results[$ncount]->jumlahpengeluaran['teras'][13] += $sql2[0]->jumlahteras;
                        $results[$ncount]->jumlahpengeluaran['venier'][13] += $sql2[0]->jumlahmuka + $sql2[0]->jumlahteras;
                    }
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '131')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '131',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '131')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            // if ($title == '231') {
            //     $laporan = Laporan::where('laporan_num', '231')->where('tahun', $tahun)->first();
            //     $title_laporan = "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan";
            // } elseif ($title == '233') {
            //     $laporan = Laporan::where('laporan_num', '233')->where('tahun', $tahun)->first();
            //     $title_laporan = "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri dan Bulan Mengikut Jenis";
            // } elseif ($title == '236') {
            //     $laporan = Laporan::where('laporan_num', '236')->where('tahun', $tahun)->first();
            //     $title_laporan = "36. Pengeluaran Venir Mengikut Negeri Dan Bulan";
            // } elseif ($title == '238') {
            //     $laporan = Laporan::where('laporan_num', '238')->where('tahun', $tahun)->first();
            //     $title_laporan = "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis";
            // }
            $checkLaporan = Laporan::where('laporan_num', '231')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '231',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '231')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '331')->where('tahun', $tahun)->count();
            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '331',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '331')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }



        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 132, 232/237, 332
	******************************************************************************** */

    function getreport_pengeluaran_bynegeri_bytahun($shuttle, $tahunmula, $tahunakhir, $title)
    {
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '132')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '232')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
            if ($title == '232') {
                $title_laporan = "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";
            } else {
                $title_laporan = "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";
            }
        } else {
            $laporan = Laporan::where('laporan_num', '332')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";
        }

        if (!$laporan) {
        $results = $this->getreport_pengeluaran_bynegeri_bytahun_process($shuttle, $tahunmula, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahunmula; $gi <= $tahunjumlah; $gi++) {
            $grandtotal->jumlahpengeluaran[$gi] = 0;
            $grandtotal->jumlahpengeluaran['mr'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['wbp'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['muka'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['teras'][$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = $tahunmula; $gi <= $tahunakhir; $gi++) {
                $grandtotal->jumlahpengeluaran[$gi] += $result->jumlahpengeluaran->$gi;
                $grandtotal->jumlahpengeluaran['mr'][$gi] += (float)$result->jumlahpengeluaran->mr->$gi;
                $grandtotal->jumlahpengeluaran['wbp'][$gi] += (float)$result->jumlahpengeluaran->wbp->$gi;
                $grandtotal->jumlahpengeluaran['muka'][$gi] += (float)$result->jumlahpengeluaran->muka->$gi;
                $grandtotal->jumlahpengeluaran['teras'][$gi] += (float)$result->jumlahpengeluaran->teras->$gi;
                $grandtotal->jumlahpengeluaran[$tahunjumlah] += $result->jumlahpengeluaran->$gi;
                $grandtotal->jumlahpengeluaran['mr'][$tahunjumlah] += (float)$result->jumlahpengeluaran->mr->$gi;
                $grandtotal->jumlahpengeluaran['wbp'][$tahunjumlah] += (float)$result->jumlahpengeluaran->wbp->$gi;
                $grandtotal->jumlahpengeluaran['muka'][$tahunjumlah] += (float)$result->jumlahpengeluaran->muka->$gi;
                $grandtotal->jumlahpengeluaran['teras'][$tahunjumlah] += (float)$result->jumlahpengeluaran->teras->$gi;
            }
        }

        if ($shuttle == 'shuttle4') {
            $columns = [
                'Bil',
                'Negeri/Tahun',
                'Jenis'
            ];
        } else {
            $columns = [
                'Bil',
                'Negeri/Tahun',
            ];
        }

        for ($gi = $tahunmula; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($results);

        if ($shuttle == 'shuttle4') {
            return view('admins.laporan-data-lama.232', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahunmula',
                'tahunakhir',
            ));
        } else {
            return view('admins.laporan-data-lama.132', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahunmula',
                'tahunakhir',
            ));
        }
    }

    function getreport_pengeluaran_bynegeri_bytahun_process($shuttle, $tahunmula, $tahunakhir, $title)
    {

        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $negeris = $this->getnegeri();
        $ncount = -1;
        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[
                'jumlahpengeluaran' => []
            ];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = $tahunmula; $bi <= $tahunjumlah; $bi++) {
                $results[$ncount]->jumlahpengeluaran[$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['mr'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['wbp'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['muka'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['teras'][$bi] = 0;
            }

            for ($bi = $tahunmula; $bi <= $tahunakhir; $bi++) {
                if ($bi < 2021) {

                    $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
					mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
					mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
					mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
					pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
					from mkk_" . $shuttle . "_index I
					inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
					inner join negeri on A.rekod_negeri_id = negeri.negeri_id
					inner join daerah on A.rekod_daerah_id = daerah.daerah_id
					inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
					inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
					left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
					inner join negara on A.rekod_negara_id = negara.negara_id
					inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
					inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
					where A.rekod_tahun = " . $bi . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                    foreach ($records as $myrecord) {

                        if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {

                            $sql2 = DB::connection('mysql2')->select("Select sum(B.bahan_proseskeluar2) as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
                            inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
                            where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi);

                            $results[$ncount]->jumlahpengeluaran[$bi] += $sql2[0]->jumlahpengeluaran;
                            $results[$ncount]->jumlahpengeluaran[$tahunjumlah] += $sql2[0]->jumlahpengeluaran;
                        } else if ($shuttle == "shuttle4") {

                            $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
							 from mkk_" . $shuttle . "_pengeluaran A
							 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi);

                            $results[$ncount]->jumlahpengeluaran['mr'][$bi] += $sql2[0]->jumlahmr;
                            $results[$ncount]->jumlahpengeluaran['wbp'][$bi] += $sql2[0]->jumlahwbp;
                            $results[$ncount]->jumlahpengeluaran['mr'][$tahunjumlah] += $sql2[0]->jumlahmr;
                            $results[$ncount]->jumlahpengeluaran['wbp'][$tahunjumlah] += $sql2[0]->jumlahwbp;

                            $sql2 = DB::connection('mysql2')->select("Select sum(A.rekod_veniermuka2) as jumlahmuka, sum(A.rekod_venierteras2) as jumlahteras
							 from mkk_" . $shuttle . "_pengeluaran A
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi);

                            $results[$ncount]->jumlahpengeluaran['muka'][$bi] += $sql2[0]->jumlahmuka;
                            $results[$ncount]->jumlahpengeluaran['teras'][$bi] += $sql2[0]->jumlahteras;
                            $results[$ncount]->jumlahpengeluaran['muka'][$tahunjumlah] += $sql2[0]->jumlahmuka;
                            $results[$ncount]->jumlahpengeluaran['teras'][$tahunjumlah] += $sql2[0]->jumlahteras;
                        }
                    }
                } else { // in progress 11/5/2022
                    if (($shuttle == "shuttle3") || ($shuttle == "shuttle5")) {
                        if ($shuttle == "shuttle3") {
                            $shuttle_id = '3';
                        } elseif ($shuttle == "shuttle5") {
                            $shuttle_id = '5';
                        }
                        $datas = DB::select("SELECT shuttles.negeri_id as negeri,
                        sum(round(kemasukan_bahans.proses_keluar)) as jumlah_pengeluaran


                        FROM
                        shuttles,
                        form_c_s,
                        kemasukan_bahans

                        WHERE form_c_s.shuttle_id = shuttles.id
                        AND form_c_s.id = kemasukan_bahans.formcs_id

                        AND shuttles.negeri_id = '$mynegeri->negeri_keterangan'
                        AND shuttles.shuttle_type = '$shuttle_id'
                        AND form_c_s.status = 'Lulus'
                        AND form_c_s.tahun = '$bi'

                        GROUP BY
                        shuttles.negeri_id;
                        ");

                        foreach ($datas as $key => $value) {
                            $results[$ncount]->jumlahpengeluaran[$bi] += $value->jumlah_pengeluaran;
                            $results[$ncount]->jumlahpengeluaran[$tahunjumlah] += $value->jumlah_pengeluaran;
                        }
                    } else if ($shuttle == "shuttle4") {

                        $datas = DB::select("SELECT shuttles.negeri_id as negeri,
                        sum(distinct produk_pengeluarans.jumlah_besar_mr) as jumlah_besar_mr,
                        sum(distinct produk_pengeluarans.jumlah_besar_wbp) as jumlah_besar_wbp

                        FROM
                        shuttles,
                        form4_d_s,
                        produk_pengeluarans

                        WHERE form4_d_s.shuttle_id = shuttles.id
                        AND form4_d_s.id = produk_pengeluarans.form4ds_id

                        AND shuttles.negeri_id = '$mynegeri->negeri_keterangan'
                        AND shuttles.shuttle_type = '4'
                        AND form4_d_s.status = 'Lulus'
                        AND form4_d_s.tahun = '$bi'

                    GROUP BY
                    shuttles.negeri_id;
                        ");
                        foreach ($datas as $key => $value) {
                            $results[$ncount]->jumlahpengeluaran['mr'][$bi] += $value->jumlah_besar_mr;
                            $results[$ncount]->jumlahpengeluaran['wbp'][$bi] += $value->jumlah_besar_wbp;
                            $results[$ncount]->jumlahpengeluaran['mr'][$tahunjumlah] += $value->jumlah_besar_mr;
                            $results[$ncount]->jumlahpengeluaran['wbp'][$tahunjumlah] += $value->jumlah_besar_wbp;
                        }
                    }
                }
            }
        }

        // dd($results);

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '132')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '132',
                    'tahun' => $tahunmula,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '132')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '232')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '232',
                    'tahun' => $tahunmula,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '232')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '332')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '332',
                    'tahun' => $tahunmula,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '332')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 133 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bynegeri($shuttle, $tahun, $title)
    {
        $laporan = Laporan::where('laporan_num', '133')->where('tahun', $tahun)->first();

        if (!$laporan) {
            $results = $this->getreport_pengeluaran_bykumpulankayu_bynegeri_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        // dd($results);

        $negeri_list = Daerah::distinct()->get('negeri');

        $kumpulan_kayu = KumpulanKayu::get();

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

        return view('admins.laporan-data-lama.133', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'results',
            'tahun',
            'shuttle',
        ));
    }

    function getreport_pengeluaran_bykumpulankayu_bynegeri_process($shuttle, $tahun, $title)
    {
        $tempnegeris = $this->getnegeri();

        $ssms = "";
        $nid = -1;
        foreach ($tempnegeris as $mytempnegeri) {
            $nid++;
            $negeris[$nid] = (object)[];

            $negeris[$nid] = $mytempnegeri;
            $negeris[$nid]->ssms = "";

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mytempnegeri->negeri_id);

            foreach ($records as $myrecord) {
                $ssmstate[$myrecord->rekod_nossm] = (object)[];

                $negeris[$nid]->ssms .= ",'" . $myrecord->rekod_nossm . "'";

                $ssms .= ",'" . $myrecord->rekod_nossm . "'";
                $ssmstate[$myrecord->rekod_nossm] = $nid;
            }
            if ($negeris[$nid]->ssms != "") {
                $negeris[$nid]->ssms = substr($negeris[$nid]->ssms, 1);
            } else {
                $negeris[$nid]->ssms = "''";
            }
        }
        // june 2021
        if ($ssms != "") {
            $ssms = substr($ssms, 1);
        } else {
            $ssms = "''";
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;
            $results[$scount]->jumlahkeseluruhan = 0;

            $ncount = -1;
            foreach ($negeris as $mynegeri) {
                $ncount++;
                $results[$scount]->jumlahpengeluaran[$ncount] = 0;
            }

            $subrecords = DB::connection('mysql2')->select("Select B.bahan_proseskeluar2 as jumlahpengeluaran, A.rekod_nossm as rekod_nossm from mkk_" . $shuttle . "_kemasukan A
				 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
				 where A.rekod_nossm in (" . $ssms . ") and A.rekod_tahun = " . $tahun . "
				 and B.bahan_spesies_id = " . $myspesies->spesies_id);

            foreach ($subrecords as $subrec) {

                $stateindex = $ssmstate[$subrec->rekod_nossm] ?? 0;
                $results[$scount]->jumlahpengeluaran[$stateindex] += $subrec->jumlahpengeluaran;
                $results[$scount]->jumlahkeseluruhan += $subrec->jumlahpengeluaran;
            }
        }
        $checkLaporan = Laporan::where('laporan_num', '133')->where('tahun', $tahun)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '133',
                'tahun' => $tahun,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '133')->where('tahun', $tahun)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 134 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bybulan($shuttle, $tahun, $title)
    {
        $laporan = Laporan::where('laporan_num', '134')->where('tahun', $tahun)->first();

        if (!$laporan) {
            $results = $this->getreport_pengeluaran_bykumpulankayu_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $negeri_list = Daerah::distinct()->get('negeri');

        $kumpulan_kayu = KumpulanKayu::get();

        $title_laporan = "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan";

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

        // dd($results);

        return view('admins.laporan-data-lama.134', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'results',
            'tahun',
            'shuttle',
        ));
    }

    function getreport_pengeluaran_bykumpulankayu_bybulan_process($shuttle, $tahun, $title)
    {
        $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun);

        foreach ($records as $myrecord) {
            // $ssms[] = $myrecord['rekod_nossm'];
            $ssms[$myrecord->rekod_nossm] = (object)[];
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;
            $results[$scount]->jumlahkeseluruhan = 0;

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$scount]->jumlahpengeluaran[$bi] = 0;
            }

            $subrecords = DB::connection('mysql2')->select("Select A.rekod_bulan, B.bahan_proseskeluar2 as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
				 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
				 where A.rekod_tahun = " . $tahun . "
				 and B.bahan_spesies_id = " . $myspesies->spesies_id . "
                                 order by A.rekod_bulan ASC");

            foreach ($subrecords as $subrec) {
                $bindex = intval($subrec->rekod_bulan);
                $results[$scount]->jumlahpengeluaran[$bindex] += $subrec->jumlahpengeluaran;
                $results[$scount]->jumlahpengeluaran[13] += $subrec->jumlahpengeluaran;
                $results[$scount]->jumlahkeseluruhan += $subrec->jumlahpengeluaran;
            }
        }

        $checkLaporan = Laporan::where('laporan_num', '134')->where('tahun', $tahun)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '134',
                'tahun' => $tahun,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '134')->where('tahun', $tahun)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 135 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bytahun($shuttle, $tahun, $tahunakhir, $title)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $laporan = Laporan::where('laporan_num', '135')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();

        if (!$laporan) {
        $results = $this->getreport_pengeluaran_bykumpulankayu_bytahun_process($shuttle, $tahun, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $negeri_list = Daerah::distinct()->get('negeri');

        $kumpulan_kayu = KumpulanKayu::get();

        $title_laporan = "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
        ];

        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

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

        // dd($results);

        return view('admins.laporan-data-lama.135', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'negeri_list',
            'kumpulan_kayu',
            'results',
            'tahun',
            'tahunakhir',
            'shuttle',
        ));
    }

    function getreport_pengeluaran_bykumpulankayu_bytahun_process($shuttle, $tahunmula, $tahunakhir, $title)
    {

        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        // june 2021 - compile full ssm list as well
        $ssmfull = "";
        $tahuns = "";
        for ($ti = $tahunmula; $ti <= $tahunakhir; $ti++) {
            if ($ti < 2021) {
                $tahuns .= "," . $ti;
            }
        }
        if ($tahuns != "") {
            $tahuns = substr($tahuns, 1);
        } else {
            $tahuns = "''";
        }
        // dd($tahuns);
        // 17/1/2017 - compile company ssms according to tahun first (instead of in species loop)
        $ssms = array();
        for ($bi = $tahunmula; $bi <= $tahunakhir; $bi++) {
            $ssms[$bi] = "";
            if ($bi < 2021) {
                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
                    mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
                    mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
                    mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
                    pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
                    from mkk_" . $shuttle . "_index I
                    inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
                    inner join negeri on A.rekod_negeri_id = negeri.negeri_id
                    inner join daerah on A.rekod_daerah_id = daerah.daerah_id
                    inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
                    inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
                    left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
                    inner join negara on A.rekod_negara_id = negara.negara_id
                    inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
                    inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
                    where A.rekod_tahun = " . $bi);

                foreach ($records as $myrecord) {
                    $ssms[$bi] .= ",'" . $myrecord->rekod_nossm . "'";
                    // june 2021
                    $ssmfull .= ",'" . $myrecord->rekod_nossm . "'";
                }
                if ($ssms[$bi] != "") {
                    $ssms[$bi] = substr($ssms[$bi], 1);
                } else {
                    $ssms[$bi] = "''";
                }
            }
        }
        // june 2021
        if ($ssmfull != "") {
            $ssmfull = substr($ssmfull, 1);
        } else {
            $ssmfull = "''";
        }

        $spesies = $this->getactivespesies();
        $scount = -1;

        foreach ($spesies as $myspesies) {
            $scount++;
            $results[$scount] = (object)[];

            $results[$scount]->spesies_kumpulankayu = $myspesies->spesies_kumpulankayu;
            $results[$scount]->spesies_namatempatan = $myspesies->spesies_namatempatan;
            $results[$scount]->spesies_namasaintifik = $myspesies->spesies_namasaintifik;
            $results[$scount]->jumlahkeseluruhan[$tahunjumlah] = 0;

            for ($bi = $tahunmula; $bi < $tahunjumlah; $bi++) {
                $results[$scount]->jumlahpengeluaran[$bi] = 0;
            }
            $subrecords = DB::connection('mysql2')->select("Select A.rekod_tahun, B.bahan_proseskeluar2 as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
                inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
                where A.rekod_nossm in (" . $ssmfull . ") and A.rekod_tahun in (" . $tahuns . ")
                and B.bahan_spesies_id = " . $myspesies->spesies_id);

            foreach ($subrecords as $subrec) {
                $stateindex = intval($subrec->rekod_tahun);
                $results[$scount]->jumlahpengeluaran[$stateindex] += $subrec->jumlahpengeluaran;
                $results[$scount]->jumlahkeseluruhan[$tahunjumlah] += $subrec->jumlahpengeluaran;
            }

            for ($i = 2021; $i < $tahunjumlah; $i++) {
                $spesis = Spesis::where('nama_saintifik', $myspesies->spesies_namasaintifik)->first();
                // $kumpulan_kayu = KumpulanKayu::where('singkatan', $myspesies->spesies_kumpulankayu)->first();
                if ($spesis) {
                    $data = DB::select("SELECT
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
                    AND kumpulan_kayus.singkatan = '$myspesies->spesies_kumpulankayu'
                    AND spesis.nama_tempatan = '$spesis->nama_tempatan'
                    AND kemasukan_bahans.tahun = '$i'

                    GROUP BY
                    form_c_s.tahun
                    ;");

                    $results[$scount]->jumlahpengeluaran[$i] += $data[0]->jumlah_pengeluaran ?? 0;
                    $results[$scount]->jumlahkeseluruhan[$tahunjumlah] += $data[0]->jumlah_pengeluaran ?? 0;
                } else {
                    $results[$scount]->jumlahpengeluaran[$i] += 0;
                    $results[$scount]->jumlahkeseluruhan[$tahunjumlah] += 0;
                }
            }
        }
        // dd($spesis);
        $checkLaporan = Laporan::where('laporan_num', '135')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '135',
                'tahun' => $tahunmula,
                'tahun_akhir' => $tahunakhir,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '135')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 136 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaranspesies_bynegeri_bybulan($shuttle, $tahun, $spesies, $title)
    {
        $laporan = Laporan::where('laporan_num', '136')->where('tahun', $tahun)->where('spesis', $spesies)->first();

        if (!$laporan) {
            $results = $this->getreport_pengeluaranspesies_bynegeri_bybulan_process($shuttle, $tahun, $spesies, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jumlahpengeluaran[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                $grandtotal->jumlahpengeluaran[$gi] += $result->jumlahpengeluaran->$gi;
            }
        }

        $spesis_name = $this->getspesies_byid($spesies);
        if (!$spesis_name) {
            return redirect()->back()->with('error', 'Sila Pilih Spesis yang betul');
        }

        $title = "36. Pengeluaran Kayu Gergaji Daripada Spesies " . ucwords($spesis_name[0]->spesies_namatempatan) . " Oleh Kilang Papan Mengikut Negeri Dan Bulan";
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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.136', compact(
            'title',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
            'spesies',
            'tahun',
        ));
    }

    function getreport_pengeluaranspesies_bynegeri_bybulan_process($shuttle, $tahun, $spesies, $title)
    {
        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {
            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jumlahpengeluaran[$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    $subrecord = DB::connection('mysql2')->select("Select sum(B.bahan_proseskeluar2) as jumlahpengeluaran from mkk_" . $shuttle . "_kemasukan A
						 inner join mkk_" . $shuttle . "_kemasukan_bahan B on A.rekod_id = B.bahan_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi . "
						 and B.bahan_spesies_id = " . $spesies);

                    $results[$ncount]->jumlahpengeluaran[$bi] += $subrecord[0]->jumlahpengeluaran;
                    $results[$ncount]->jumlahpengeluaran[13] += $subrecord[0]->jumlahpengeluaran;
                }
            }
        }

        $checkLaporan = Laporan::where('laporan_num', '136')->where('tahun', $tahun)->where('spesis', $spesies)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '136',
                'tahun' => $tahun,
                'spesis' => $spesies,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '136')->where('tahun', $tahun)->where('spesis', $spesies)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 234 - shuttle 4 only
	******************************************************************************** */
    function getreport_pengeluarantebal_bynegeri_bytahun($shuttle, $tahunmula, $tahunakhir, $title)
    {
        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $laporan = Laporan::where('laporan_num', '234')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();

        if (!$laporan) {
            $results = $this->getreport_pengeluarantebal_bynegeri_bytahun_process($shuttle, $tahunmula, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $title_laporan = "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa";

        $columns = [
            'Bil',
            'Negeri/Tahun',
            'Ketebalan'
        ];

        for ($gi = $tahunmula; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

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

        // dd($results);
        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahunmula; $gi <= $tahunjumlah; $gi++) {
            $grandtotal->jumlahpengeluaran['nipis'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['tebal'][$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = $tahunmula; $gi <= $tahunjumlah; $gi++) {
                $grandtotal->jumlahpengeluaran['nipis'][$gi] += (float)$result->jumlahpengeluaran->nipis->$gi;
                $grandtotal->jumlahpengeluaran['tebal'][$gi] += (float)$result->jumlahpengeluaran->tebal->$gi;
            }
        }
        // dd($grandtotal);
        return view('admins.laporan-data-lama.234', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'results',
            'tahunmula',
            'tahunakhir',
            'grandtotal',
            'shuttle',
        ));
    }

    function getreport_pengeluarantebal_bynegeri_bytahun_process($shuttle, $tahunmula, $tahunakhir)
    {
        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {
            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = $tahunmula; $bi <= $tahunjumlah; $bi++) {
                $results[$ncount]->jumlahpengeluaran['nipis'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['tebal'][$bi] = 0;
            }

            for ($bi = $tahunmula; $bi <= $tahunakhir; $bi++) {
                if ($bi < 2021) {

                    $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
					mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
					mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
					mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
					pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
					from mkk_" . $shuttle . "_index I
					inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
					inner join negeri on A.rekod_negeri_id = negeri.negeri_id
					inner join daerah on A.rekod_daerah_id = daerah.daerah_id
					inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
					inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
					left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
					inner join negara on A.rekod_negara_id = negara.negara_id
					inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
					inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
					where A.rekod_tahun = " . $bi . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                    foreach ($records as $myrecord) {

                        $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
						 from mkk_" . $shuttle . "_pengeluaran A
						 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi . "
						 and B.produk_kategori = 0");

                        $results[$ncount]->jumlahpengeluaran['nipis'][$bi] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                        $results[$ncount]->jumlahpengeluaran['nipis'][$tahunjumlah] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;

                        $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
						 from mkk_" . $shuttle . "_pengeluaran A
						 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi . "
						 and B.produk_kategori = 1");

                        $results[$ncount]->jumlahpengeluaran['tebal'][$bi] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                        $results[$ncount]->jumlahpengeluaran['tebal'][$tahunjumlah] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                    }
                } else { //in progress 21/4/2022

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

                    AND shuttles.negeri_id = '$mynegeri->negeri_keterangan'
                    AND shuttles.shuttle_type = '4'
                    AND form4_d_s.status = 'Lulus'
                    AND form4_d_s.tahun = '$bi'

                    GROUP BY
                    shuttles.negeri_id;
                ");

                    foreach ($data as $value) {
                        $results[$ncount]->jumlahpengeluaran['nipis'][$bi] += $value->jumlah_kecil_1_mr + $value->jumlah_kecil_1_wbp;
                        $results[$ncount]->jumlahpengeluaran['nipis'][$tahunjumlah] += $value->jumlah_kecil_1_mr + $value->jumlah_kecil_1_wbp;
                        $results[$ncount]->jumlahpengeluaran['tebal'][$bi] += $value->jumlah_kecil_2_mr + $value->jumlah_kecil_2_wbp;
                        $results[$ncount]->jumlahpengeluaran['tebal'][$tahunjumlah] += $value->jumlah_kecil_2_mr + $value->jumlah_kecil_2_wbp;
                    }
                }
            }
        }
        $checkLaporan = Laporan::where('laporan_num', '234')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '234',
                'tahun' => $tahunmula,
                'tahun_akhir' => $tahunakhir,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '234')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        return json_decode($laporan->data_laporan);
    }


    /* ********************************************************************************
	Report 235 - shuttle 4 only
	******************************************************************************** */

    function getreport_pengeluarantebal_bynegeri_bybulan($shuttle, $tahun, $title)
    {
        $laporan = Laporan::where('laporan_num', '235')->where('tahun', $tahun)->first();

        if (!$laporan) {
            $results = $this->getreport_pengeluarantebal_bynegeri_bybulan_process($shuttle, $tahun);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jumlahpengeluaran['nipis'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['tebal'][$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                $grandtotal->jumlahpengeluaran['nipis'][$gi] += (float)$result->jumlahpengeluaran->nipis->$gi;
                $grandtotal->jumlahpengeluaran['tebal'][$gi] += (float)$result->jumlahpengeluaran->tebal->$gi;
            }
        }

        $title_laporan = "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan";

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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.235', compact(
            'title',
            'title_laporan',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
            'tahun',
        ));
    }

    function getreport_pengeluarantebal_bynegeri_bybulan_process($shuttle, $tahun)
    {
        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jumlahpengeluaran['nipis'][$bi] = 0;
                $results[$ncount]->jumlahpengeluaran['tebal'][$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
						 from mkk_" . $shuttle . "_pengeluaran A
						 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi . "
						 and B.produk_kategori = 0");

                    $results[$ncount]->jumlahpengeluaran['nipis'][$bi] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                    $results[$ncount]->jumlahpengeluaran['nipis'][13] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;

                    $sql2 = DB::connection('mysql2')->select("Select sum(B.produk_isipadumr2) as jumlahmr, sum(B.produk_isipaduwbp2) as jumlahwbp
						 from mkk_" . $shuttle . "_pengeluaran A
						 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi . "
						 and B.produk_kategori = 1");

                    $results[$ncount]->jumlahpengeluaran['tebal'][$bi] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                    $results[$ncount]->jumlahpengeluaran['tebal'][13] += $sql2[0]->jumlahmr + $sql2[0]->jumlahwbp;
                }
            }
        }
        $checkLaporan = Laporan::where('laporan_num', '235')->where('tahun', $tahun)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '235',
                'tahun' => $tahun,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '235')->where('tahun', $tahun)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 333 - shuttle 5 only
	******************************************************************************** */
    function getreport_pengeluaran_byproduk_bybulan($shuttle, $tahun, $title)
    {
        $laporan = Laporan::where('laporan_num', '333')->where('tahun', $tahun)->first();
        $title_laporan = "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan";

        if (!$laporan) {
            $results = $this->getreport_pengeluaran_byproduk_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }
        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jumlahpengeluaran[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                $grandtotal->jumlahpengeluaran[$gi] += $result->jumlahpengeluaran->$gi;
            }
        }

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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.333', compact(
            'title',
            'title_laporan',
            'tahun',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
        ));
    }

    function getreport_pengeluaran_byproduk_bybulan_process($shuttle, $tahun, $title)
    {
        $jeniskumais = $this->getjeniskumai1();
        $ncount = -1;

        foreach ($jeniskumais as $myjenis) {

            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->kod_keterangan = $myjenis->kod_keterangan;
            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jumlahpengeluaran[$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun);

            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    $subrecord = DB::connection('mysql2')->select("Select sum(B.produk_isipadu2) as jumlahpengeluaran from mkk_" . $shuttle . "_pengeluaran A
						 inner join mkk_" . $shuttle . "_pengeluaran_produk B on A.rekod_id = B.produk_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi . "
						 and B.produk_jeniskumai1_id = " . $myjenis->kod_id);

                    $results[$ncount]->jumlahpengeluaran[$bi] += $subrecord[0]->jumlahpengeluaran;
                    $results[$ncount]->jumlahpengeluaran[13] += $subrecord[0]->jumlahpengeluaran;
                }
            }
        }

        $checkLaporan = Laporan::where('laporan_num', '333')->where('tahun', $tahun)->count();

        if ($checkLaporan == 0) {
            $laporan = Laporan::create([ //create laporan data
                'laporan_num' => '333',
                'tahun' => $tahun,
                'shuttle_type' => $shuttle,
                'data_laporan' => json_encode($results) ?? '',
            ]);
        } else {
            $laporan = Laporan::where('laporan_num', '333')->where('tahun', $tahun)->first();
            $laporan->data_laporan = json_encode($results) ?? '';
            $laporan->save();
        }

        // dd($results);
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 141/147, 241/248, 341/344 //report 41 & 47
	******************************************************************************** */

    function getreport_jualan_bybulan($shuttle, $tahun, $title)
    {
        // dd($title);
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '141')->where('tahun', $tahun)->first();
            if ($title == "41") {
                $title_laporan = "41. Jualan Domestik Kayu Gergaji Mengikut Bulan";
            } else {
                $title_laporan = "47. Jualan Eksport Kayu Gergaji Mengikut Bulan";
            }
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '241')->where('tahun', $tahun)->first();
            if ($title == '241') {
                $title_laporan = "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan";
            } else {
                $title_laporan = "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan";
            }
        } else {

            if ($title == '341') {
                $laporan = Laporan::where('laporan_num', '341')->where('tahun', $tahun)->first();
                $title_laporan = "41. Jualan Domestik Kayu Kumai Mengikut Bulan";
            } else if ($title == '344') {
                $laporan = Laporan::where('laporan_num', '341')->where('tahun', $tahun)->first();
                $title_laporan = "44. Jualan Eksport Kayu Kumai Mengikut Bulan";
            }
        }

        if (!$laporan) {
            $results = $this->getreport_jualan_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        if ($shuttle == 'shuttle4') {
            $columns = [
                'Bil',
                'Bulan',
                'Papan Lapis (m³)',
                'Venir (m³)'
            ];

            $grandtotal = (object)[
                'jualantempatan' => [],
                'jualaneksport' => [],
            ];

            $grandtotal->jualantempatan['papanlapis'] = 0;
            $grandtotal->jualaneksport['papanlapis'] = 0;

            $grandtotal->jualantempatan['venier'] = 0;
            $grandtotal->jualaneksport['venier'] = 0;

            foreach ($results as $result) {
                $grandtotal->jualantempatan['papanlapis'] += $result->papanlapis->jualantempatan;
                $grandtotal->jualaneksport['papanlapis'] += $result->papanlapis->jualaneksport;

                $grandtotal->jualantempatan['venier'] += $result->venier->jualantempatan;
                $grandtotal->jualaneksport['venier'] += $result->venier->jualaneksport;
            }
        } else if ($shuttle == 'shuttle5') {
            $columns = [
                'Bil',
                'Bulan',
                'Kayu Kumai (m³)',
                // 'Papan Lapis (m³)',
                // 'Venir (m³)'
            ];

            $grandtotal = (object)[
                'jualantempatan' => [],
                'jualaneksport' => [],
            ];

            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jualantempatan[$gi] = 0;
                $grandtotal->jualaneksport[$gi] = 0;
            }

            foreach ($results as $result) {
                for ($gi = 1; $gi <= 12; $gi++) {
                    $grandtotal->jualantempatan[$gi] += $result->kayukumai->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->kayukumai->jualaneksport;
                }
            }
        } else {
            $columns = [
                'Bil',
                'Bulan',
                'Kayu Gergaji (m³)',
            ];


            $grandtotal = (object)[
                'jualantempatan' => [],
                'jualaneksport' => [],
            ];

            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jualantempatan[$gi] = 0;
                $grandtotal->jualaneksport[$gi] = 0;
            }

            foreach ($results as $result) {
                for ($gi = 1; $gi <= 12; $gi++) {
                    $grandtotal->jualantempatan[$gi] += $result->kayugergaji->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->kayugergaji->jualaneksport;
                }
            }
        }

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($grandtotal);

        if ($title == "41" || $title == "241" || $title == "341") {
            return view('admins.laporan-data-lama.141', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahun'
            ));
        } else {
            return view('admins.laporan-data-lama.147', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahun'
            ));
        }
    }

    function getreport_jualan_bybulan_process($shuttle, $tahun, $title)
    {
        $montharray = array(1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember', 13 => 'Jumlah');

        for ($bi = 1; $bi <= 12; $bi++) {
            $results[$bi] = (object)[];

            $results[$bi]->kayugergaji['bulan'] = $montharray[$bi];
            $results[$bi]->kayugergaji['jualantempatan'] = 0;
            $results[$bi]->kayugergaji['jualaneksport'] = 0;

            $results[$bi]->papanlapis['bulan'] = $montharray[$bi];
            $results[$bi]->papanlapis['jualantempatan'] = 0;
            $results[$bi]->papanlapis['jualaneksport'] = 0;

            $results[$bi]->venier['bulan'] = $montharray[$bi];
            $results[$bi]->venier['jualantempatan'] = 0;
            $results[$bi]->venier['jualaneksport'] = 0;

            $results[$bi]->kayukumai['bulan'] = $montharray[$bi];
            $results[$bi]->kayukumai['jualantempatan'] = 0;
            $results[$bi]->kayukumai['jualaneksport'] = 0;
        }

        $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
			mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
			mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
			mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
			pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
			from mkk_" . $shuttle . "_index I
			inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
			inner join negeri on A.rekod_negeri_id = negeri.negeri_id
			inner join daerah on A.rekod_daerah_id = daerah.daerah_id
			inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
			inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
			left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
			inner join negara on A.rekod_negara_id = negara.negara_id
			inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
			inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
			where A.rekod_tahun = " . $tahun);

        foreach ($records as $myrecord) {

            for ($bi = 1; $bi <= 12; $bi++) {

                if ($shuttle == "shuttle3") {

                    if ($bi < 2021) {
                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
						 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                        $results[$bi]->kayugergaji['jualantempatan'] += $subrecord[0]->jualantempatan;

                        $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport from mkk_" . $shuttle . "_penjualan A
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                        $results[$bi]->kayugergaji['jualaneksport'] += $subrecord[0]->jualaneksport;
                    }
                } else if ($shuttle == "shuttle4") {

                    $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
						 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                    $results[$bi]->papanlapis['jualantempatan'] += $subrecord[0]->jualantempatan;

                    $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport,
						 sum(A.rekod_veniereksport2) as veniereksport, sum(A.rekod_veniertempatan2) as veniertempatan
						 from mkk_" . $shuttle . "_penjualan A
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                    $results[$bi]->papanlapis['jualaneksport'] += $subrecord[0]->jualaneksport;

                    $results[$bi]->venier['jualaneksport'] += $subrecord[0]->veniereksport;

                    $results[$bi]->venier['jualantempatan'] += $subrecord[0]->veniertempatan;
                } else if ($shuttle == "shuttle5") {

                    // TODO: check with user if we need to use pengeluaran table for shuttle 5

                    $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport,
						 sum(A.rekod_jumlahtempatan2) as jualantempatan
						 from mkk_" . $shuttle . "_penjualan A
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
						 and A.rekod_bulan = " . $bi);

                    $results[$bi]->kayukumai['jualaneksport'] += $subrecord[0]->jualaneksport;
                    $results[$bi]->kayukumai['jualantempatan'] += $subrecord[0]->jualantempatan;
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '141')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '141',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '141')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '241')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '241',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '241')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '341')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '341',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '341')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 142/148, 242/249, 342/ //report 42 & 48
	******************************************************************************** */

    function getreport_jualan_bynegeri($shuttle, $tahun, $title)
    {

        // dd($shuttle);
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '142')->where('tahun', $tahun)->first();
            if ($title == '42') {
                $title_laporan = "42. Jualan Domestik Kayu Gergaji Mengikut Negeri";
            } else {
                $title_laporan = "48. Jualan Eksport Kayu Gergaji Mengikut Negeri";
            }
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '242')->where('tahun', $tahun)->first();
            if ($title == '242') {
                $title_laporan = "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri";
            } else {
                $title_laporan = "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri";
            }
        } else {
            $laporan = Laporan::where('laporan_num', '342')->where('tahun', $tahun)->first();
            if ($title == '342') {
                $title_laporan = "42. Jualan Domestik Kayu Kumai Mengikut Negeri";
            } else {
                $title_laporan = "45. Jualan Eksport Kayu Kumai Mengikut Negeri";
            }
        }


        if (!$laporan) {
            $results = $this->getreport_jualan_bynegeri_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jualantempatan' => [],
            'jualaneksport' => [],
        ];

        $grandtotal->jualantempatan = 0;
        $grandtotal->jualaneksport = 0;

        foreach ($results as $result) {
            $grandtotal->jualantempatan += $result->kayugergaji->jualantempatan;
            $grandtotal->jualaneksport += $result->kayugergaji->jualaneksport;
        }

        if ($shuttle == 'shuttle4') {
            $columns = [
                'Bil',
                'Negeri',
                'Papan Lapis (m³)',
                'Venir (m³)'
            ];

            $grandtotal = (object)[
                'jualantempatan' => [],
                'jualaneksport' => [],
                'veniertempatan' => []
            ];

            $grandtotal->jualantempatan['papanlapis'] = 0;
            $grandtotal->jualaneksport['papanlapis'] = 0;
            $grandtotal->veniereksport['papanlapis'] = 0;

            $grandtotal->jualantempatan['venier'] = 0;
            $grandtotal->jualaneksport['venier'] = 0;
            $grandtotal->veniertempatan['venier'] = 0;
            $grandtotal->veniereksport['venier'] = 0;

            foreach ($results as $result) {
                $grandtotal->jualantempatan['papanlapis'] += $result->papanlapis->jualantempatan;
                $grandtotal->jualaneksport['papanlapis'] += $result->papanlapis->jualaneksport;
                $grandtotal->veniereksport['papanlapis'] += $result->papanlapis->veniereksport;

                $grandtotal->jualantempatan['venier'] += $result->venier->jualantempatan;
                $grandtotal->jualaneksport['venier'] += $result->venier->jualaneksport;
                $grandtotal->veniertempatan['venier'] += $result->venier->veniertempatan;
                $grandtotal->veniereksport['venier'] += $result->venier->veniereksport;
            }
        } elseif ($shuttle == 'shuttle5') {
            // dd($title);

            if ($title == '342') {


                $title_laporan = "42. Jualan Domestik Kayu Kumai Mengikut Negeri";

                $grandtotal = (object)[
                    'jualantempatan' => [],
                    'jualaneksport' => [],
                ];

                for ($gi = 1; $gi <= 12; $gi++) {
                    $grandtotal->jualantempatan[$gi] = 0;
                    $grandtotal->jualaneksport[$gi] = 0;
                }

                foreach ($results as $result) {
                    for ($gi = 1; $gi <= 12; $gi++) {
                        $grandtotal->jualantempatan[$gi] += $result->kayukumai->jualantempatan;
                    }
                }
                // dd($grandtotal);

            } else {
                $title_laporan = "45. Jualan Eksport Kayu Kumai Mengikut Negeri";

                $grandtotal = (object)[
                    'jualantempatan' => [],
                    'jualaneksport' => [],
                ];

                for ($gi = 1; $gi <= 12; $gi++) {
                    $grandtotal->jualantempatan[$gi] = 0;
                    $grandtotal->jualaneksport[$gi] = 0;
                }

                foreach ($results as $result) {
                    for ($gi = 1; $gi <= 12; $gi++) {
                        $grandtotal->jualaneksport[$gi] += $result->kayukumai->jualaneksport;
                    }
                }
            }


            $columns = [
                'Bil',
                'Negeri',
                'Kayu Kumai (m³)',
            ];
        } else {

            if ($title == '42') {
                $title_laporan = "42. Jualan Domestik Kayu Gergaji Mengikut Negeri";
            } else {
                $title_laporan = "48. Jualan Eksport Kayu Gergaji Mengikut Negeri";
            }


            $columns = [
                'Bil',
                'Negeri',
                'Kayu Gergaji (m³)',
            ];

            $grandtotal = (object)[
                'jualantempatan' => [],
                'jualaneksport' => [],
            ];

            for ($gi = 1; $gi <= 12; $gi++) {
                $grandtotal->jualantempatan[$gi] = 0;
                $grandtotal->jualaneksport[$gi] = 0;
            }

            foreach ($results as $result) {
                for ($gi = 1; $gi <= 12; $gi++) {
                    $grandtotal->jualantempatan[$gi] += $result->kayugergaji->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->kayugergaji->jualaneksport;
                }
            }
        }

        // dd($results);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        if ($title == "42" || $title == "242" || $title == "342") {
            return view('admins.laporan-data-lama.142', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahun',
            ));
        } else {
            return view('admins.laporan-data-lama.148', compact(
                'title',
                'title_laporan',
                'columns',
                'shuttle',
                'returnArr',
                'grandtotal',
                'results',
                'tahun'
            ));
        }
    }

    function getreport_jualan_bynegeri_process($shuttle, $tahun, $title)
    {
        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            $results[$ncount]->kayugergaji['jualantempatan'] = 0;
            $results[$ncount]->kayugergaji['jualaneksport'] = 0;

            $results[$ncount]->papanlapis['jualantempatan'] = 0;
            $results[$ncount]->papanlapis['jualaneksport'] = 0;
            $results[$ncount]->papanlapis['veniereksport'] = 0;

            $results[$ncount]->venier['jualantempatan'] = 0;
            $results[$ncount]->venier['jualaneksport'] = 0;
            $results[$ncount]->venier['veniereksport'] = 0;
            $results[$ncount]->venier['veniertempatan'] = 0;

            $results[$ncount]->kayukumai['jualantempatan'] = 0;
            $results[$ncount]->kayukumai['jualaneksport'] = 0;


            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                if ($shuttle == "shuttle3") {

                    $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
						 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun);
                    $results[$ncount]->kayugergaji['jualantempatan'] += $subrecord[0]->jualantempatan;

                    $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport from mkk_" . $shuttle . "_penjualan A
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun);
                    $results[$ncount]->kayugergaji['jualaneksport'] += $subrecord[0]->jualaneksport;
                } else if ($shuttle == "shuttle4") {

                    $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
						 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun);
                    $results[$ncount]->papanlapis['jualantempatan'] += $subrecord[0]->jualantempatan;

                    $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport,
						 sum(A.rekod_veniereksport2) as veniereksport, sum(A.rekod_veniertempatan2) as veniertempatan
						 from mkk_" . $shuttle . "_penjualan A
						 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun);
                    $results[$ncount]->papanlapis['veniereksport'] += $subrecord[0]->jualaneksport;
                    $results[$ncount]->venier['veniereksport'] += $subrecord[0]->veniereksport;
                    $results[$ncount]->venier['veniertempatan'] += $subrecord[0]->veniertempatan;
                } else if ($shuttle == "shuttle5") {

                    $subrecord =  DB::connection('mysql2')->select("Select sum(A.rekod_jumlahtempatan2) as jualantempatan,
                        sum(A.rekod_jumlaheksport2) as jualaneksport
                        from mkk_" . $shuttle . "_penjualan A
                        where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun);
                    $results[$ncount]->kayukumai['jualaneksport'] += $subrecord[0]->jualaneksport;
                    $results[$ncount]->kayukumai['jualantempatan'] += $subrecord[0]->jualantempatan;
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '142')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '142',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '142')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '242')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '242',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '242')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '342')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '342',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '342')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 143, 243/244, 343
	******************************************************************************** */

    function getreport_jualan_bynegeridanbulan($shuttle, $tahun, $title)
    {
        // dd($title);
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '143')->where('tahun', $tahun)->first();
            if ($title == '43') {
                $title_laporan = "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan";
            } else {
                $title_laporan = "48. Jualan Eksport Kayu Gergaji Mengikut Negeri Dan Bulan";
            }
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '243')->where('tahun', $tahun)->first();
            if ($title == '243') {
                $title_laporan = "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan";
            } else {
                $title_laporan = "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan";
            }
        } else {
            $laporan = Laporan::where('laporan_num', '343')->where('tahun', $tahun)->first();
            $title_laporan = "43. Jualan Domestik Kayu Kumai Mengikut Negeri Dan Bulan";
        }

        if (!$laporan) {
            $results = $this->getreport_jualan_bynegeridanbulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }


        $grandtotal = (object)[
            'jualantempatan' => [],
            'jualaneksport' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jualantempatan[$gi] = 0;
            $grandtotal->jualaneksport[$gi] = 0;
        }
        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                if ($title == '243') {
                    $grandtotal->jualantempatan[$gi] += $result->papanlapis->$gi->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->papanlapis->$gi->jualaneksport;
                } elseif ($title == '244') {
                    $grandtotal->jualantempatan[$gi] += $result->venier->$gi->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->venier->$gi->jualaneksport;
                } elseif ($title == '343') {
                    $grandtotal->jualantempatan[$gi] += $result->kayukumai->$gi->jualantempatan;
                    // $grandtotal->jualaneksport[$gi] += $result->venier->$gi->jualaneksport;
                } else {
                    $grandtotal->jualantempatan[$gi] += $result->kayugergaji->$gi->jualantempatan;
                    $grandtotal->jualaneksport[$gi] += $result->kayugergaji->$gi->jualaneksport;
                }
            }
        }
        // dd($grandtotal);


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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        // dd($title);
        return view('admins.laporan-data-lama.143', compact(
            'title',
            'title_laporan',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
            'tahun',
        ));
    }

    function getreport_jualan_bynegeridanbulan_process($shuttle, $tahun, $title)
    {
        $montharray = array(1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember', 13 => 'Jumlah');

        $negeris = $this->getnegeri();
        $ncount = -1;

        foreach ($negeris as $mynegeri) {

            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->negeri_keterangan = str_replace("Wilayah Persekutuan Kuala Lumpur", "W.P. Kuala Lumpur", $mynegeri->negeri_keterangan);

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->kayugergaji[$bi]['bulan'] = $montharray[$bi];
                $results[$ncount]->kayugergaji[$bi]['jualantempatan'] = 0;
                $results[$ncount]->kayugergaji[$bi]['jualaneksport'] = 0;

                $results[$ncount]->papanlapis[$bi]['bulan'] = $montharray[$bi];
                $results[$ncount]->papanlapis[$bi]['jualantempatan'] = 0;
                $results[$ncount]->papanlapis[$bi]['jualaneksport'] = 0;

                $results[$ncount]->venier[$bi]['bulan'] = $montharray[$bi];
                $results[$ncount]->venier[$bi]['jualantempatan'] = 0;
                $results[$ncount]->venier[$bi]['jualaneksport'] = 0;

                $results[$ncount]->kayukumai[$bi]['bulan'] = $montharray[$bi];
                $results[$ncount]->kayukumai[$bi]['jualantempatan'] = 0;
                $results[$ncount]->kayukumai[$bi]['jualaneksport'] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

            foreach ($records as $myrecord) {

                if ($shuttle == "shuttle3") {

                    for ($bi = 1; $bi <= 12; $bi++) {
                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . " and A.rekod_bulan = " . $bi);

                        $results[$ncount]->kayugergaji[$bi]['jualantempatan'] += $subrecord[0]->jualantempatan;
                        $results[$ncount]->kayugergaji[13]['jualantempatan'] += $subrecord[0]->jualantempatan;

                        $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport from mkk_" . $shuttle . "_penjualan A
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . " and A.rekod_bulan = " . $bi);

                        $results[$ncount]->kayugergaji[$bi]['jualaneksport'] += $subrecord[0]->jualaneksport;
                        $results[$ncount]->kayugergaji[13]['jualaneksport'] += $subrecord[0]->jualaneksport;
                    }
                } else if ($shuttle == "shuttle4") {

                    for ($bi = 1; $bi <= 12; $bi++) {
                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . " and A.rekod_bulan = " . $bi);

                        $results[$ncount]->papanlapis[$bi]['jualantempatan'] += $subrecord[0]->jualantempatan;
                        $results[$ncount]->papanlapis[13]['jualantempatan'] += $subrecord[0]->jualantempatan;

                        $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport,
							 sum(A.rekod_veniereksport2) as veniereksport, sum(A.rekod_veniertempatan2) as veniertempatan
							 from mkk_" . $shuttle . "_penjualan A
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . " and A.rekod_bulan = " . $bi);

                        $results[$ncount]->papanlapis[$bi]['jualaneksport'] += $subrecord[0]->jualaneksport;
                        $results[$ncount]->papanlapis[13]['jualaneksport'] += $subrecord[0]->jualaneksport;
                        $results[$ncount]->venier[$bi]['jualaneksport'] += $subrecord[0]->veniereksport;
                        $results[$ncount]->venier[13]['jualaneksport'] += $subrecord[0]->veniereksport;
                        $results[$ncount]->venier[$bi]['jualantempatan'] += $subrecord[0]->veniertempatan;
                        $results[$ncount]->venier[13]['jualantempatan'] += $subrecord[0]->veniertempatan;
                    }
                } else if ($shuttle == "shuttle5") {

                    // TODO: check with user if we need to use pengeluaran table for shuttle 5

                    for ($bi = 1; $bi <= 12; $bi++) {
                        $subrecord = DB::connection('mysql2')->select("Select sum(A.rekod_jumlaheksport2) as jualaneksport,
							 sum(A.rekod_jumlahtempatan2) as jualantempatan
							 from mkk_" . $shuttle . "_penjualan A
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . " and A.rekod_bulan = " . $bi);

                        $results[$ncount]->kayukumai[$bi]['jualaneksport'] += $subrecord[0]->jualaneksport;
                        $results[$ncount]->kayukumai[13]['jualaneksport'] += $subrecord[0]->jualaneksport;
                        $results[$ncount]->kayukumai[$bi]['jualantempatan'] += $subrecord[0]->jualantempatan;
                        $results[$ncount]->kayukumai[13]['jualantempatan'] += $subrecord[0]->jualantempatan;
                    }
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '143')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '143',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '143')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '243')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '243',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '243')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } else {
            $checkLaporan = Laporan::where('laporan_num', '343')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '343',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '343')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }
        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 144, 245
	******************************************************************************** */

    function getreport_jualan_bypembeli_bybulan($shuttle, $tahun, $title)
    {

        if ($shuttle == 'shuttle3') {

            $laporan = Laporan::where('laporan_num', '144')->where('tahun', $tahun)->first();
            $title_laporan = "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan";
        } elseif ($shuttle == 'shuttle4') {

            $laporan = Laporan::where('laporan_num', '245')->where('tahun', $tahun)->first();
            $title_laporan = "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan";
        }

        if (!$laporan) {
            $results = $this->getreport_jualan_bypembeli_bybulan_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jualantempatan' => [],
            'jualaneksport' => [],
        ];

        for ($gi = 1; $gi <= 13; $gi++) {
            $grandtotal->jualantempatan[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= 13; $gi++) {
                if ($shuttle == 'shuttle3') {
                    $grandtotal->jualantempatan[$gi] += $result->jualantempatan->kayugergaji->$gi;
                } else {
                    $grandtotal->jualantempatan[$gi] += $result->jualantempatan->papanlapis->$gi;
                }
            }
        }

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

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.laporan-data-lama.144', compact(
            'title',
            'title_laporan',
            'tahun',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
        ));
    }

    function getreport_jualan_bypembeli_bybulan_process($shuttle, $tahun, $title)
    {
        $jenispembeli = $this->getjenispembeli($shuttle);

        $ncount = -1;

        foreach ($jenispembeli as $myjenis) {

            $ncount++;
            $results[$ncount] = (object)[];

            $results[$ncount]->kod_keterangan = $myjenis->kod_keterangan;

            for ($bi = 1; $bi <= 13; $bi++) {
                $results[$ncount]->jualantempatan['kayugergaji'][$bi] = 0;
                $results[$ncount]->jualantempatan['papanlapis'][$bi] = 0;
            }

            $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
				mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
				mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
				mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
				pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
				from mkk_" . $shuttle . "_index I
				inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
				inner join negeri on A.rekod_negeri_id = negeri.negeri_id
				inner join daerah on A.rekod_daerah_id = daerah.daerah_id
				inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
				inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
				left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
				inner join negara on A.rekod_negara_id = negara.negara_id
				inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
				inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
				where A.rekod_tahun = " . $tahun);
            // dd($records);
            foreach ($records as $myrecord) {

                for ($bi = 1; $bi <= 12; $bi++) {

                    if ($shuttle == "shuttle3") {

                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);

                        $results[$ncount]->jualantempatan['kayugergaji'][$bi] += $subrecord[0]->jualantempatan;
                        $results[$ncount]->jualantempatan['kayugergaji'][13] += $subrecord[0]->jualantempatan;
                    } else if ($shuttle == "shuttle4") {

                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and A.rekod_bulan = " . $bi . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);

                        $results[$ncount]->jualantempatan['papanlapis'][$bi] += $subrecord[0]->jualantempatan;
                        $results[$ncount]->jualantempatan['papanlapis'][13] += $subrecord[0]->jualantempatan;
                    }
                }
            }
        }
        // dd($results);
        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '144')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '144',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '144')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '245')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '245',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '245')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }


        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 145, 246
	******************************************************************************** */

    function getreport_jualan_bypembeli_bynegeri($shuttle, $tahun, $title)
    {
        if ($shuttle == 'shuttle3') {

            $laporan = Laporan::where('laporan_num', '145')->where('tahun', $tahun)->first();
            $title_laporan = "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri";
        } elseif ($shuttle == 'shuttle4') {

            $laporan = Laporan::where('laporan_num', '246')->where('tahun', $tahun)->first();
            $title_laporan = "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri";
        }

        if (!$laporan) {
            $results = $this->getreport_jualan_bypembeli_bynegeri_process($shuttle, $tahun, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        // dd($results);

        $grandtotal = (object)[
            'jualantempatan' => 0,
        ];

        for ($i = 0; $i < 12; $i++) {
            $total[$i] = (object)[
                'jualantempatan' => 0
            ];
            foreach ($results as $result) {
                if ($shuttle == 'shuttle4') {
                    $total[$i]->jualantempatan += $result->jualantempatan->papanlapis[$i];
                } else {
                    $total[$i]->jualantempatan += $result->jualantempatan->kayugergaji[$i];
                }
            }
        }

        foreach ($total as $data) {
            $grandtotal->jualantempatan += $data->jualantempatan;
        }

        $columns = [
            'Bil',
            'Jenis Pembeli',
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


        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        return view('admins.laporan-data-lama.145', compact(
            'title',
            'title_laporan',
            'columns',
            'shuttle',
            'returnArr',
            'grandtotal',
            'results',
            'total',
            'tahun',
        ));
    }

    function getreport_jualan_bypembeli_bynegeri_process($shuttle, $tahun, $title)
    {
        $jenispembeli = $this->getjenispembeli($shuttle);
        $pcount = -1;

        $negeris = $this->getnegeri();
        // dd($negeris);
        foreach ($jenispembeli as $myjenis) {
            $pcount++;
            $results[$pcount] = (object)[];

            $results[$pcount]->kod_keterangan = $myjenis->kod_keterangan;
            $results[$pcount]->jumlahkeseluruhan['kayugergaji'] = 0;
            $results[$pcount]->jumlahkeseluruhan['papanlapis'] = 0;

            $ncount = -1;
            foreach ($negeris as $mynegeri) {
                $ncount++;
                $results[$pcount]->jualantempatan['kayugergaji'][$ncount] = 0;
                $results[$pcount]->jualantempatan['papanlapis'][$ncount] = 0;
            }

            $ncount = -1;
            foreach ($negeris as $mynegeri) {

                $ncount++;
                $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
					mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
					mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
					mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
					pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
					from mkk_" . $shuttle . "_index I
					inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
					inner join negeri on A.rekod_negeri_id = negeri.negeri_id
					inner join daerah on A.rekod_daerah_id = daerah.daerah_id
					inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
					inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
					left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
					inner join negara on A.rekod_negara_id = negara.negara_id
					inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
					inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
					where A.rekod_tahun = " . $tahun . " and A.rekod_negeri_id = " . $mynegeri->negeri_id);

                foreach ($records as $myrecord) {

                    if ($shuttle == "shuttle3") {

                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);
                        $results[$pcount]->jualantempatan['kayugergaji'][$ncount] += $subrecord[0]->jualantempatan;
                        $results[$pcount]->jumlahkeseluruhan['kayugergaji'] += $subrecord[0]->jualantempatan;
                    } else if ($shuttle == "shuttle4") {

                        $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $tahun . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);
                        $results[$pcount]->jualantempatan['papanlapis'][$ncount] += $subrecord[0]->jualantempatan;
                        $results[$pcount]->jumlahkeseluruhan['papanlapis'] += $subrecord[0]->jualantempatan;
                    }
                }
            }
        }

        if ($shuttle == 'shuttle3') {
            $checkLaporan = Laporan::where('laporan_num', '145')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '145',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '145')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {
            $checkLaporan = Laporan::where('laporan_num', '246')->where('tahun', $tahun)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '246',
                    'tahun' => $tahun,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '246')->where('tahun', $tahun)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }

        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Report 146, 247 //report no 46
	******************************************************************************** */
    function getreport_jualan_bypembeli_bytahun($shuttle, $tahun, $tahunakhir, $title)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        if ($shuttle == 'shuttle3') {

            $laporan = Laporan::where('laporan_num', '146')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa";
        } elseif ($shuttle == 'shuttle4') {

            $laporan = Laporan::where('laporan_num', '247')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa";
        }

        if (!$laporan) {
            $results = $this->getreport_jualan_bypembeli_bytahun_process($shuttle, $tahun, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $grandtotal = (object)[
            'jualantempatan' => []
        ];

        for ($gi = $tahun; $gi <= $tahunjumlah; $gi++) {
            $grandtotal->jualantempatan[$gi] = 0;
        }
        foreach ($results as $result) {
            for ($gi = $tahun; $gi <= $tahunjumlah; $gi++) {
                // dd();
                if ($shuttle == 'shuttle4') {
                    $grandtotal->jualantempatan[$gi] += $result->jualantempatan->papanlapis->$gi;
                } else {
                    $grandtotal->jualantempatan[$gi] += $result->jualantempatan->kayugergaji->$gi;
                }
            }
        }


        $columns = [
            'Bil',
            'Jenis Pembeli',
        ];

        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

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

        return view('admins.laporan-data-lama.146', compact(
            'columns',
            'title',
            'title_laporan',
            'returnArr',
            'results',
            'tahun',
            'tahunakhir',
            'shuttle',
            'grandtotal',
        ));
    }

    function getreport_jualan_bypembeli_bytahun_process($shuttle, $tahunmula, $tahunakhir, $title)
    {
        $tahunjumlah = $tahunakhir + 1;

        $jenispembeli = $this->getjenispembeli($shuttle);
        $pcount = -1;

        foreach ($jenispembeli as $myjenis) {
            $pcount++;
            $results[$pcount] = (object)[];

            $results[$pcount]->kod_keterangan = $myjenis->kod_keterangan;

            for ($i = $tahunmula; $i <= $tahunjumlah; $i++) {
                $results[$pcount]->jualantempatan['kayugergaji'][$i] = 0;
                $results[$pcount]->jualantempatan['papanlapis'][$i] = 0;
            }
            for ($bi = $tahunmula; $bi <= $tahunakhir; $bi++) {
                if ($bi < 2021) {
                    $records = DB::connection('mysql2')->select("Select SQL_CALC_FOUND_ROWS A.*, negeri.negeri_keterangan as rekod_negeri, daerah.daerah_nama as rekod_daerah,
					mik_kod_tarafsyarikat.kod_keterangan as rekod_tarafsyarikat, mik_kod_tarafsyarikat.kod_fungsikhas as rekod_tarafsyarikat_fungsikhas,
					mik_kod_statushakmilik.kod_keterangan as rekod_statushakmilik, mik_kod_statushakmilik.kod_fungsikhas as rekod_statushakmilik_fungsikhas,
					mik_kod_statuswarganegara.kod_keterangan as rekod_statuswarganegara, negara.negara_keterangan as rekod_negara,
					pengguna.pengguna_namapenuh, kod_statusmaklumat.kod_keterangan as rekod_statusmaklumat
					from mkk_" . $shuttle . "_index I
					inner join mkk_" . $shuttle . " A on I.index_current_id = A.rekod_id
					inner join negeri on A.rekod_negeri_id = negeri.negeri_id
					inner join daerah on A.rekod_daerah_id = daerah.daerah_id
					inner join mik_kod_tarafsyarikat on A.rekod_tarafsyarikat_id = mik_kod_tarafsyarikat.kod_id
					inner join mik_kod_statushakmilik on A.rekod_statushakmilik_id = mik_kod_statushakmilik.kod_id
					left join mik_kod_statuswarganegara on A.rekod_statuswarganegara_id = mik_kod_statuswarganegara.kod_id
					inner join negara on A.rekod_negara_id = negara.negara_id
					inner join kod_statusmaklumat on A.rekod_status = kod_statusmaklumat.kod_id
					inner join pengguna on A.rekod_modified_by = pengguna.pengguna_id
					where A.rekod_tahun = " . $bi);

                    foreach ($records as $myrecord) {
                        if ($shuttle == "shuttle3") {

                            $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);

                            $results[$pcount]->jualantempatan['kayugergaji'][$bi] += $subrecord[0]->jualantempatan;
                            $results[$pcount]->jualantempatan['kayugergaji'][$tahunjumlah] += $subrecord[0]->jualantempatan;
                        } else if ($shuttle == "shuttle4") {

                            $subrecord = DB::connection('mysql2')->select("Select sum(B.pembeli_isipadu2) as jualantempatan from mkk_" . $shuttle . "_penjualan A
							 inner join mkk_" . $shuttle . "_penjualan_pembeli B on A.rekod_id = B.pembeli_rekod_id
							 where A.rekod_nossm = '" . $myrecord->rekod_nossm . "' and A.rekod_tahun = " . $bi . "
							 and B.pembeli_jenispembeli_id = " . $myjenis->kod_id);

                            $results[$pcount]->jualantempatan['papanlapis'][$bi] += $subrecord[0]->jualantempatan;
                            $results[$pcount]->jualantempatan['papanlapis'][$tahunjumlah] += $subrecord[0]->jualantempatan;
                        }
                    }
                } else {

                    //report 136
                    if ($shuttle == "shuttle3") {

                        // $pembeli = Pembeli::where('shuttle', 3)->where('keterangan', $myjenis->kod_keterangan)->first();
                        // 18/3/2022 TAHUN BARU IN PROGRESS
                        $records = DB::select("SELECT
                            pembelis.keterangan as pembeli_keterangan,
                            sum(round(penjualan_pembelis.jumlah_jualan_laporan)) as jumlah_jualan

                            FROM
                            shuttles,
                            form_d_s,
                            penjualan_pembelis,
                            pembelis

                            WHERE form_d_s.shuttle_id = shuttles.id

                            AND pembelis.keterangan = '$myjenis->kod_keterangan'
                            AND form_d_s.id = penjualan_pembelis.formds_id
                            AND penjualan_pembelis.pembeli_id = pembelis.id

                            AND shuttles.shuttle_type = '3'
                            AND form_d_s.status = 'Lulus'
                            AND form_d_s.tahun = '$bi'

                            GROUP BY
                            shuttles.negeri_id
                        ;");

                        foreach ($records as $myrecord) {
                            $results[$pcount]->jualantempatan['kayugergaji'][$bi] += $myrecord->jumlah_jualan;
                            $results[$pcount]->jualantempatan['kayugergaji'][$tahunjumlah] += $myrecord->jumlah_jualan;
                        }
                    }
                    //report 146

                    else if ($shuttle == "shuttle4") {

                        $pembeli = Pembeli::where('shuttle', 4)->where('keterangan', $myjenis->kod_keterangan)->first();

                        $records = DB::select("SELECT
                            pembelis.keterangan as pembeli_keterangan,
                            sum(round(penjualan_pembelis.jumlah_jualan)) as jumlah_jualan


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
                            AND form4_e_s.tahun = '$bi'

                            GROUP BY
                            shuttles.negeri_id
                        ;");

                        foreach ($records as $myrecord) {
                            $results[$pcount]->jualantempatan['papanlapis'][$bi] += $myrecord->jumlah_jualan;
                            $results[$pcount]->jualantempatan['papanlapis'][$tahunjumlah] += $myrecord->jumlah_jualan;
                        }
                    }
                }
            }
        }
        if ($shuttle == 'shuttle3') {

            $checkLaporan = Laporan::where('laporan_num', '146')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '146',
                    'tahun' => $tahunmula,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '146')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        } elseif ($shuttle == 'shuttle4') {

            $checkLaporan = Laporan::where('laporan_num', '247')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->count();

            if ($checkLaporan == 0) {
                $laporan = Laporan::create([ //create laporan data
                    'laporan_num' => '247',
                    'tahun' => $tahunmula,
                    'tahun_akhir' => $tahunakhir,
                    'shuttle_type' => $shuttle,
                    'data_laporan' => json_encode($results) ?? '',
                ]);
            } else {
                $laporan = Laporan::where('laporan_num', '247')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();
                $laporan->data_laporan = json_encode($results) ?? '';
                $laporan->save();
            }
        }


        return json_decode($laporan->data_laporan);
    }

    /* ********************************************************************************
	Enhanced array_multisort
	******************************************************************************** */

    function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row->$field;
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    /* ********************************************************************************
	Select negeri
	******************************************************************************** */

    function getnegeri()
    {
        $sql = DB::connection('mysql2')->select("Select * from negeri where negeri_deleted = 0 and negeri_id > 0 order by negeri_id");

        return $sql;
    }

    /* ********************************************************************************
	Select kategoripekerja
	******************************************************************************** */

    function getkategoripekerja()
    {
        $sql = DB::connection('mysql2')->select("Select * from mkk_kod_kategoripekerja where kod_deleted = 0 order by kod_id");

        return $sql;
    }

    /* ********************************************************************************
	Select active spesies
	******************************************************************************** */

    function getactivespesies()
    {
        // $sql = DB::connection('mysql2')->select("Select mkk_spesies.*, mkk_kod_kumpulankayu.kod_singkatan as spesies_kumpulankayu from mkk_spesies
        // 	inner join mkk_kod_kumpulankayu on mkk_spesies.spesies_kumpulankayu_id = mkk_kod_kumpulankayu.kod_id
        // 	where spesies_deleted = 0 and spesies_aktif = 1 order by spesies_kumpulankayu_id, spesies_namatempatan");

        $sql = DB::connection('mysql2')->select("Select mkk_spesies.*, mkk_kod_kumpulankayu.kod_singkatan as spesies_kumpulankayu from mkk_spesies
			inner join mkk_kod_kumpulankayu on mkk_spesies.spesies_kumpulankayu_id = mkk_kod_kumpulankayu.kod_id
			where spesies_deleted = 0 order by spesies_kumpulankayu_id, spesies_namatempatan");

        return $sql;
    }

    /* ********************************************************************************
	Select spesies by id
	******************************************************************************** */

    function getspesies_byid($spesies_id)
    {
        $sql = DB::connection('mysql2')->select("Select mkk_spesies.*, mkk_kod_kumpulankayu.kod_singkatan as spesies_kumpulankayu from mkk_spesies
			inner join mkk_kod_kumpulankayu on mkk_spesies.spesies_kumpulankayu_id = mkk_kod_kumpulankayu.kod_id
			where spesies_id = " . $spesies_id);

        return $sql;
    }


    /* ********************************************************************************
	Select jenispembeli
	******************************************************************************** */

    function getjenispembeli($shuttle)
    {
        $sql = DB::connection('mysql2')->select("Select * from mkk_kod_jenispembeli_" . $shuttle . " where kod_deleted = 0 order by kod_fungsikhas, kod_id");

        return $sql;
    }

    /* ********************************************************************************
	Select jenis kayu kumai (I)
	******************************************************************************** */

    function getjeniskumai1()
    {
        $sql = DB::connection('mysql2')->select("Select * from mkk_kod_jeniskumai1 where kod_deleted = 0 and kod_id > 0 order by kod_parent_id, kod_id");

        return $sql;
    }
}
