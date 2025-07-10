<?php

namespace App\Exports;

use App\Models\Laporan;
// use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// class LaporansLamaExport implements FromCollection
class LaporansLamaExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Laporan::all();
    // }

    public function __construct($data)
    {
        $this->results = $data['results'];

        $this->columns = $data['columns'];

        $this->shuttle = $data['shuttle'];

        $this->title = $data['title_laporan'];

        $this->tahun = $data['tahun'];

        if (isset($data['tahunakhir'])) {
            $this->tahunakhir = $data['tahunakhir'];
        }

        if (isset($data['nama_suku_tahun'])) {
            $this->nama_suku_tahun = $data['nama_suku_tahun'];
        }

        if (isset($data['nama_suku_tahun_akhir'])) {
            $this->nama_suku_tahun_akhir = $data['nama_suku_tahun_akhir'];
        }

        if (isset($data['grandtotal'])) {
            $this->grandtotal = $data['grandtotal'];
        }

        if (isset($data['negeri_list'])) {
            $this->negeri_list = $data['negeri_list'];
        }

        if (isset($data['kumpulan_kayu'])) {
            $this->kumpulan_kayu = $data['kumpulan_kayu'];
        }
        if (isset($data['spesis_name'])) {
            $this->spesis_name = $data['spesis_name'];
        } else {
            $this->spesis_name = null;
        }

        if (isset($data['total'])) {
            $this->total = $data['total'];
        }
    }

    public function view(): View
    {
        //dd($this->data);
        $columns = $this->columns;
        $results = $this->results;
        $shuttle = $this->shuttle;
        $title = $this->title;
        $tahun = $this->tahun;
        // dd($results);

        if (
            $title == "1. Maklumat Penuh Senarai Kilang Papan" ||
            $title == "2. Senarai Pemilik Kilang Papan Bumiputera" ||
            $title == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera" ||
            $title == "4. Senarai Pemilik Kilang Papan Bukan Warganegara"
        ) {
            return view(
                'admins.laporan-data-lama.excel.101',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if ($title == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan") {
            return view(
                'admins.laporan-data-lama.excel.105',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if (strpos($title, "Top 10 Kilang Papan Dalam Penggunaan Kayu Balak Spesies")) {
            $spesies_name = $this->spesis_name;
            return view(
                'admins.laporan-data-lama.excel.106',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'spesies_name'
                )
            );
        } else if ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan") {
            return view(
                'admins.laporan-data-lama.excel.107',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.111',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.112',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.113',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.114',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.115',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.121',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.122',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal',
                )
            );
        } else if ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.123',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.124',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.125',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.131',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.132',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal',
                )
            );
        } else if ($title == "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.133',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.134',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.135',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if (str_contains($title, "36. Pengeluaran Kayu Gergaji Daripada Spesies")) {
            $grandtotal = $this->grandtotal;
            $spesis_name = $this->spesis_name;
            return view(
                'admins.laporan-data-lama.excel.136',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'spesis_name',
                    'grandtotal',
                )
            );
        } else if ($title == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.141',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.147',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.142',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.143',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.144',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            $total = $this->total;
            return view(
                'admins.laporan-data-lama.excel.145',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                    'total'
                )
            );
        } else if ($title == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.148',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.146',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahunakhir',
                    'tahun',
                    'grandtotal',
                )
            );
        }
        //SHUTTLE 4
        else if (
            $title == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir"
            || $title == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera"
            || $title == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera"
            || $title == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara"
        ) {
            return view(
                'admins.laporan-data-lama.excel.201',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if (
            $title == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir"
        ) {
            return view(
                'admins.laporan-data-lama.excel.205',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if (
            $title == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir"
        ) {
            return view(
                'admins.laporan-data-lama.excel.205',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if ($title == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir") {
            $spesies_name = $this->spesis_name;
            return view(
                'admins.laporan-data-lama.excel.106',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'spesies_name'
                )
            );
        } else if ($title == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir") {
            return view(
                'admins.laporan-data-lama.excel.208',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if ($title == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir") {
            return view(
                'admins.laporan-data-lama.excel.107',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Lapis/Venir Mengikut Negeri Dan Jantina") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.111',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan Lapis/Venir") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.112',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.113',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.114',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.115',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.121',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.122',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal',
                )
            );
        } else if ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.123',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.124',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.125',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.131',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.232',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal'
                )
            );
        } else if ($title == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri dan Bulan Mengikut Jenis") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.233',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa") {
            $tahunakhir = $this->tahunakhir;
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.234',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                    'tahunakhir',
                )
            );
        } else if ($title == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.235',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.131',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.232',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal'
                )
            );
        } else if ($title == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.233',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.141',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "42. Jualan Domestik Papan Lapis/Venir Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.142',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.143',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.143',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.144',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            $total = $this->total;
            return view(
                'admins.laporan-data-lama.excel.145',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                    'total'
                )
            );
        } else if ($title == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.146',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahunakhir',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.147',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.148',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } //SHUTTLE 5
        else if (
            $title == "1. Maklumat Penuh Senarai Kilang Kayu Kumai" ||
            $title == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera" ||
            $title == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera" ||
            $title == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara"
        ) {
            return view(
                'admins.laporan-data-lama.excel.101',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        }
        else if ($title == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai") {
            return view(
                'admins.laporan-data-lama.excel.105',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        } else if (str_contains($title, "Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies")) {
            $spesies_name = $this->spesis_name;
            return view(
                'admins.laporan-data-lama.excel.106',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'spesies_name'
                )
            );
        } else if ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai") {
            return view(
                'admins.laporan-data-lama.excel.107',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                )
            );
        }else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Kayu Kumai Mengikut Negeri Dan Jantina") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.111',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Kayu Kumai") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.112',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.113',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.114',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $nama_suku_tahun = $this->nama_suku_tahun;
            $nama_suku_tahun_akhir = $this->nama_suku_tahun_akhir;
            return view(
                'admins.laporan-data-lama.excel.115',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir'
                )
            );
        }else if ($title == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.121',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.122',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal',
                )
            );
        } else if ($title == "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $negeri_list = $this->negeri_list;
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.123',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'negeri_list',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            return view(
                'admins.laporan-data-lama.excel.124',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $kumpulan_kayu = $this->kumpulan_kayu;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.125',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'kumpulan_kayu',
                )
            );
        }else if ($title == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.131',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $grandtotal = $this->grandtotal;
            $tahunakhir = $this->tahunakhir;
            return view(
                'admins.laporan-data-lama.excel.132',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'tahunakhir',
                    'grandtotal',
                )
            );
        }else if ($title == "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.333',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }else if ($title == "41. Jualan Domestik Kayu Kumai Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.141',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }else if ($title == "42. Jualan Domestik Kayu Kumai Mengikut Negeri") {
            $grandtotal = $this->grandtotal;

            // dd($grandtotal);
            return view(
                'admins.laporan-data-lama.excel.142',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }else if ($title == "43. Jualan Domestik Kayu Kumai Mengikut Negeri Dan Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.143',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }else if ($title == "44. Jualan Eksport Kayu Kumai Mengikut Bulan") {
            $grandtotal = $this->grandtotal;
            return view(
                'admins.laporan-data-lama.excel.147',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }else if ($title == "45. Jualan Eksport Kayu Kumai Mengikut Negeri") {
            $grandtotal = $this->grandtotal;

            // dd($grandtotal);
            return view(
                'admins.laporan-data-lama.excel.148',
                compact(
                    'columns',
                    'results',
                    'shuttle',
                    'title',
                    'tahun',
                    'grandtotal',
                )
            );
        }

        dd($title);
    }
}
