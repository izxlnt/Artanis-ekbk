<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\LaporansLamaExport;
use Illuminate\Http\Request;
use App\Exports\LaporanTigaTigaExport;
use App\Http\Controllers\Controller;
use App\Imports\LaporanTigaTiga;
use App\Models\Daerah;
use App\Models\KumpulanKayu;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ExcelDataLamaController extends Controller
{
    /* ********************************************************************************
	Report 101-104, 201-204, 301-304
	******************************************************************************** */
    public function getreport_senaraikilang($shuttle, $statuspemilik, $tahun, $title, $file_type)
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
        // dd($title_laporan);
        $results = json_decode($laporan->data_laporan);

        if ($results == "") {
            $results = [];
        }

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";

            if ($title == "1") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.101', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "2") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.102', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "3") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.101', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "4") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.104', $returnArr)->setPaper('a4', 'landscape');
            }

            if ($title == "301") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.101', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "302") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.102', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "303") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.101', $returnArr)->setPaper('a4', 'landscape');
            } else if ($title == "304") {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.104', $returnArr)->setPaper('a4', 'landscape');
            }

            if ($shuttle == 'shuttle4') {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.201', $returnArr)->setPaper('a4', 'landscape');
            }

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 105, 205-206, 305
	******************************************************************************** */
    function getreport_top10pengeluar($shuttle, $tahun, $lapisvenier, $title, $file_type)
    {
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

        if (!$laporan) {
            $results = $this->getreport_top10pengeluar_proses($shuttle, $tahun, $lapisvenier, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'title'=>$title
        ];

        // dd($results);


        if ($file_type == "pdf" || $file_type == "print") {

            if ($shuttle == 'shuttle3' || $shuttle == 'shuttle5') {
                $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.105', $returnArr)->setPaper('a4', 'landscape');
                if ($file_type == "print") {
                    return $pdf->stream($pdf_name);
                }
                return $pdf->download($pdf_name);
            }else{
                $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.205', $returnArr)->setPaper('a4', 'landscape');
                if ($file_type == "print") {
                    return $pdf->stream($pdf_name);
                }
                return $pdf->download($pdf_name);
            }
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 106, 207, 306
	******************************************************************************** */
    function getreport_top10pengguna($shuttle, $tahun, $spesies, $title, $file_type)
    {
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
            'Jumlah Penggunaan Kayu Balak Spesies ' . $spesies_name->spesies_namatempatan,
        ];

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'spesis_name' => $spesies_name,
        ];

        // DD($title_laporan);

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name =  str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.106', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr), str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 208 - shuttle 4 only
	******************************************************************************** */
    function getreport_jumlahpelaburan($shuttle, $tahun, $title, $file_type)
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

            'Nilai Harta Tetap Pada Tahun Berakhir'
        ];

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name =  str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.208', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr), str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 107, 209, 307
	******************************************************************************** */
    function getreport_jumlahpelaburan_bynegeri($shuttle, $tahun, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        // dd($title_laporan);
        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.107', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 111, 211, 311
	******************************************************************************** */
    function getreport_gunatenagadanpendapatan_bynegeri($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
        ];

        if ($nama_suku_tahun != $nama_suku_tahun_akhir) {
            $title_laporan = $title_laporan . ' - Suku Tahun ' . $nama_suku_tahun . ' Hingga Suku Tahun ' . $nama_suku_tahun_akhir;
        } else {
            $title_laporan = $title_laporan . ' - Suku Tahun ' . $nama_suku_tahun;
        }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.111', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 112, 212, 312
	******************************************************************************** */

    function getreport_gunatenagadanpendapatan_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $columns = [
            'Bil',
            'Kategori',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)'
        ];

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
        ];

        if ($nama_suku_tahun != $nama_suku_tahun_akhir) {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun . ' Hingga Suku Tahun ' . $nama_suku_tahun_akhir;
        } else {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun;
        }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.112', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }


    /* ********************************************************************************
	Report 113, 213, 313
	******************************************************************************** */

    function getreport_gunatenaga_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
        ];

        // dd($returnArr);

        if ($nama_suku_tahun != $nama_suku_tahun_akhir) {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun . ' Hingga Suku Tahun ' . $nama_suku_tahun_akhir;
        } else {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun;
        }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.113', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 114, 214, 314
	******************************************************************************** */
    function getreport_gunatenaga_bynegeri($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title, $file_type)
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

        $columns = [
            'Bil',
            'Negeri',
            'Bumiputera',
            'Bukan Bumiputera',
            'Bukan Warganegara',
            'Jumlah'
        ];

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
        ];

        // dd($returnArr);

        if ($nama_suku_tahun != $nama_suku_tahun_akhir) {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun . ' Hingga Suku Tahun ' . $nama_suku_tahun_akhir;
        } else {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun;
        }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.114', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 115, 215, 315
	******************************************************************************** */

    function getreport_pecahangunatenagadanpendapatan_bykategori($shuttle, $tahun, $sukutahunmula, $sukutahunakhir, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
        ];

        // dd($returnArr);

        if ($nama_suku_tahun != $nama_suku_tahun_akhir) {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun . ' Hingga Suku Tahun ' . $nama_suku_tahun_akhir;
        } else {
            $title_laporan = str_replace('/', ' ', $title_laporan) . ' - Suku Tahun ' . $nama_suku_tahun;
        }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.115', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 121, 221, 321
	******************************************************************************** */

    function getreport_penggunaan_bynegeri($shuttle, $tahun, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
        ];

        // dd($returnArr);

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.121', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 122, 222, 322
	******************************************************************************** */
    function getreport_penggunaan_bynegeri_bytahun($shuttle, $tahun, $tahunakhir, $title, $file_type)
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'tahunakhir' => $tahunakhir,
            'grandtotal' => $grandtotal,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.122', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 123, 223, 323
	******************************************************************************** */

    function getreport_penggunaan_bykumpulankayu_bynegeri($shuttle, $tahun, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

        $negeri_list = Daerah::distinct()->get('negeri');

        $kumpulan_kayu = KumpulanKayu::get();

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'negeri_list' => $negeri_list,
            'kumpulan_kayu' => $kumpulan_kayu,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.123', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 124, 224, 324
	******************************************************************************** */
    function getreport_penggunaan_bykumpulankayu_bybulan($shuttle, $tahun, $title, $file_type)
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

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'kumpulan_kayu' => $kumpulan_kayu,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.124', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 125, 225, 325
	******************************************************************************** */
    function getreport_penggunaan_bykumpulankayu_bytahun($shuttle, $tahun, $tahunakhir, $title, $file_type)
    {
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

        $results = json_decode($laporan->data_laporan);

        $kumpulan_kayu = KumpulanKayu::get();

        $columns = [
            'Bil',
            'Kumpulan Kayu Kayan',
        ];

        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');


        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'tahunakhir'     => $tahunakhir,
            'kumpulan_kayu' => $kumpulan_kayu,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.125', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 131, 231/233/236/238, 331
	******************************************************************************** */
    function getreport_pengeluaran_bynegeri_bybulan($shuttle, $tahun, $title, $file_type)
    {
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

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
        ];

        // if ($title == '233' || $title == '238') {
        //     return view('admins.laporan-data-lama.233', compact(
        //         'title',
        //         'title_laporan',
        //         'columns',
        //         'tahun',
        //         'shuttle',
        //         'returnArr',
        //         'results',
        //         'grandtotal'
        //     ));
        // } else {
        //     return view('admins.laporan-data-lama.131', compact(
        //         'title',
        //         'title_laporan',
        //         'columns',
        //         'tahun',
        //         'shuttle',
        //         'returnArr',
        //         'results',
        //         'grandtotal'
        //     ));
        // }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.131', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 132, 232/237, 332
	******************************************************************************** */

    function getreport_pengeluaran_bynegeri_bytahun($shuttle, $tahun, $tahunakhir, $title, $file_type)
    {
        if ($shuttle == 'shuttle3') {
            $laporan = Laporan::where('laporan_num', '132')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";
        } elseif ($shuttle == 'shuttle4') {
            $laporan = Laporan::where('laporan_num', '232')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            if ($title == '232') {
                $title_laporan = "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";
            } else {
                $title_laporan = "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";
            }
        } else {
            $laporan = Laporan::where('laporan_num', '332')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();
            $title_laporan = "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";
        }

        if (!$laporan) {
            $results = $this->getreport_pengeluaran_bynegeri_bytahun_process($shuttle, $tahun, $tahunakhir, $title);
        } else {
            $results = json_decode($laporan->data_laporan);
        }

        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        for ($gi = $tahun; $gi <= $tahunjumlah; $gi++) {
            $grandtotal->jumlahpengeluaran[$gi] = 0;
            $grandtotal->jumlahpengeluaran['mr'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['wbp'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['muka'][$gi] = 0;
            $grandtotal->jumlahpengeluaran['teras'][$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = $tahun; $gi <= $tahunakhir; $gi++) {
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

        for ($gi = $tahun; $gi < $tahunjumlah; $gi++) {
            array_push($columns, $gi);
        }
        array_push($columns, 'Jumlah (m³)');

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'tahunakhir'     => $tahunakhir,
            'grandtotal' => $grandtotal,
        ];

        // if ($title == '233' || $title == '238') {
        //     return view('admins.laporan-data-lama.233', compact(
        //         'title',
        //         'title_laporan',
        //         'columns',
        //         'tahun',
        //         'shuttle',
        //         'returnArr',
        //         'results',
        //         'grandtotal'
        //     ));
        // } else {
        //     return view('admins.laporan-data-lama.131', compact(
        //         'title',
        //         'title_laporan',
        //         'columns',
        //         'tahun',
        //         'shuttle',
        //         'returnArr',
        //         'results',
        //         'grandtotal'
        //     ));
        // }

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.132', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 133 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bynegeri($shuttle, $tahun, $title, $file_type)
    {
        $laporan = Laporan::where('laporan_num', '133')->where('tahun', $tahun)->first();

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu'     => $kumpulan_kayu,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.133', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 134 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bybulan($shuttle, $tahun, $title, $file_type)
    {
        $laporan = Laporan::where('laporan_num', '134')->where('tahun', $tahun)->first();

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu'     => $kumpulan_kayu,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.134', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 135 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaran_bykumpulankayu_bytahun($shuttle, $tahun, $tahunakhir, $title, $file_type)
    {
        if ($tahun > $tahunakhir) {
            $temp = $tahun;

            $tahun = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $laporan = Laporan::where('laporan_num', '135')->where('tahun', $tahun)->where('tahun_akhir', $tahunakhir)->first();

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'tahunakhir'     => $tahunakhir,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu'     => $kumpulan_kayu,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.135', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 136 - shuttle 3 only
	******************************************************************************** */

    function getreport_pengeluaranspesies_bynegeri_bybulan($shuttle, $tahun, $spesies, $title, $file_type)
    {
        $laporan = Laporan::where('laporan_num', '136')->where('tahun', $tahun)->where('spesis', $spesies)->first();

        $results = json_decode($laporan->data_laporan);

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
        $title_laporan = "36. Pengeluaran Kayu Gergaji Daripada Spesies " . ucwords($spesis_name[0]->spesies_namatempatan) . " Oleh Kilang Papan Mengikut Negeri Dan Bulan";

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'spesis_name' => $spesis_name,
            'grandtotal' => $grandtotal,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.136', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 234 - shuttle 4 only
	******************************************************************************** */
    function getreport_pengeluarantebal_bynegeri_bytahun($shuttle, $tahunmula, $tahunakhir, $title, $file_type)
    {
        if ($tahunmula > $tahunakhir) {
            $temp = $tahunmula;

            $tahunmula = $tahunakhir;

            $tahunakhir = $temp;
        }

        $tahunjumlah = $tahunakhir + 1;

        $laporan = Laporan::where('laporan_num', '234')->where('tahun', $tahunmula)->where('tahun_akhir', $tahunakhir)->first();

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahunmula,
            'grandtotal'     => $grandtotal,
            'tahunakhir' => $tahunakhir
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahunmula . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.234', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahunmula  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 333 - shuttle 5 only
	******************************************************************************** */
    function getreport_pengeluaran_byproduk_bybulan($shuttle, $tahun, $title, $file_type)
    {
        $laporan = Laporan::where('laporan_num', '333')->where('tahun', $tahun)->first();
        $title_laporan = "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan";

        $results = json_decode($laporan->data_laporan);
        // dd($results);


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


        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.333', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 235 - shuttle 4 only
	******************************************************************************** */

    function getreport_pengeluarantebal_bynegeri_bybulan($shuttle, $tahun, $title, $file_type)
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
            for (
                $gi = 1;
                $gi <= 13;
                $gi++
            ) {
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.235', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }

        // return view('admins.laporan-data-lama.235', compact(
        //     'title',
        //     'title_laporan',
        //     'columns',
        //     'shuttle',
        //     'returnArr',
        //     'grandtotal',
        //     'results',
        //     'tahun',
        // ));
    }

    /* ********************************************************************************
	Report 141/147, 241/246, 341/344 //report 41 & 47
	******************************************************************************** */

    function getreport_jualan_bybulan($shuttle, $tahun, $title, $file_type)
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
            }else if ($title == '344') {
                $laporan = Laporan::where('laporan_num', '341')->where('tahun', $tahun)->first();
                $title_laporan = "44. Jualan Eksport Kayu Kumai Mengikut Bulan";
            }
        }

        $results = json_decode($laporan->data_laporan);

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
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
        }  else if ($shuttle == 'shuttle5') {
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'title'     => $title,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            if ($title == '41' || $title == '341') {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.141', $returnArr)->setPaper('a4', 'landscape');
            } else {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.147', $returnArr)->setPaper('a4', 'landscape');
            }


            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 142/148, 242/249, 342/345 //report 42 & 48
	******************************************************************************** */

    function getreport_jualan_bynegeri($shuttle, $tahun, $title, $file_type)
    {

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


        $results = json_decode($laporan->data_laporan);

        $grandtotal = (object)[
            'jumlahpengeluaran' => [],
        ];

        $ncount = -1;
        $negeris = $this->getnegeri();
        foreach ($negeris as $mynegeri) {
            $ncount++;
        }
        for ($gi = 1; $gi <= $ncount; $gi++) {
            $grandtotal->jualantempatan[$gi] = 0;
            $grandtotal->jualaneksport[$gi] = 0;
        }

        foreach ($results as $result) {
            for ($gi = 1; $gi <= $ncount; $gi++) {
                $grandtotal->jualantempatan[$gi] += $result->kayugergaji->jualantempatan;
                $grandtotal->jualaneksport[$gi] += $result->kayugergaji->jualaneksport;
            }
        }
        // dd($grandtotal);
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
            } else{
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
            if($title == '42'){
                $title_laporan = "42. Jualan Domestik Kayu Gergaji Mengikut Negeri";
            }else{
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'=> $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
            'title'=> $title
        ];

        // dd($returnArr);


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";

            if ($title == '42' || $title == '242' || $title == '342') {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.142', $returnArr)->setPaper('a4', 'landscape');
            } else {
                $pdf = PDF::loadView('admins.laporan-data-lama.pdf.148', $returnArr)->setPaper('a4', 'landscape');
            }
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr), str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 143, 243/244, 343
	******************************************************************************** */

    function getreport_jualan_bynegeridanbulan($shuttle, $tahun, $title, $file_type)
    {

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

        $results = json_decode($laporan->data_laporan);

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

        $returnArr = [
            'title' => $title,
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
        ];
        // dd($grandtotal);

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.143', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 144, 245
	******************************************************************************** */

    function getreport_jualan_bypembeli_bybulan($shuttle, $tahun, $title, $file_type)
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.144', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 145, 246 //report no 45
	******************************************************************************** */

    function getreport_jualan_bypembeli_bynegeri($shuttle, $tahun, $title, $file_type)
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
                } elseif($shuttle == 'shuttle5'){
                    $total[$i]->jualantempatan += $result->jualantempatan->kayukumai[$i];
                }
                else {
                    $total[$i]->jualantempatan += $result->jualantempatan->kayugergaji[$i];
                }
            }
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
                } elseif($shuttle == 'shuttle5'){
                    $total[$i]->jualantempatan += $result->jualantempatan->kayukumai[$i];
                }else {
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'grandtotal' => $grandtotal,
            'total' => $total
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.145', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    /* ********************************************************************************
	Report 146, 247 //report no 46
	******************************************************************************** */
    function getreport_jualan_bypembeli_bytahun($shuttle, $tahun, $tahunakhir, $title, $file_type)
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

        $returnArr = [
            'results' => $results,
            'columns'     => $columns,
            'shuttle'     => $shuttle,
            'title_laporan'     => $title_laporan,
            'tahun'     => $tahun,
            'tahunakhir'     => $tahunakhir,
            'grandtotal' => $grandtotal,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan-data-lama.pdf.146', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansLamaExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
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
	Select negeri
	******************************************************************************** */

    function getnegeri()
    {
        $sql = DB::connection('mysql2')->select("Select * from negeri where negeri_deleted = 0 and negeri_id > 0 order by negeri_id");

        return $sql;
    }

}
