<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporansExport implements FromView
{
    public function __construct($data)
    {
        // dd($data);
        $this->results = $data['results'] ?? [];

        $this->columns = $data['columns'] ?? [];

        $this->title = $data['title'] ?? [];

        $this->tahun = $data['tahun'] ?? [];

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
        $columns = $this->columns;
        $results = $this->results;
        $title = $this->title;
        $tahun = $this->tahun;

        // dd($results);
        if (
            $title == "1. Maklumat Penuh Senarai Kilang Papan" ||
            $title == "2. Senarai Pemilik Kilang Papan Bumiputera" ||
            $title == "3. Senarai Pemilik Kilang Papan Bukan Bumiputera" ||
            $title == "4. Senarai Pemilik Kilang Papan Bukan Warganegara"
        ) {
            $shuttle = $results['shuttle'] ?? [];
            $data_shuttles = $results['data_shuttles'] ?? [];
            $data_guna_tenagas = $results['data_guna_tenagas'] ?? [];
            $data_kemasukan_bahans = $results['data_kemasukan_bahans'] ?? [];
            $data_form_d_s = $results['data_form_d_s'] ?? [];


            return view(
                'admins.laporan.excel.101',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'tahun',
                    'data_shuttles',
                    'data_guna_tenagas',
                    'data_kemasukan_bahans',
                    'data_form_d_s',
                )
            );
        } else if ($title == "5. Top 10 Pengeluar Kayu Gergaji di Kilang Papan") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            return view(
                'admins.laporan.excel.105',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                )
            );
        } else if ($title == "6. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            // dd($datas_formc);
            return view(
                'admins.laporan.excel.105',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                )
            );
        } else if ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan") {
            $shuttle = $results['shuttle'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $jumlah_setiap_negeri = $results['jumlah_setiap_negeri'] ?? [];
            $columns = $results['columns'] ?? [];
            $title = $results['title_laporan'] ?? [];
            $tahun = $results['tahun'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.107',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'jumlah_setiap_negeri',
                    'tahun',
                )
            );
        } else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Mengikut Negeri Dan Jantina") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.111',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.112',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.113',
                compact(
                    'title',
                    'columns',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.114',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.115',
                compact(
                    'title',
                    'columns',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $tahun = $results['tahun'] ?? [];

            return view(
                'admins.laporan.excel.121',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.122',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal'
                )
            );
        } else if ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.123',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'kumpulan_kayu',
                    'datas',
                    'tahun'
                )
            );
        } else if ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.124',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            return view(
                'admins.laporan.excel.125',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'kumpulan_kayu',
                    'datas',
                )
            );
        } else if ($title == "31. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.131',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "32. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Negeri Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.132',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "33. Pengeluaran Kayu Gergaji Oleh Kilang Papan Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.133',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'kumpulan_kayu',
                    'datas',
                    'tahun'
                )
            );
        } else if ($title == "34. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.134',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "35. Pengeluaran Kayu Gergaji Oleh Kilang Papan Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.135',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'kumpulan_kayu',
                    'datas',
                )
            );
        } else if ($title == "36. Pengeluaran Kayu Gergaji Daripada Spesies Tertentu Oleh Kilang Papan Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $nama_spesis = $results['nama_spesis'] ?? [];
            $spesis = $results['spesis'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.136',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'negeri_list',
                    'nama_spesis',
                    'spesis'
                )
            );
        } else if ($title == "41. Jualan Domestik Kayu Gergaji Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.141',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'bulan_senarai',
                    'datas',
                )
            );
        } else if ($title == "42. Jualan Domestik Kayu Gergaji Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.142',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "43. Jualan Domestik Kayu Gergaji Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.143',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "44. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $pembelis = $results['pembelis'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.144',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'pembelis'
                )
            );
        } else if ($title == "45. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $pembeli_list = $results['pembeli_list'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.145',
                compact(
                    'columns',
                    'title',
                    'pembeli_list',
                    'datas',
                    'negeri_list',
                    'tahun',
                )
            );
        } else if ($title == "46. Jualan Domestik Kayu Gergaji Bagi Jenis Pembeli Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $pembeli_list = $results['pembeli_list'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.146',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'pembeli_list',
                    'datas',
                )
            );
        } else if ($title == "47. Jualan Eksport Kayu Gergaji Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.147',
                compact(
                    'columns',
                    'title',
                    'datas',
                    'bulan_senarai',
                    'tahun',
                )
            );
        } else if ($title == "48. Jualan Eksport Kayu Gergaji Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.148',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        }

        //shuttle 4 start
        elseif (
            $title == "1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir" ||
            $title == "2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera" ||
            $title == "3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera" ||
            $title == "4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara"
        ) {
            $shuttle = $results['shuttle'] ?? [];
            $data_shuttles = $results['data_shuttles'] ?? [];
            $data_guna_tenagas = $results['data_guna_tenagas'] ?? [];
            $data_kemasukan_bahans = $results['data_kemasukan_bahans'] ?? [];
            $produk_pengeluaran = $results['produk_pengeluaran'] ?? [];
            $rekod_muka = $results['rekod_muka'] ?? [];
            $data_form_d_s = $results['data_form_d_s'] ?? [];



            return view(
                'admins.laporan.excel.201',
                compact(
                    'title',
                    'columns',
                    'tahun',
                    'shuttle',
                    'data_shuttles',
                    'data_guna_tenagas',
                    'data_kemasukan_bahans',
                    'produk_pengeluaran',
                    'rekod_muka',
                    'data_form_d_s'
                )
            );
        } else if ($title == "5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            $produk_pengeluaran = $results['produk_pengeluaran'] ?? [];
            $rekod_muka = $results['rekod_muka'] ?? [];
            return view(
                'admins.laporan.excel.205',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                    'produk_pengeluaran',
                    'rekod_muka'
                )
            );
        } else if ($title == "6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            $produk_pengeluaran = $results['produk_pengeluaran'] ?? [];
            $rekod_muka = $results['rekod_muka'] ?? [];
            return view(
                'admins.laporan.excel.206',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                    'produk_pengeluaran',
                    'rekod_muka'
                )
            );
        } else if ($title == "7. Top 10 Kilang Papan Dalam Penggunaan Spesies Kayu Balak Di Kilang Papan Lapis/Venir") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            return view(
                'admins.laporan.excel.207',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun'
                )
            );
        } else if ($title == "8. Jumlah Pelaburan (Harta Tetap) Bagi Kilang Papan Lapis/Venir") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            $produk_pengeluaran = $results['produk_pengeluaran'] ?? [];
            $rekod_muka = $results['rekod_muka'] ?? [];
            $datas_formd = $results['datas_formd'] ?? [];
            return view(
                'admins.laporan.excel.208',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun'
                )
            );
        } else if ($title == "9. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Papan Lapis/Venir") {
            $datas = $results['datas'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            return view(
                'admins.laporan.excel.209',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'tahun'
                )
            );
        }  else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Papan Lapis/Venir Mengikut Negeri Dan Jantina") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];
            return view(
                'admins.laporan.excel.211',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Papan Lapis/Venir") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.212',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.213',
                compact(
                    'title',
                    'columns',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.214',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Papan Lapis/Venir") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.215',
                compact(
                    'title',
                    'columns',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "21. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $tahun = $results['tahun'] ?? [];

            return view(
                'admins.laporan.excel.221',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Negeri Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.222',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal'
                )
            );
        } else if ($title == "23. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.223',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'kumpulan_kayu',
                    'datas',
                    'tahun'
                )
            );
        } else if ($title == "24. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.224',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Balak Oleh Kilang Papan Lapis/Venir Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            return view(
                'admins.laporan.excel.225',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'kumpulan_kayu',
                    'datas',
                )
            );
        } else if ($title == "31. Pengeluaran Papan Lapis Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.231',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "32. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.232',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "33. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];


            return view(
                'admins.laporan.excel.233',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'kumpulan_kayu',
                    'datas',
                    'tahun',
                    'grandtotal',
                )
            );
        } else if ($title == "34. Pengeluaran Papan Lapis Bagi Negeri-Negeri Mengikut Ketebalan Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.234',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "35. Pengeluaran Papan Lapis Bagi Negeri-Negeri Dan Bulan Mengikut Ketebalan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];



            return view(
                'admins.laporan.excel.235',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.236',
                compact(
                    'columns',
                    'tahun',
                    'title',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "37. Pengeluaran Venir Bagi Negeri-Negeri Mengikut Jenis Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.237',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "38. Pengeluaran Venir Bagi Negeri-Negeri Dan Bulan Mengikut Jenis") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];


            return view(
                'admins.laporan.excel.238',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                    'grandtotal'
                )
            );
        } else if ($title == "41. Jualan Domestik Papan Lapis/Venir Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.241',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'bulan_senarai',
                    'datas',
                )
            );
        } else if ($title == "42. Jualan Domestik Papan Lapis/Venir Mengikut Neger") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.242',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.243',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "44. Jualan Domestik Venir Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.244',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "45. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $pembelis = $results['pembelis'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.245',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'pembelis'
                )
            );
        } else if ($title == "46. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $pembelis = $results['pembelis'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.246',
                compact(
                    'columns',
                    'title',
                    'pembelis',
                    'datas',
                    'negeri_list',
                    'tahun',
                )
            );
        } else if ($title == "47. Jualan Domestik Papan Lapis Bagi Jenis Pembeli Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $pembeli_list = $results['pembeli_list'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.247',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'pembeli_list',
                    'datas',
                )
            );
        } else if ($title == "48. Jualan Eksport Papan Lapis/Venir Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.248',
                compact(
                    'columns',
                    'title',
                    'datas',
                    'bulan_senarai',
                    'tahun',
                )
            );
        } else if ($title == "49. Jualan Eksport Papan Lapis/Venir Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.249',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        }

        //shuttle 5 start
        elseif (
            $title == "1. Maklumat Penuh Senarai Kilang Kayu Kumai" ||
            $title == "2. Senarai Pemilik Kilang Kayu Kumai Bumiputera" ||
            $title == "3. Senarai Pemilik Kilang Kayu Kumai Bukan Bumiputera" ||
            $title == "4. Senarai Pemilik Kilang Kayu Kumai Bukan Warganegara"
        ) {
            $shuttle = $results['shuttle'] ?? [];
            $data_shuttles = $results['data_shuttles'] ?? [];
            $data_guna_tenagas = $results['data_guna_tenagas'] ?? [];
            $data_kemasukan_bahans = $results['data_kemasukan_bahans'] ?? [];
            $data_form_d_s = $results['data_form_d_s'] ?? [];

            return view(
                'admins.laporan.excel.301',
            compact(
                'title',
                'columns',
                'shuttle',
                'tahun',
                'data_shuttles',
                'data_guna_tenagas',
                'data_kemasukan_bahans',
                'data_form_d_s',
                )
            );
        } else if ($title == "5. Top 10 Pengeluar Kayu Kumai di Kilang Kayu Kumai") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            return view(
                'admins.laporan.excel.305',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                )
            );
        } else if ($title == "6. Top 10 Kilang Kayu Kumai Dalam Penggunaan Spesies Kayu Balak Di Kilang Kayu Kumai") {
            $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
            // dd($datas_formc);
            return view(
                'admins.laporan.excel.305',
                compact(
                    'title',
                    'columns',
                    'shuttle',
                    'datas_formc',
                    'tahun',
                )
            );
        } else if ($title == "7. Jumlah Pelaburan (Harta Tetap) Mengikut Negeri Bagi Kilang Kayu Kumai") {
            $shuttle = $results['shuttle'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $jumlah_setiap_negeri = $results['jumlah_setiap_negeri'] ?? [];
            $columns = $results['columns'] ?? [];
            $title = $results['title_laporan'] ?? [];
            $tahun = $results['tahun'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.307',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'jumlah_setiap_negeri',
                    'tahun',
                )
            );
        } else if ($title == "11. Guna Tenaga Dan Pendapatan (RM) Di Kilang Kayu Kumai Mengikut Negeri Dan Jantina") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.311',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "12. Jumlah Dan Purata Pendapatan (RM) Pekerja Mengikut Kategori Di Kilang Kayu Kumai") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.312',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "13. Jumlah Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.313',
                compact(
                    'title',
                    'columns',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'tahun',
                )
            );
        } else if ($title == "14. Jumlah Guna Tenaga Mengikut Negeri Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.314',
                compact(
                    'title',
                    'columns',
                    'negeri_list',
                    'datas',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "15. Jumlah dan Purata Pendapatan Guna Tenaga Mengikut Kategori Dan Kewarganegaraan Di Kilang Kayu Kumai") {
            $columns = $results['columns'] ?? [];
            $kategori = $results['kategori'] ?? [];
            $jumlah = $results['jumlah'] ?? [];
            $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
            $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $suku_tahun = $results['suku_tahun'] ?? [];
            $suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];

            // dd($datas_formc);
            return view(
                'admins.laporan.excel.315',
                compact(
                    'title',
                    'columns',
                    'tahun',
                    'nama_suku_tahun',
                    'nama_suku_tahun_akhir',
                    'kategori',
                    'jumlah',
                    'suku_tahun',
                    'suku_tahun_akhir',
                )
            );
        } else if ($title == "21. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $tahun = $results['tahun'] ?? [];

            return view(
                'admins.laporan.excel.321',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        } else if ($title == "22. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.322',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal'
                )
            );
        } else if ($title == "23. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Bagi Negeri-Negeri Mengikut Kumpulan Kayu Kayan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.323',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'kumpulan_kayu',
                    'datas',
                    'tahun'
                )
            );
        } else if ($title == "24. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.324',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'datas',
                    'kumpulan_kayu',
                )
            );
        } else if ($title == "25. Penggunaan Kayu Gergaji Oleh Kilang Kayu Kumai Mengikut Kumpulan Kayu Kayan Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            return view(
                'admins.laporan.excel.325',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'kumpulan_kayu',
                    'datas',
                )
            );
        } else if ($title == "31. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.331',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "32. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Negeri Bagi Siri Masa") {
            $columns = $results['columns'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

            return view(
                'admins.laporan.excel.332',
                compact(
                    'columns',
                    'title',
                    'tahun_mula',
                    'tahun_akhir',
                    'negeri_list',
                    'datas',
                    'grandtotal',
                )
            );
        } else if ($title == "33. Pengeluaran Kayu Kumai Oleh Kilang Kayu Kumai Mengikut Jenis Produk Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.333',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "41. Jualan Domestik Kayu Kumai Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.341',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'bulan_senarai',
                    'datas',
                )
            );
        } else if ($title == "42. Jualan Domestik Kayu Kumai Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.342',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "43. Jualan Domestik Kayu Kumai Mengikut Negeri Dan Bulan") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.343',
                compact(
                    'columns',
                    'title',
                    'tahun',
                    'negeri_list',
                    'datas',
                )
            );
        } else if ($title == "44. Jualan Eksport Kayu Kumai Mengikut Bulan") {
            $columns = $results['columns'] ?? [];
            $bulan_senarai = $results['bulan_senarai'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.344',
                compact(
                    'columns',
                    'title',
                    'datas',
                    'bulan_senarai',
                    'tahun',
                )
            );
        } else if ($title == "45. Jualan Eksport Kayu Kumai Mengikut Negeri") {
            $columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

            return view(
                'admins.laporan.excel.345',
                compact(
                    'columns',
                    'title',
                    'negeri_list',
                    'datas',
                    'tahun',
                )
            );
        }
    }
}
