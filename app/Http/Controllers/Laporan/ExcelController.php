<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Daerah;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;

use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Negeri;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\Spesis;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\LaporansExport;
use App\Models\JenisKayu;

class ExcelController extends Controller
{
    //Alert!!! These report controller in LaporanDataLamaController : 122,

    //export laporan 101, 102, 103, 104
    public function laporan_shuttle_3_1($title, $tahun, $file_type)
    {
        // dd($title);

        if ($title == "1") {
            $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan";

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
        } elseif ($title == "2") {
            $title_laporan = "2. Senarai Pemilik Kilang Papan Bumiputera";

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
        } elseif ($title == "3") {
            $title_laporan = "3. Senarai Pemilik Kilang Papan Bukan Bumiputera";

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
        } elseif ($title == "4") {
            $title_laporan = "4. Senarai Pemilik Kilang Papan Bukan Warganegara";

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

            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Kayu Gergaji',
            'Penjualan Kayu Gergaji Eksport',
            'Penjualan Kayu Gergaji Tempatan',
        ];

        $results = [
            'shuttle' => $shuttle,

            'data_shuttles' => $data_shuttles,
            'data_guna_tenagas' => $data_guna_tenagas,
            'data_kemasukan_bahans' => $data_kemasukan_bahans,
            'data_form_d_s' => $data_form_d_s,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'columns' => $columns,
            'tahun' => $tahun,
            'results' => $results
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.101', $returnArr)->setPaper('a3', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 105, 106
    public function laporan_shuttle_3_5($title, $tahun, $file_type, $spesies)
    {
        if ($title == "5") {
            $title_laporan = "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan";

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
        } elseif ($title == "6") {
            $title_laporan = "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak";

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
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Jumlah Pengeluaran Kayu Gergaji',

        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc,
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.105', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 107
    public function laporan_shuttle_3_7($title, $tahun, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'datas'     => $datas,
            'jumlah_setiap_negeri' => $jumlah_setiap_negeri,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
            'tahun' => $tahun,
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.107', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 111
    public function laporan_shuttle_3_11($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $columns = [
            'Bil',
            'Negeri',
            'Guna Tenaga',
            'Pendapatan (RM)',
            'Purata (RM)',
        ];

        $title_laporan = "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina";

        $results = [
            'title_laporan' => $title_laporan,
            'columns'     => $columns,
            'negeri_list' => $negeri_list,
            'datas' => $datas,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
            'tahun' => $tahun,
            'suku_tahun' => $nama_suku_tahun,
            'suku_tahun_akhir' => $nama_suku_tahun,

        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.111', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 112
    public function laporan_shuttle_3_12($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.112', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 113
    public function laporan_shuttle_3_13($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.113', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 114
    public function laporan_shuttle_3_14($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.114', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 115
    public function laporan_shuttle_3_15($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.115', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 121
    public function laporan_shuttle_3_21($title, $tahun, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'datas'     => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
            'tahun' => $tahun,
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,

        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.121', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 22
    public function laporan_shuttle_3_22($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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



        $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa";

        $results = [
            'columns' => $columns,
            'title_laporan'     => $title_laporan,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list' => $tahun,
            'datas' => $datas,
            'grandtotal' => $grandtotal,
            'negeri_list' => $negeri_list
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.122', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 123
    public function laporan_shuttle_3_23($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu' => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.123', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 124
    public function laporan_shuttle_3_24($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.124', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_25($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
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

        $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $tahun = $tahun_mula;

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.125', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_31($title, $tahun, $file_type)
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
        $title_laporan = "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.131', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_32($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.132', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_33($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis'     => $spesis,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.133', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_34($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            // 'negeri_list'     => $negeri_list,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis'     => $spesis,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.134', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_35($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
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

        $tahun = $tahun_mula;

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis'     => $spesis,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        // dd("masuk");

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.135', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_36($title, $tahun, $spesis, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'spesis'     => $spesis,
            'negeri_list' => $negeri_list,
            'title_laporan' => $title_laporan,
            'datas' => $datas,
            'columns' => $columns,
        ];

        $returnArr = [
            'results' => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.136', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 141
    public function laporan_shuttle_3_41($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.141', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //export laporan 142
    public function laporan_shuttle_3_42($title, $tahun, $file_type)
    {
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

        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Kayu Gergaji Mengikut Negeri";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.142', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_43($title, $tahun, $file_type)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(form_d_s.total_export_laporan)  as export,
                    sum(form_d_s.jumlah_pasaran_tempatan_laporan) as domestik,
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.143', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_44($title, $tahun, $file_type)
    {
        // dd("masuk");
        $pembelis = Pembeli::where('shuttle', '3')->get();

        foreach ($pembelis as $pembeli) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $datas[$pembeli->keterangan][$bulan] = DB::select("SELECT
                pembelis.keterangan as pembeli_keterangan,
                sum(penjualan_pembelis.jumlah_jualan_laporan)  as jumlah_jualan,
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

        $results = [
            'tahun' => $tahun,
            'pembelis'     => $pembelis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.144', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_45($title, $tahun, $file_type)
    {
        $pembeli_list = Pembeli::where('shuttle', '3')->get();

        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');
        // dd($pembeli_list);
        foreach ($negeri_list as $negeri) {
            foreach ($pembeli_list as $pembeli) {

                $data = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(round(penjualan_pembelis.jumlah_jualan_laporan))  as jumlah_jualan

                FROM
                shuttles,
                form_d_s,
                penjualan_pembelis,
                pembelis


                WHERE form_d_s.shuttle_id = shuttles.id
                AND pembelis.id = $pembeli->id
                AND form_d_s.id = penjualan_pembelis.formds_id
                AND penjualan_pembelis.pembeli_id = pembelis.id

                AND shuttles.negeri_id = '$negeri->negeri'
                AND shuttles.shuttle_type = '3'
                AND form_d_s.status = 'Lulus'
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

        $results = [
            'tahun' => $tahun,
            'pembeli_list'     => $pembeli_list,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.145', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_46($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        // dd($tahun_mula);
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $tahun = $tahun_mula;
        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";


        $pembeli_list = Pembeli::where('shuttle', '3')->get();

        foreach ($pembeli_list as $pembeli) {
            for ($curr_year = $tahun_mula; $curr_year <= $tahun_akhir; $curr_year++) {

                $datas[$pembeli->keterangan][$curr_year] =
                    DB::select("SELECT
                    pembelis.keterangan as pembeli_keterangan,
                    sum(round(penjualan_pembelis.jumlah_jualan_laporan))  as jumlah_jualan

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

        $results = [
            'tahun' => $tahun,
            'pembeli_list'     => $pembeli_list,
            'tahun_mula'     => $tahun_mula,
            'tahun_akhir'     => $tahun_akhir,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.146', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_47($title, $tahun, $file_type)
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


        $columns = [
            'Bil',
            'Bulan',
            'Kayu Gergaji (m³)',
        ];

        $title_laporan = "47. Jualan Eksport Kayu Gergaji Mengikut Bulan";

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.147', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_3_48($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.148', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    //shuttle 4 start

    public function laporan_shuttle_4_1($title, $tahun, $file_type)
    {
        // dd($title);

        if ($title == "1") {
            $title_laporan = "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir";

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
        } elseif ($title == "2") {
            $title_laporan = "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '4')->where('status_warganegara', 'Bumiputera');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bumiputera") diluluskan untuk Shuttle 4 untuk menjana laporan');
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
        } elseif ($title == "3") {
            $title_laporan = "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera";

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
        } elseif ($title == "4") {
            $title_laporan = "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '4')->where('status_warganegara', 'Bukan Warganegara');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bukan Warganegara") diluluskan untuk Shuttle 4 untuk menjana laporan');
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

            'Jumlah Stok Semasa Kayu Balak',
            'Jumlah Penggunaan Kayu Balak',
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',
            'Jumlah Pengeluaran Venir Mengikut Jenis',

            'Jualan Eksport',
            'Jualan Tempatan',
        ];

        $results = [
            'shuttle' => $shuttle,
            'data_shuttles' => $data_shuttles,
            'data_guna_tenagas' => $data_guna_tenagas,
            'data_kemasukan_bahans' => $data_kemasukan_bahans,
            'produk_pengeluaran' => $produk_pengeluaran,
            'rekod_muka' => $rekod_muka,
            'data_form_d_s' => $data_form_d_s
        ];


        $returnArr = [
            'title' => $title_laporan,
            'columns' => $columns,
            'tahun' => $tahun,
            'results' => $results
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.201', $returnArr)->setPaper('a3', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),   str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_5($title, $tahun, $file_type, $spesies)
    {
        if ($title == "5") {
            $title_laporan = "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '4');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A diluluskan untuk Shuttle 5 untuk menjana laporan');
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
            'Jumlah Pengeluaran Papan Lapis Mengikut Jenis',
            'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan',

        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc,
            'produk_pengeluaran' => $produk_pengeluaran,
            'rekod_muka' => $rekod_muka
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.205', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            // dd($returnArr);
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_6($title, $tahun, $file_type, $spesies)
    {
        if ($title == "6") {
            $title_laporan = "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '4');
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
            'Jumlah Pengeluaran Venir Mengikut Jenis'

        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc,
            'produk_pengeluaran' => $produk_pengeluaran,
            'rekod_muka' => $rekod_muka
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.206', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            // dd($returnArr);
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_7($title, $tahun, $file_type, $spesies)
    {
        // dd($spesies);
        if ($title == "7") {
            $title_laporan = "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir";


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
        }
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
            'Jumlah Pengeluaran Kayu Balak',
            // 'Penjualan Kayu Gergaji Eksport',
            // 'Penjualan Kayu Gergaji Tempatan',
        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.207', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            // dd($returnArr);
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_8($title, $tahun, $file_type, $spesies)
    {
        if ($title == "8") {
            $title_laporan = "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '4');
                })
                ->get();

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
            'Nilai Harta Tetap Pada Tahun Berakhir'

        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc,
            'produk_pengeluaran' => $produk_pengeluaran,
            'rekod_muka' => $rekod_muka,
            'datas_formd' => $datas_formd
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.208', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            // dd($returnArr);
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_9($title, $tahun, $file_type)
    {
        if ($title == "9") {
            $title_laporan = "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir";

            $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

            $datas =  DB::select("SELECT shuttles.negeri_id as negeri,
                    SUM(shuttles.nilai_harta) as jumlah
                    FROM shuttles, form_a_s
                    WHERE form_a_s.shuttle_id = shuttles.id
                    AND shuttles.shuttle_type = '4'
                    AND form_a_s.status = 'Lulus'
                    AND form_a_s.tahun = $tahun
                    GROUP BY shuttles.negeri_id;");
        }

        $jumlah_setiap_negeri = 0;

        foreach ($datas as $data) {
            $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
        }


        $columns = [
            'Bil',
            'Negeri',
            'Nilai Harta Tetap Pada Tahun Berakhir',

        ];

        $results = [

            'datas' => $datas,
            'negeri_list' => $negeri_list
        ];

        $returnArr = [
            'title'       => $title_laporan,

            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.209', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            // dd($returnArr);
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }


    public function laporan_shuttle_4_11($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'columns'     => $columns,
            'title_laporan' => $title_laporan,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
            'tahun' => $tahun,
            'datas' => $datas,
        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.211', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_12($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.212', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_13($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.213', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_14($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.214', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_15($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.215', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_21($title, $tahun, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'datas'     => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
            'tahun' => $tahun,
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,

        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.221', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_22($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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



        $title_laporan = "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa";

        $results = [
            'columns' => $columns,
            'title_laporan'     => $title_laporan,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list' => $tahun,
            'datas' => $datas,
            'grandtotal' => $grandtotal,
            'negeri_list' => $negeri_list
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.222', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_23($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu' => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.223', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_24($title, $tahun, $file_type)
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

        $title_laporan = "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan";

        $results = [
            'tahun' => $tahun,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.224', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_25($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
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
            'Kumpulan Kayu',
        ];

        //dynamic year
        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
            $columns[] = $x;
        }

        //add jumlah at the end of column
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa";

        $tahun = $tahun_mula;

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.225', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_31($title, $tahun, $file_type)
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
        $title_laporan = "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.231', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_32($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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
        $columns[] = 'Jumlah (m³)';

        $title_laporan = "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa";

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.232', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_33($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'grandtotal'     => $grandtotal,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.233', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_34($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {

        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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


        $title_laporan = "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa";

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.234', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {

            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_35($title, $tahun, $file_type)
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

        $title_laporan = "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.235', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_36($title, $tahun, $file_type)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            foreach ($negeri_list as $negeri) {
                # code...
                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(distinct(form4_d_s.jumlah_pengeluaran)) as jumlah_pengeluaran

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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.236', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_37($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.237', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {

            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_38($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'grandtotal'     => $grandtotal,

        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.238', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_41($title, $tahun, $file_type)
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

        $title_laporan = "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan";

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.241', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', ' ', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_42($title, $tahun, $file_type)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {
            $data = DB::select("SELECT
            form4_e_s.id,
            shuttles.negeri_id as negeri,
            sum(round(penjualan_pembelis.jumlah_jualan)) as domestik_papan_lapis,
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

        $columns = [
            'Bil',
            'Negeri',
            'Papan Lapis (m³)',
            'Venir (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Papan Lapis/Venir Mengikut Neger";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', ' ', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.242', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', '', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_43($title, $tahun, $file_type)
    {
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        for ($month = 1; $month <= 12; $month++) {
            foreach ($negeri_list as $negeri) {
                $data = DB::select("SELECT
                shuttles.negeri_id as negeri,
                sum(round(penjualan_pembelis.jumlah_jualan)) as domestik

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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.243', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_44($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', '', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.244', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', '', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_45($title, $tahun, $file_type)
    {
        // dd("masuk");
        $pembelis = Pembeli::where('shuttle', '4')->get();

        foreach ($pembelis as $pembeli) {
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $datas[$pembeli->keterangan][$bulan] = DB::select("SELECT
                pembelis.keterangan as pembeli_keterangan,
                sum(round(penjualan_pembelis.jumlah_jualan)) as jumlah_jualan,

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

        $results = [
            'tahun' => $tahun,
            'pembelis'     => $pembelis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.245', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_46($title, $tahun, $file_type)
    {
        $pembelis = Pembeli::where('shuttle', '4')->get();
        $negeri_list = Daerah::distinct()->orderBy('negeri')->get('negeri');

        foreach ($negeri_list as $negeri) {

            foreach ($pembelis as $pembeli) {

                $data = DB::select("SELECT
                    shuttles.negeri_id as negeri,
                    sum(round(penjualan_pembelis.jumlah_jualan)) as domestik


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


        $results = [
            'tahun' => $tahun,
            'pembelis'     => $pembelis,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.246', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_47($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        // dd($tahun_mula);
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }

        $tahun = $tahun_mula;
        $start_date = $tahun_mula . "-01-01";
        $end_date = $tahun_akhir . "-12-31";


        $pembeli_list = Pembeli::where('shuttle', '4')->get();

        foreach ($pembeli_list as $pembeli) {
            for ($curr_year = $tahun_mula; $curr_year <= $tahun_akhir; $curr_year++) {

                $datas[$pembeli->keterangan][$curr_year] =
                    DB::select("SELECT
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

        $results = [
            'tahun' => $tahun,
            'pembeli_list'     => $pembeli_list,
            'tahun_mula'     => $tahun_mula,
            'tahun_akhir'     => $tahun_akhir,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.247', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_48($title, $tahun, $file_type)
    {
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

        $title_laporan = "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan";

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', '', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.248', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', '', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_4_49($title, $tahun, $file_type)
    {
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

        $title_laporan = "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = str_replace('/', '', $title_laporan) . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.249', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  str_replace('/', '', $title_laporan) . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    // Shuttle 5 - Waniiiiiiiiiii
    public function laporan_shuttle_5_1($title, $tahun, $file_type)
    {
        if ($title == "1") {
            $title_laporan = "1. Maklumat Penuh Senarai Kilang Kayu Kumai";

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

        } elseif ($title == "2") {

            $title_laporan = "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '5')->where('status_warganegara', 'Bumiputera');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bumiputera") diluluskan untuk Shuttle 5 untuk menjana laporan');
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
        } elseif ($title == "3") {
            $title_laporan = "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '5')->where('status_warganegara', 'Bukan Bumiputera');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bukan Bumiputera") diluluskan untuk Shuttle 5 untuk menjana laporan');
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
        } elseif ($title == "4") {
            $title_laporan = "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara";

            $shuttle = FormA::where('status', 'Lulus')->where('tahun', $tahun)
                ->whereHas('shuttle', function ($q) {
                    $q->where('shuttle_type', '5')->where('status_warganegara', 'Bukan Warganegara');
                })
                ->get();

            if ($shuttle->count() == 0) {
                return redirect()->back()->with('error', 'Sila pastikan sekurang-kurang 1 Borang A (Kilang berstatus "Bukan Warganegara") diluluskan untuk Shuttle 5 untuk menjana laporan');
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

            }
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

                'Jumlah Penggunaan Kayu Balak',
                'Jumlah Pengeluaran Kayu Gergaji',
                'Penjualan Kayu Gergaji Eksport',
                'Penjualan Kayu Gergaji Tempatan',
            ];

            $results = [
                'shuttle' => $shuttle,
                'data_shuttles' => $data_shuttles,
                'data_guna_tenagas' => $data_guna_tenagas,
                'data_kemasukan_bahans' => $data_kemasukan_bahans,
                'data_form_d_s' => $data_form_d_s,

            ];

            $returnArr = [
                'title' => $title_laporan,
                'columns' => $columns,
                'tahun' => $tahun,
                'results' => $results
            ];
            if ($file_type == "pdf" || $file_type == "print") {
                $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
                $pdf = PDF::loadView('admins.laporan.pdf.301', $returnArr)->setPaper('a3', 'landscape');

                if ($file_type == "print") {
                    return $pdf->stream($pdf_name);
                }
                return $pdf->download($pdf_name);
            } else {
                return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
            }
        }

    public function laporan_shuttle_5_5($title, $tahun, $file_type, $spesies)
    {
        if ($title == "5") {
            $title_laporan = "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai";

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
        } elseif ($title == "6") {
            $title_laporan = "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai";

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
            'Tarikh Kilang Ditubuhkan',
            'Tarikh Kilang Mula Beroperasi',
            'Taraf Sah Syarikat',
            'Status Hak Milik',
            'Jumlah Pengeluaran Kayu Kumai',

        ];

        $results = [
            'shuttle' => $shuttle,
            'datas_formc' => $datas_formc,
        ];

        $returnArr = [
            'title'       => $title_laporan,
            'shuttle'       => $shuttle,
            'datas_formc'       => $datas_formc,
            'columns'       => $columns,
            'tahun'         => $tahun,
            'results'       => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.305', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_7($title, $tahun, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'datas'     => $datas,
            'jumlah_setiap_negeri' => $jumlah_setiap_negeri,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
            'tahun' => $tahun,
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];


        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.307', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_11($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'columns'     => $columns,
            'title_laporan' => $title_laporan,
            'nama_suku_tahun' => $nama_suku_tahun,
            'nama_suku_tahun_akhir' => $nama_suku_tahun_akhir,
            'tahun' => $tahun,
            'datas' => $datas,
        ];

        $breadcrumbs = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('laporan'), 'name' => "Laporan"],
            ['link' => '#', 'name' => $title_laporan],
        ];

        $kembali = route('laporan', date('Y'));

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.311', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_12($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.312', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_13($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'title'     => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.313', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_14($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.314', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_15($title, $tahun, $suku_tahun, $suku_tahun_akhir, $file_type)
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
                                        AND (date(formbs.created_at) BETWEEN '$start_date' AND '$end_date')

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

        $results = [
            'tahun' => $tahun,
            'kategori'     => $kategori,
            'jumlah'     => $jumlah,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
            'nama_suku_tahun'     => $nama_suku_tahun,
            'nama_suku_tahun_akhir'     => $nama_suku_tahun_akhir,

        ];

        $returnArr = [
            'results'     => $results,
            'title'     => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.315', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_21($title, $tahun, $file_type)
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

        $results = [
            'negeri_list' => $negeri_list,
            'datas'     => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
            'tahun' => $tahun,
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,

        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.321', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_22($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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



        $title_laporan = "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";

        $results = [
            'columns' => $columns,
            'title_laporan'     => $title_laporan,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list' => $tahun,
            'datas' => $datas,
            'grandtotal' => $grandtotal,
            'negeri_list' => $negeri_list
        ];

        $returnArr = [
            'results'     => $results,
            'title' => $title_laporan,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.322', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_23($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'kumpulan_kayu' => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.323', $returnArr)->setPaper('a4', 'landscape');

            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }

            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_24($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'spesis' => $spesis,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.324', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_25($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
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

        $tahun = $tahun_mula;

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'kumpulan_kayu'     => $kumpulan_kayu,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.325', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_31($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.331', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_32($title, $shuttle, $tahun_mula, $tahun_akhir, $file_type)
    {
        if ($tahun_mula > $tahun_akhir) {
            $temp = $tahun_mula;
            $tahun_mula = $tahun_akhir;
            $tahun_akhir = $temp;
        }
        $tahun = $tahun_mula;
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

        $title_laporan = "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa";

        $results = [
            'tahun' => $tahun,
            'tahun_mula' => $tahun_mula,
            'tahun_akhir' => $tahun_akhir,
            'negeri_list'     => $negeri_list,
            'datas'     => $datas,
            'grandtotal'     => $grandtotal,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.332', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_33($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'datas'     => $datas,
            'jenis_kayus'     => $jenis_kayus,
            'columns'     => $columns,
            'title_laporan'     => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.333', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_41($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results'     => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.341', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_42($title, $tahun, $file_type)
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

        $columns = [
            'Bil',
            'Negeri',
            'Kayu Gergaji (m³)',
        ];

        // dd($datas);

        $title_laporan = "42. Jualan Domestik Kayu Kumai Mengikut Negeri";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.342', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_43($title, $tahun, $file_type)
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

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.343', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_44($title, $tahun, $file_type)
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


        $columns = [
            'Bil',
            'Bulan',
            'Kayu Gergaji (m³)',
        ];

        $title_laporan = "44. Jualan Eksport Kayu Kumai Mengikut Bulan";

        $results = [
            'tahun' => $tahun,
            'bulan_senarai'     => $bulan_senarai,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.344', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            // return $pdf->download($pdf_name);
            return $pdf->download($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }

    public function laporan_shuttle_5_45($title, $tahun, $file_type)
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

        $title_laporan = "45. Jualan Eksport Kayu Kumai Mengikut Negeri";

        $results = [
            'tahun' => $tahun,
            'negeri_list'     => $negeri_list,
            'datas' => $datas,
            'columns' => $columns,
            'title_laporan' => $title_laporan,
        ];

        $returnArr = [
            'title' => $title_laporan,
            'results' => $results,
        ];

        if ($file_type == "pdf" || $file_type == "print") {
            $pdf_name = $title_laporan . " Bagi Tahun " . $tahun . ".pdf";
            $pdf = PDF::loadView('admins.laporan.pdf.345', $returnArr)->setPaper('a4', 'landscape');
            if ($file_type == "print") {
                return $pdf->stream($pdf_name);
            }
            return $pdf->download($pdf_name);
            // return $pdf->stream($pdf_name);
        } else {
            return Excel::download(new LaporansExport($returnArr),  $title_laporan . ' Bagi Tahun ' . $tahun  . '.xlsx');
        }
    }
}
