<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Batch;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC as ModelsFormC;
use App\Models\Kemasukan;
use App\Models\KemasukanBahan;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\RecoveryRate;
use App\Models\Shuttle;
use App\Models\Spesis;
use App\Models\User;
use App\Notifications\IBK\BorangDiHantar;
use App\Services\FormFlowService;

class FormCController extends Controller
{
    public $jumlah_besar_baki_stok_bulan_lepas;

    public function shuttle_3_formCKKB($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }

        // Block access to months that have not arrived yet
        if ((int)$year > (int)date('Y') || ((int)$year == (int)date('Y') && (int)$bulan_id > (int)date('n'))) {
            return redirect()->back()->with('error', 'Borang untuk bulan ini belum dibuka.');
        }

        $shuttle_id = auth()->user()->shuttle_id;
        if (!FormA::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->exists()) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu sebelum mengisi Borang C.');
        }
        $suku = (int) ceil($bulan_id / 3);
        if (!FormB::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('suku_tahun', $suku)->whereIn('status', FormFlowService::SUBMITTED)->exists()) {
            return redirect()->back()->with('error', "Sila isi Borang B Suku {$suku} terlebih dahulu sebelum mengisi Borang C.");
        }

        // Check registration date - user cannot fill months before registration
        $shuttle = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate)); // 1-12
        $registrationYear = date('Y', strtotime($registrationDate));
        
        $shuttle_type = auth()->user()->shuttle->shuttle_type;
        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        $kayu_id = '1';

        $species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();

        // Create Form C if it doesn't exist
        if (!$formc) {
            $formc = new ModelsFormC();
            $formc->shuttle_id = auth()->user()->shuttle_id;
            $formc->bulan = $bulan_id;
            $formc->tahun = $year;
            $formc->status = 'Tidak Diisi';
            $formc->created_at = $year . '-' . str_pad($bulan_id, 2, '0', STR_PAD_LEFT) . '-01';
            $formc->save();
        } elseif ($formc->status === 'Ditutup') {
            // Month has arrived — auto-open the form
            $formc->status = 'Tidak Diisi';
            $formc->save();
        }

        $currentYear = date('Y');
        $registrationDate = $kilang_info->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        
        // Block access to years that are too old (more than 1 year back)
        if ($year < ($currentYear - 1)) {
            return redirect()->back()->with('error', 'Tahun yang dipilih terlalu lama. Sila isi borang untuk tahun semasa atau tahun lepas sahaja.');
        }
        
        // Get previous month data for carryforward (baki bulan lepas)
        // No validation needed here - validation is done at listing page level
        if ($bulan_id == 1) {
            // January: get December of previous year if available
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', 12)
                ->where('tahun', $year - 1)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        } else {
            // Feb-Dec: get previous month in same year if available
            $lastmonth = $bulan_id - 1;
            \Log::info('KKB Display - Looking for previous month: ' . $lastmonth . ', year: ' . $year);
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->where('tahun', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->whereNotNull('tahun')
                ->first();
            \Log::info('KKB Display - Found lastMonthformc: ' . ($lastMonthformc ? 'YES (id: ' . $lastMonthformc->id . ', tahun: ' . $lastMonthformc->tahun . ')' : 'NO'));
        }

        // Get previous month data for carryforward if exists
        if ($lastMonthformc) {
            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) use ($kayu_id) {
                    $q->where('kumpulan_kayu_id', $kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $lastMonthformc->id)
                ->get();
        } else {
            $kemasukan_bahans_lastmonth = collect();
        }

        // Build lookup by species ID so carry-forward matches correctly regardless of record order
        $lastmonth_lookup = [];
        foreach ($kemasukan_bahans_lastmonth as $lm) {
            $lastmonth_lookup[$lm->getAttributes()['spesis_id']] = $lm;
        }
        if (!empty($lastmonth_lookup)) {
            $first_lm = reset($lastmonth_lookup);
            $this->jumlah_besar_baki_stok_bulan_lepas = $first_lm->jumlah_besar_baki_stok_bulan_depan ?? 0;
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);
        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $key => $value) {
                $lastmonth_data = $lastmonth_lookup[$value->id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_stok_kayu_balak[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                    $total_stok_kayu_balak[$key] = 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $jumlah_stok_kayu_balak[$key] = $baki_stok;
                $kayu_masuk[$key] = 0;
                $proses_masuk[$key] = 0;
                $proses_keluar[$key] = 0;
                $jumlah_kayu_masuk[$key] = 0;
                $total_kayu_masuk_jentera[$key] = 0;
                $total_kayu_keluar_jentera[$key] = 0;
                $baki_stok_kehadapan[$key] = $baki_stok;
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {
                $species_id = $data->getAttributes()['spesis_id'];
                $lastmonth_data = $lastmonth_lookup[$species_id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $kayu_masuk[$key] = $data->kayu_masuk;
                $jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $proses_masuk[$key] = $data->proses_masuk;
                $proses_keluar[$key] = $data->proses_keluar;

                $jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
            }
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 3C - KKB"],
            ];

            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 4C - KKB"],
            ];

            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 5C - KKB"],
            ];

            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'kilang_info' => $kilang_info,
            'bulan'       => $bulan,
            'bulan_id'       => $bulan_id,
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,

            'kumpulan_kayu' => $kumpulan_kayu,
            'species' => $species,
            'species_count' => $species_count,
            'min_recovery_rate' => $min_recovery_rate,
            'max_recovery_rate' => $max_recovery_rate,

            'baki_stoks' => $baki_stoks ?? 0,
            'kayu_masuk'     => $kayu_masuk,
            'jumlah_stok_kayu_balak'     => $jumlah_stok_kayu_balak ?? 0,
            'proses_masuk'     => $proses_masuk ?? 0,
            'proses_keluar'     => $proses_keluar ?? 0,
            'jumlah_baki_stok'     => $jumlah_baki_stok ?? 0,
            'jumlah_kayu_masuk'     => $jumlah_kayu_masuk ?? 0,
            'total_stok_kayu_balak'     => $total_stok_kayu_balak ?? 0,
            'total_kayu_masuk_jentera'     => $total_kayu_masuk_jentera ?? 0,
            'total_kayu_keluar_jentera'     => $total_kayu_keluar_jentera ?? 0,
            'total_kayu_dibawa_bulan_hadapan'     => $total_kayu_dibawa_bulan_hadapan ?? 0,
            'baki_stok_kehadapan'     => $baki_stok_kehadapan ?? 0,
            'jumlah_besar_kemasukan_kayu_ke_kilang'     => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
            'jumlah_besar_stok_kayu_balak'     => $jumlah_besar_stok_kayu_balak ?? 0,
            'jumlah_besar_kayu_ke_dalam_jentera'     => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera'     => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
            'jumlah_besar_baki_stok_bulan_depan'     => $jumlah_besar_baki_stok_bulan_depan ?? 0,
        ];

        // dd($returnArr);
        return view('admins.shuttle-three.FormC.shuttle-3-formC-KKB', $returnArr, compact('year'));
    }

    public function store_kkb(Request $request, $bulan_id, $year = null)
    {
        if (!$year) {
            $year = date('Y');
        }
        
        if ($request->tiadaPengeluaran) {
            return redirect()->route('user.shuttle-3-formC.tiadaPengeluaran', [$bulan_id, $year]);
        }

        $kayu_id = '1';

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();


        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $user = auth()->user();

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
        // dd($formc);
        $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $request->baki_stoks[$keySpecies] ?? 0,
                    'kayu_masuk' => $request->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $request->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $request->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $request->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $request->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $request->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $request->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $request->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $request->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $request->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $request->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $request->jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {
                $data->baki_stok = $request->baki_stoks[$keySpecies] ?? 0;
                $data->kayu_masuk = $request->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $request->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $request->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $request->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $request->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $request->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $request->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $request->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $request->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $request->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $request->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $request->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }

        if ($request->sebelumnya == 1) {
            return redirect()->route('user.shuttle-3-senaraiC', $year);
        }

        return redirect()->route('user.view.shuttle-3-formC.KKS', [$bulan_id, $year])->with('success', 'Maklumat berjaya dimasukkan');
    }


    // KKS PAGE 2
    public function shuttle_3_formCKKS($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }

        $shuttle_id = auth()->user()->shuttle_id;
        if (!FormA::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->exists()) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu sebelum mengisi Borang C.');
        }
        $suku = (int) ceil($bulan_id / 3);
        if (!FormB::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('suku_tahun', $suku)->whereIn('status', FormFlowService::SUBMITTED)->exists()) {
            return redirect()->back()->with('error', "Sila isi Borang B Suku {$suku} terlebih dahulu sebelum mengisi Borang C.");
        }

        // Check registration date - user cannot fill months before registration
        $shuttle = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate)); // 1-12
        $registrationYear = date('Y', strtotime($registrationDate));
        
        $shuttle_type = auth()->user()->shuttle->shuttle_type;
        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        $kayu_id = '2';

        $species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();

        // Create Form C if it doesn't exist
        if (!$formc) {
            $formc = new ModelsFormC();
            $formc->shuttle_id = auth()->user()->shuttle_id;
            $formc->bulan = $bulan_id;
            $formc->tahun = $year;
            $formc->status = 'Tidak Diisi';
            $formc->created_at = $year . '-' . str_pad($bulan_id, 2, '0', STR_PAD_LEFT) . '-01';
            $formc->save();
        } elseif ($formc->status === 'Ditutup') {
            // Month has arrived — auto-open the form
            $formc->status = 'Tidak Diisi';
            $formc->save();
        }

        $currentYear = date('Y');
        $registrationDate = $kilang_info->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        
        // Get previous month data for carryforward (baki bulan lepas)
        // No validation needed here - validation is done at listing page level
        if ($bulan_id == 1) {
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', 12)
                ->where('tahun', $year - 1)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        } else {
            $lastmonth = $bulan_id - 1;
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->where('tahun', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        }

        if ($lastMonthformc) {
            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) use ($kayu_id) {
                    $q->where('kumpulan_kayu_id', $kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $lastMonthformc->id)
                ->get();
        } else {
            $kemasukan_bahans_lastmonth = collect();
        }

        $lastmonth_lookup = [];
        foreach ($kemasukan_bahans_lastmonth as $lm) {
            $lastmonth_lookup[$lm->getAttributes()['spesis_id']] = $lm;
        }
        if (!empty($lastmonth_lookup)) {
            $first_lm = reset($lastmonth_lookup);
            $this->jumlah_besar_baki_stok_bulan_lepas = $first_lm->jumlah_besar_baki_stok_bulan_depan ?? 0;
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);
        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $key => $value) {
                $lastmonth_data = $lastmonth_lookup[$value->id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_stok_kayu_balak[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                    $total_stok_kayu_balak[$key] = 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $jumlah_stok_kayu_balak[$key] = $baki_stok;
                $kayu_masuk[$key] = 0;
                $proses_masuk[$key] = 0;
                $proses_keluar[$key] = 0;
                $jumlah_kayu_masuk[$key] = 0;
                $total_kayu_masuk_jentera[$key] = 0;
                $total_kayu_keluar_jentera[$key] = 0;
                $baki_stok_kehadapan[$key] = $baki_stok;
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {
                $species_id = $data->getAttributes()['spesis_id'];
                $lastmonth_data = $lastmonth_lookup[$species_id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $kayu_masuk[$key] = $data->kayu_masuk;
                $jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $proses_masuk[$key] = $data->proses_masuk;
                $proses_keluar[$key] = $data->proses_keluar;

                $jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
            }
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 3C - KKB"],
            ];

            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 4C - KKB"],
            ];

            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 5C - KKB"],
            ];

            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'kilang_info' => $kilang_info,
            'bulan'       => $bulan,
            'bulan_id'       => $bulan_id,
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,

            'kumpulan_kayu' => $kumpulan_kayu,
            'species' => $species,
            'species_count' => $species_count,
            'min_recovery_rate' => $min_recovery_rate,
            'max_recovery_rate' => $max_recovery_rate,

            'baki_stoks' => $baki_stoks ?? 0,
            'kayu_masuk'     => $kayu_masuk,
            'jumlah_stok_kayu_balak'     => $jumlah_stok_kayu_balak ?? 0,
            'proses_masuk'     => $proses_masuk ?? 0,
            'proses_keluar'     => $proses_keluar ?? 0,
            'jumlah_baki_stok'     => $jumlah_baki_stok ?? 0,
            'jumlah_kayu_masuk'     => $jumlah_kayu_masuk ?? 0,
            'total_stok_kayu_balak'     => $total_stok_kayu_balak ?? 0,
            'total_kayu_masuk_jentera'     => $total_kayu_masuk_jentera ?? 0,
            'total_kayu_keluar_jentera'     => $total_kayu_keluar_jentera ?? 0,
            'total_kayu_dibawa_bulan_hadapan'     => $total_kayu_dibawa_bulan_hadapan ?? 0,
            'baki_stok_kehadapan'     => $baki_stok_kehadapan ?? 0,
            'jumlah_besar_kemasukan_kayu_ke_kilang'     => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
            'jumlah_besar_stok_kayu_balak'     => $jumlah_besar_stok_kayu_balak ?? 0,
            'jumlah_besar_kayu_ke_dalam_jentera'     => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera'     => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
            'jumlah_besar_baki_stok_bulan_depan'     => $jumlah_besar_baki_stok_bulan_depan ?? 0,
        ];

        // dd($returnArr);
        return view('admins.shuttle-three.FormC.shuttle-3-formC-KKS', $returnArr, compact('year'));
    }

    public function store_kks(Request $request, $bulan_id, $year = null)
    {
        if (!$year) {
            $year = date('Y');
        }
        
        \Log::info('KKS Store - bulan_id: ' . $bulan_id . ', year: ' . $year);
        $kayu_id = '2';

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();


        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $user = auth()->user();

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
        // dd($formc);
        $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $request->baki_stoks[$keySpecies] ?? 0,
                    'kayu_masuk' => $request->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $request->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $request->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $request->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $request->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $request->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $request->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $request->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $request->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $request->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $request->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $request->jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {
                $data->baki_stok = $request->baki_stoks[$keySpecies] ?? 0;
                $data->kayu_masuk = $request->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $request->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $request->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $request->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $request->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $request->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $request->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $request->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $request->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $request->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $request->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $request->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }
        // Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');

        if ($request->sebelumnya == 1) {
            return redirect()->route('user.view.shuttle-3-formC.KKB', [$bulan_id, $year]);
        }

        return redirect()->route('user.view.shuttle-3-formC.KKR', [$bulan_id, $year])->with('success', 'Maklumat berjaya dimasukkan');
    }


    // KKR PAGE 3
    public function shuttle_3_formCKKR($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }

        $shuttle_id = auth()->user()->shuttle_id;
        if (!FormA::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->exists()) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu sebelum mengisi Borang C.');
        }
        $suku = (int) ceil($bulan_id / 3);
        if (!FormB::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('suku_tahun', $suku)->whereIn('status', FormFlowService::SUBMITTED)->exists()) {
            return redirect()->back()->with('error', "Sila isi Borang B Suku {$suku} terlebih dahulu sebelum mengisi Borang C.");
        }

        // Check registration date - user cannot fill months before registration
        $shuttle = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate)); // 1-12
        $registrationYear = date('Y', strtotime($registrationDate));
        
        $shuttle_type = auth()->user()->shuttle->shuttle_type;
        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        $kayu_id = '3';

        $species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();

        // Create Form C if it doesn't exist
        if (!$formc) {
            $formc = new ModelsFormC();
            $formc->shuttle_id = auth()->user()->shuttle_id;
            $formc->bulan = $bulan_id;
            $formc->tahun = $year;
            $formc->status = 'Tidak Diisi';
            $formc->created_at = $year . '-' . str_pad($bulan_id, 2, '0', STR_PAD_LEFT) . '-01';
            $formc->save();
        } elseif ($formc->status === 'Ditutup') {
            // Month has arrived — auto-open the form
            $formc->status = 'Tidak Diisi';
            $formc->save();
        }

        $currentYear = date('Y');
        $registrationDate = $kilang_info->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        
        // Get previous month data for carryforward (baki bulan lepas)
        // No validation needed here - validation is done at listing page level
        if ($bulan_id == 1) {
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', 12)
                ->where('tahun', $year - 1)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        } else {
            $lastmonth = $bulan_id - 1;
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->where('tahun', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        }

        if ($lastMonthformc) {
            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) use ($kayu_id) {
                    $q->where('kumpulan_kayu_id', $kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $lastMonthformc->id)
                ->get();
        } else {
            $kemasukan_bahans_lastmonth = collect();
        }

        $lastmonth_lookup = [];
        foreach ($kemasukan_bahans_lastmonth as $lm) {
            $lastmonth_lookup[$lm->getAttributes()['spesis_id']] = $lm;
        }
        if (!empty($lastmonth_lookup)) {
            $first_lm = reset($lastmonth_lookup);
            $this->jumlah_besar_baki_stok_bulan_lepas = $first_lm->jumlah_besar_baki_stok_bulan_depan ?? 0;
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);
        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $key => $value) {
                $lastmonth_data = $lastmonth_lookup[$value->id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_stok_kayu_balak[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                    $total_stok_kayu_balak[$key] = 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $jumlah_stok_kayu_balak[$key] = $baki_stok;
                $kayu_masuk[$key] = 0;
                $proses_masuk[$key] = 0;
                $proses_keluar[$key] = 0;
                $jumlah_kayu_masuk[$key] = 0;
                $total_kayu_masuk_jentera[$key] = 0;
                $total_kayu_keluar_jentera[$key] = 0;
                $baki_stok_kehadapan[$key] = $baki_stok;
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {
                $species_id = $data->getAttributes()['spesis_id'];
                $lastmonth_data = $lastmonth_lookup[$species_id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $kayu_masuk[$key] = $data->kayu_masuk;
                $jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $proses_masuk[$key] = $data->proses_masuk;
                $proses_keluar[$key] = $data->proses_keluar;

                $jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
            }
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 3C - KKB"],
            ];

            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 4C - KKB"],
            ];

            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 5C - KKB"],
            ];

            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'kilang_info' => $kilang_info,
            'bulan'       => $bulan,
            'bulan_id'       => $bulan_id,
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,

            'kumpulan_kayu' => $kumpulan_kayu,
            'species' => $species,
            'species_count' => $species_count,
            'min_recovery_rate' => $min_recovery_rate,
            'max_recovery_rate' => $max_recovery_rate,

            'baki_stoks' => $baki_stoks ?? 0,
            'kayu_masuk'     => $kayu_masuk,
            'jumlah_stok_kayu_balak'     => $jumlah_stok_kayu_balak ?? 0,
            'proses_masuk'     => $proses_masuk ?? 0,
            'proses_keluar'     => $proses_keluar ?? 0,
            'jumlah_baki_stok'     => $jumlah_baki_stok ?? 0,
            'jumlah_kayu_masuk'     => $jumlah_kayu_masuk ?? 0,
            'total_stok_kayu_balak'     => $total_stok_kayu_balak ?? 0,
            'total_kayu_masuk_jentera'     => $total_kayu_masuk_jentera ?? 0,
            'total_kayu_keluar_jentera'     => $total_kayu_keluar_jentera ?? 0,
            'total_kayu_dibawa_bulan_hadapan'     => $total_kayu_dibawa_bulan_hadapan ?? 0,
            'baki_stok_kehadapan'     => $baki_stok_kehadapan ?? 0,
            'jumlah_besar_kemasukan_kayu_ke_kilang'     => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
            'jumlah_besar_stok_kayu_balak'     => $jumlah_besar_stok_kayu_balak ?? 0,
            'jumlah_besar_kayu_ke_dalam_jentera'     => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera'     => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
            'jumlah_besar_baki_stok_bulan_depan'     => $jumlah_besar_baki_stok_bulan_depan ?? 0,
        ];


        return view('admins.shuttle-three.FormC.shuttle-3-formC-KKR', $returnArr, compact('year'));
    }

    public function store_kkr(Request $request, $bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
        // dd($request->all());
        $kayu_id = '3';

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();


        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $user = auth()->user();

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
        // dd($formc);
        $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $request->baki_stoks[$keySpecies] ?? 0,
                    'kayu_masuk' => $request->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $request->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $request->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $request->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $request->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $request->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $request->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $request->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $request->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $request->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $request->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $request->jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {
                $data->baki_stok = $request->baki_stoks[$keySpecies] ?? 0;
                $data->kayu_masuk = $request->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $request->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $request->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $request->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $request->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $request->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $request->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $request->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $request->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $request->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $request->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $request->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }
        // Session::flash('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
        // dd($request->sebelumnya);
        \Log::info('KKR Store - sebelumnya value: ' . $request->sebelumnya);
        if ($request->sebelumnya == 1) {
            \Log::info('KKR Store - Redirecting to KKS');
            return redirect()->route('user.view.shuttle-3-formC.KKS', [$bulan_id, $year]);
        }

        \Log::info('KKR Store - Redirecting to KayuLembut');
        return redirect()->route('user.view.shuttle-3-formC.KayuLembut', [$bulan_id, $year])->with('success', 'Maklumat berjaya dimasukkan');
    }

    // KAYU LEMBUT PAGE 4
    public function shuttle_3_formCKayuLembut($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }

        $shuttle_id = auth()->user()->shuttle_id;
        if (!FormA::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->exists()) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu sebelum mengisi Borang C.');
        }
        $suku = (int) ceil($bulan_id / 3);
        if (!FormB::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('suku_tahun', $suku)->whereIn('status', FormFlowService::SUBMITTED)->exists()) {
            return redirect()->back()->with('error', "Sila isi Borang B Suku {$suku} terlebih dahulu sebelum mengisi Borang C.");
        }

        // Check registration date - user cannot fill months before registration
        $shuttle = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate)); // 1-12
        $registrationYear = date('Y', strtotime($registrationDate));
        
        $shuttle_type = auth()->user()->shuttle->shuttle_type;
        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        $kayu_id = '4';

        $species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();

        // Create Form C if it doesn't exist
        if (!$formc) {
            $formc = new ModelsFormC();
            $formc->shuttle_id = auth()->user()->shuttle_id;
            $formc->bulan = $bulan_id;
            $formc->tahun = $year;
            $formc->status = 'Tidak Diisi';
            $formc->created_at = $year . '-' . str_pad($bulan_id, 2, '0', STR_PAD_LEFT) . '-01';
            $formc->save();
        } elseif ($formc->status === 'Ditutup') {
            // Month has arrived — auto-open the form
            $formc->status = 'Tidak Diisi';
            $formc->save();
        }

        $currentYear = date('Y');
        $registrationDate = $kilang_info->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        
        // Get previous month data for carryforward (baki bulan lepas)
        // No validation needed here - validation is done at listing page level
        if ($bulan_id == 1) {
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', 12)
                ->where('tahun', $year - 1)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        } else {
            $lastmonth = $bulan_id - 1;
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->where('tahun', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        }

        if ($lastMonthformc) {
            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) use ($kayu_id) {
                    $q->where('kumpulan_kayu_id', $kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $lastMonthformc->id)
                ->get();
        } else {
            $kemasukan_bahans_lastmonth = collect();
        }

        $lastmonth_lookup = [];
        foreach ($kemasukan_bahans_lastmonth as $lm) {
            $lastmonth_lookup[$lm->getAttributes()['spesis_id']] = $lm;
        }
        if (!empty($lastmonth_lookup)) {
            $first_lm = reset($lastmonth_lookup);
            $this->jumlah_besar_baki_stok_bulan_lepas = $first_lm->jumlah_besar_baki_stok_bulan_depan ?? 0;
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        // dd($kemasukan_bahans);
        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $key => $value) {
                $lastmonth_data = $lastmonth_lookup[$value->id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_stok_kayu_balak[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                    $total_stok_kayu_balak[$key] = 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $jumlah_stok_kayu_balak[$key] = $baki_stok;
                $kayu_masuk[$key] = 0;
                $proses_masuk[$key] = 0;
                $proses_keluar[$key] = 0;
                $jumlah_kayu_masuk[$key] = 0;
                $total_kayu_masuk_jentera[$key] = 0;
                $total_kayu_keluar_jentera[$key] = 0;
                $baki_stok_kehadapan[$key] = $baki_stok;
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {
                $species_id = $data->getAttributes()['spesis_id'];
                $lastmonth_data = $lastmonth_lookup[$species_id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $kayu_masuk[$key] = $data->kayu_masuk;
                $jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $proses_masuk[$key] = $data->proses_masuk;
                $proses_keluar[$key] = $data->proses_keluar;

                $jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
            }
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 3C - KKB"],
            ];

            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 4C - KKB"],
            ];

            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 5C - KKB"],
            ];

            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'kilang_info' => $kilang_info,
            'bulan'       => $bulan,
            'bulan_id'       => $bulan_id,
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,

            'kumpulan_kayu' => $kumpulan_kayu,
            'species' => $species,
            'species_count' => $species_count,
            'min_recovery_rate' => $min_recovery_rate,
            'max_recovery_rate' => $max_recovery_rate,

            'baki_stoks' => $baki_stoks ?? 0,
            'kayu_masuk'     => $kayu_masuk,
            'jumlah_stok_kayu_balak'     => $jumlah_stok_kayu_balak ?? 0,
            'proses_masuk'     => $proses_masuk ?? 0,
            'proses_keluar'     => $proses_keluar ?? 0,
            'jumlah_baki_stok'     => $jumlah_baki_stok ?? 0,
            'jumlah_kayu_masuk'     => $jumlah_kayu_masuk ?? 0,
            'total_stok_kayu_balak'     => $total_stok_kayu_balak ?? 0,
            'total_kayu_masuk_jentera'     => $total_kayu_masuk_jentera ?? 0,
            'total_kayu_keluar_jentera'     => $total_kayu_keluar_jentera ?? 0,
            'total_kayu_dibawa_bulan_hadapan'     => $total_kayu_dibawa_bulan_hadapan ?? 0,
            'baki_stok_kehadapan'     => $baki_stok_kehadapan ?? 0,
            'jumlah_besar_kemasukan_kayu_ke_kilang'     => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
            'jumlah_besar_stok_kayu_balak'     => $jumlah_besar_stok_kayu_balak ?? 0,
            'jumlah_besar_kayu_ke_dalam_jentera'     => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera'     => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
            'jumlah_besar_baki_stok_bulan_depan'     => $jumlah_besar_baki_stok_bulan_depan ?? 0,
        ];


        return view('admins.shuttle-three.FormC.shuttle-3-formC-KayuLembut', $returnArr, compact('year'));
    }

    public function store_kayulembut(Request $request, $bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
        // dd('asdfasd');
        $kayu_id = '4';

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();


        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $user = auth()->user();

        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
        // dd($formc);
        $formc->status = 'Sedang Diisi';
        $formc->tiada_pengeluaran = 0;
        $formc->save();

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $request->baki_stoks[$keySpecies] ?? 0,
                    'kayu_masuk' => $request->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $request->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $request->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $request->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $request->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $request->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $request->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $request->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $request->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $request->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $request->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $request->jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {
                $data->baki_stok = $request->baki_stoks[$keySpecies] ?? 0;
                $data->kayu_masuk = $request->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $request->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $request->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $request->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $request->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $request->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $request->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $request->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $request->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $request->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $request->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $request->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }
        if ($request->sebelumnya == 1) {
            return redirect()->route('user.view.shuttle-3-formC.KKR', [$bulan_id, $year]);
        }

        return redirect()->route('user.view.shuttle-3-formC.LainLain', [$bulan_id, $year])->with('success', 'Maklumat berjaya dimasukkan');
    }

    // LAIN-LAIN PAGE 5
    public function shuttle_3_formCLainLain($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }

        $shuttle_id = auth()->user()->shuttle_id;
        if (!FormA::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('status', '!=', 'Tidak Diisi')->exists()) {
            return redirect()->back()->with('error', 'Sila isi Borang A terlebih dahulu sebelum mengisi Borang C.');
        }
        $suku = (int) ceil($bulan_id / 3);
        if (!FormB::where('shuttle_id', $shuttle_id)->where('tahun', $year)->where('suku_tahun', $suku)->whereIn('status', FormFlowService::SUBMITTED)->exists()) {
            return redirect()->back()->with('error', "Sila isi Borang B Suku {$suku} terlebih dahulu sebelum mengisi Borang C.");
        }

        // Check registration date - user cannot fill months before registration
        $shuttle = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $registrationDate = $shuttle->created_at;
        $registrationMonth = date('n', strtotime($registrationDate)); // 1-12
        $registrationYear = date('Y', strtotime($registrationDate));
        
        $shuttle_type = auth()->user()->shuttle->shuttle_type;
        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $min_recovery_rate = $recovery_rate->min_recovery_rate;
        $max_recovery_rate = $recovery_rate->max_recovery_rate;

        $kayu_id = '5';

        $species_count = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->count();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();
        $kumpulan_kayu = KumpulanKayu::where('id', $kayu_id)->get();

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        $formc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();

        // Create Form C if it doesn't exist
        if (!$formc) {
            $formc = new ModelsFormC();
            $formc->shuttle_id = auth()->user()->shuttle_id;
            $formc->bulan = $bulan_id;
            $formc->tahun = $year;
            $formc->status = 'Tidak Diisi';
            $formc->created_at = $year . '-' . str_pad($bulan_id, 2, '0', STR_PAD_LEFT) . '-01';
            $formc->save();
        } elseif ($formc->status === 'Ditutup') {
            // Month has arrived — auto-open the form
            $formc->status = 'Tidak Diisi';
            $formc->save();
        }

        $currentYear = date('Y');
        $registrationDate = $kilang_info->created_at;
        $registrationMonth = date('n', strtotime($registrationDate));
        $registrationYear = date('Y', strtotime($registrationDate));
        
        // Get previous month data for carryforward (baki bulan lepas)
        // No validation needed here - validation is done at listing page level
        if ($bulan_id == 1) {
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', 12)
                ->where('tahun', $year - 1)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        } else {
            $lastmonth = $bulan_id - 1;
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('bulan', $lastmonth)
                ->where('tahun', $year)
                ->where('status', '!=', 'Tidak Diisi')
                ->first();
        }

        if ($lastMonthformc) {
            $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                ->whereHas('spesis_id', function ($q) use ($kayu_id) {
                    $q->where('kumpulan_kayu_id', $kayu_id);
                })
                ->where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $lastMonthformc->id)
                ->get();
        } else {
            $kemasukan_bahans_lastmonth = collect();
        }

        $lastmonth_lookup = [];
        foreach ($kemasukan_bahans_lastmonth as $lm) {
            $lastmonth_lookup[$lm->getAttributes()['spesis_id']] = $lm;
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        $kemasukan_bahan_calc_kkb = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '1');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kks = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '2');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kkr = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '3');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_kayu_lembut = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '4');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $kemasukan_bahan_calc_lain_lain = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) {
            $q->where('kumpulan_kayu_id', '5');
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->first();

        $kkb = $kemasukan_bahan_calc_kkb->jumlah_baki_stok ?? 0;
        $kks = $kemasukan_bahan_calc_kks->jumlah_baki_stok ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->jumlah_baki_stok ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->jumlah_baki_stok ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->jumlah_baki_stok ?? 0;

        $besar_jumlah_baki_stok = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_jumlah_baki_stok_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        $kkb = $kemasukan_bahan_calc_kkb->jumlah_kayu_masuk ?? 0;
        $kks = $kemasukan_bahan_calc_kks->jumlah_kayu_masuk ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->jumlah_kayu_masuk ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->jumlah_kayu_masuk ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->jumlah_kayu_masuk ?? 0;

        $besar_jumlah_kayu_masuk = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_jumlah_kayu_masuk_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        $kkb = $kemasukan_bahan_calc_kkb->total_stok_kayu_balak ?? 0;
        $kks = $kemasukan_bahan_calc_kks->total_stok_kayu_balak ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->total_stok_kayu_balak ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->total_stok_kayu_balak ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->total_stok_kayu_balak ?? 0;

        $besar_total_stok_kayu_balak = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_total_stok_kayu_balak_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        $kkb = $kemasukan_bahan_calc_kkb->total_kayu_masuk_jentera ?? 0;
        $kks = $kemasukan_bahan_calc_kks->total_kayu_masuk_jentera ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->total_kayu_masuk_jentera ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->total_kayu_masuk_jentera ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->total_kayu_masuk_jentera ?? 0;

        $besar_total_kayu_masuk_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_total_kayu_masuk_jentera_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        $kkb = $kemasukan_bahan_calc_kkb->total_kayu_keluar_jentera ?? 0;
        $kks = $kemasukan_bahan_calc_kks->total_kayu_keluar_jentera ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->total_kayu_keluar_jentera ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->total_kayu_keluar_jentera ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->total_kayu_keluar_jentera ?? 0;

        $besar_total_kayu_keluar_jentera = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_total_kayu_keluar_jentera_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        $kkb = $kemasukan_bahan_calc_kkb->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kks = $kemasukan_bahan_calc_kks->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kkr = $kemasukan_bahan_calc_kkr->total_kayu_dibawa_bulan_hadapan ?? 0;
        $kayu_lembut = $kemasukan_bahan_calc_kayu_lembut->total_kayu_dibawa_bulan_hadapan ?? 0;
        $lain_lain = $kemasukan_bahan_calc_lain_lain->total_kayu_dibawa_bulan_hadapan ?? 0;

        $besar_total_kayu_dibawa_bulan_hadapan = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut  + (float)$lain_lain;
        $besar_total_kayu_dibawa_bulan_hadapan_tanpa_lain = (float)$kkb + (float)$kks + (float)$kkr + (float)$kayu_lembut; //for js calculation

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $key => $value) {
                $lastmonth_data = $lastmonth_lookup[$value->id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_besar_baki_stok_bulan_lepas = $lastmonth_data->jumlah_besar_baki_stok_bulan_depan ?? 0;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_stok_kayu_balak[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                    $total_stok_kayu_balak[$key] = 0;
                    $total_kayu_dibawa_bulan_hadapan[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $jumlah_stok_kayu_balak[$key] = $baki_stok;
                $kayu_masuk[$key] = 0;
                $proses_masuk[$key] = 0;
                $proses_keluar[$key] = 0;
                $jumlah_kayu_masuk[$key] = 0;
                $total_kayu_masuk_jentera[$key] = 0;
                $total_kayu_keluar_jentera[$key] = 0;
                $baki_stok_kehadapan[$key] = $baki_stok;
            }
        } else {
            foreach ($kemasukan_bahans as $key => $data) {
                $species_id = $data->getAttributes()['spesis_id'];
                $lastmonth_data = $lastmonth_lookup[$species_id] ?? null;
                if ($lastmonth_data) {
                    $baki_stok = $lastmonth_data->baki_stok_kehadapan;
                    $jumlah_baki_stok[$key] = $lastmonth_data->total_kayu_dibawa_bulan_hadapan ?? 0;
                } else {
                    $baki_stok = 0;
                    $jumlah_baki_stok[$key] = 0;
                }
                $baki_stoks[$key] = $baki_stok;
                $kayu_masuk[$key] = $data->kayu_masuk;
                $jumlah_stok_kayu_balak[$key] = $data->jumlah_stok_kayu_balak;
                $proses_masuk[$key] = $data->proses_masuk;
                $proses_keluar[$key] = $data->proses_keluar;

                $jumlah_kayu_masuk[$key] = $data->jumlah_kayu_masuk;
                $total_stok_kayu_balak[$key] = $data->total_stok_kayu_balak;
                $total_kayu_masuk_jentera[$key] = $data->total_kayu_masuk_jentera;
                $total_kayu_keluar_jentera[$key] = $data->total_kayu_keluar_jentera;
                $total_kayu_dibawa_bulan_hadapan[$key] = $data->total_kayu_dibawa_bulan_hadapan;
                $baki_stok_kehadapan[$key] = $data->baki_stok_kehadapan;

                $jumlah_besar_kemasukan_kayu_ke_kilang = $data->jumlah_besar_kemasukan_kayu_ke_kilang;
                $jumlah_besar_stok_kayu_balak = $data->jumlah_besar_stok_kayu_balak;
                $jumlah_besar_kayu_ke_dalam_jentera = $data->jumlah_besar_kayu_ke_dalam_jentera;
                $jumlah_besar_pengeluaran_kayu_daripada_jentera = $data->jumlah_besar_pengeluaran_kayu_daripada_jentera;
                $jumlah_besar_baki_stok_bulan_depan = $data->jumlah_besar_baki_stok_bulan_depan;
            }
        }

        if (!$kemasukan_bahan_calc_lain_lain) { // first time masuk page lain-lain
            foreach ($jumlah_baki_stok as $value) {
                $besar_jumlah_baki_stok += (float)$value ?? 0;
            }
            foreach ($jumlah_kayu_masuk as $value) {
                $besar_jumlah_kayu_masuk += (float)$value;
            }
            foreach ($total_stok_kayu_balak as $value) {
                $besar_total_stok_kayu_balak += (float)$value;
            }
            foreach ($total_kayu_masuk_jentera as $value) {
                $besar_total_kayu_masuk_jentera += (float)$value;
            }
            foreach ($total_kayu_keluar_jentera as $value) {
                $besar_total_kayu_keluar_jentera += (float)$value;
            }
            foreach ($total_kayu_dibawa_bulan_hadapan as $value) {
                $besar_total_kayu_dibawa_bulan_hadapan += (float)$value;
            }
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }

        $kilang_info = Shuttle::where('id', auth()->user()->shuttle_id)->first();
        if ($kilang_info->shuttle_type == '3') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-3-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 3C - KKB"],
            ];

            $kembali = route('user.shuttle-3-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '4') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-4-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 4C - KKB"],
            ];

            $kembali = route('user.shuttle-4-senaraiC', date('Y'));
        } elseif ($kilang_info->shuttle_type == '5') {
            $breadcrumbs    = [
                ['link' => route('home-user'), 'name' => "Laman Utama"],
                ['link' => route('user.shuttle-5-senaraiC', date('Y')), 'name' => "Kemasukan Maklumat"],
                ['link' => '#', 'name' => "Borang 5C - KKB"],
            ];

            $kembali = route('user.shuttle-5-senaraiC', date('Y'));
        }

        $returnArr = [
            'kilang_info' => $kilang_info,
            'bulan'       => $bulan,
            'bulan_id'       => $bulan_id,
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,

            'kumpulan_kayu' => $kumpulan_kayu,
            'species' => $species,
            'species_count' => $species_count,
            'min_recovery_rate' => $min_recovery_rate,
            'max_recovery_rate' => $max_recovery_rate,

            'baki_stoks' => $baki_stoks ?? 0,
            'kayu_masuk'     => $kayu_masuk,
            'jumlah_stok_kayu_balak'     => $jumlah_stok_kayu_balak ?? 0,
            'proses_masuk'     => $proses_masuk ?? 0,
            'proses_keluar'     => $proses_keluar ?? 0,
            'jumlah_baki_stok'     => $jumlah_baki_stok ?? array(),
            'jumlah_kayu_masuk'     => $jumlah_kayu_masuk ?? 0,
            'total_stok_kayu_balak'     => $total_stok_kayu_balak ?? 0,
            'total_kayu_masuk_jentera'     => $total_kayu_masuk_jentera ?? 0,
            'total_kayu_keluar_jentera'     => $total_kayu_keluar_jentera ?? 0,
            'total_kayu_dibawa_bulan_hadapan'     => $total_kayu_dibawa_bulan_hadapan ?? 0,
            'baki_stok_kehadapan'     => $baki_stok_kehadapan ?? 0,

            'jumlah_besar_kemasukan_kayu_ke_kilang'     => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
            'jumlah_besar_stok_kayu_balak'     => $jumlah_besar_stok_kayu_balak ?? 0,
            'jumlah_besar_kayu_ke_dalam_jentera'     => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
            'jumlah_besar_pengeluaran_kayu_daripada_jentera'     => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
            'jumlah_besar_baki_stok_bulan_depan'     => $jumlah_besar_baki_stok_bulan_depan ?? 0,

            'besar_jumlah_baki_stok'     => $besar_jumlah_baki_stok ?? 0,
            'besar_jumlah_kayu_masuk'     => $besar_jumlah_kayu_masuk ?? 0,
            'besar_total_stok_kayu_balak'     => $besar_total_stok_kayu_balak ?? 0,
            'besar_total_kayu_masuk_jentera'     => $besar_total_kayu_masuk_jentera ?? 0,
            'besar_total_kayu_keluar_jentera'   => $besar_total_kayu_keluar_jentera ?? 0,
            'besar_total_kayu_dibawa_bulan_hadapan'     => $besar_total_kayu_dibawa_bulan_hadapan ?? 0,

            'besar_jumlah_baki_stok_tanpa_lain'     => $besar_jumlah_baki_stok_tanpa_lain ?? 0,
            'besar_jumlah_kayu_masuk_tanpa_lain'     => $besar_jumlah_kayu_masuk_tanpa_lain ?? 0,
            'besar_total_stok_kayu_balak_tanpa_lain'     => $besar_total_stok_kayu_balak_tanpa_lain ?? 0,
            'besar_total_kayu_masuk_jentera_tanpa_lain'     => $besar_total_kayu_masuk_jentera_tanpa_lain ?? 0,
            'besar_total_kayu_keluar_jentera_tanpa_lain'    => $besar_total_kayu_keluar_jentera_tanpa_lain ?? 0,
            'besar_total_kayu_dibawa_bulan_hadapan_tanpa_lain'     => $besar_total_kayu_dibawa_bulan_hadapan_tanpa_lain ?? 0,
        ];
        //  dd($besar_total_kayu_dibawa_bulan_hadapan_tanpa_lain);
        return view('admins.shuttle-three.FormC.shuttle-3-formC-LainLain', $returnArr, compact('year'));
    }

    public function store_kayulainlain(Request $request, $bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
        // if ($request->tiadaPengeluaran) {
        //     return redirect()->route('user.shuttle-3-formC.tiadaPengeluaran', $bulan_id);
        // }
        // dd($request->total_kayu_dibawa_bulan_hadapan);

        $kayu_id = '5';

        $shuttle_type = auth()->user()->shuttle->shuttle_type;

        $recovery_rate = RecoveryRate::where('shuttle_type', $shuttle_type)->first();
        $species = Spesis::orderBy('kumpulan_kayu_id')->where('kumpulan_kayu_id', $kayu_id)->get();

        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();


        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }


        $user = auth()->user();

        if ($request->sebelumnya != 1) {
            if ($request->tiadaPengeluaran) {
                $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
                $formc->status = 'Tiada Pengeluaran';
                $formc->tiada_pengeluaran = 1;
                // $formc->status = 'Sedang Diisi';
                $formc->save();
            } else {
                $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
                $formc->status = 'Sedang Diproses';
                $formc->tiada_pengeluaran = 0;
                $formc->save();
            }

            $batch = Batch::where('tahun', $formc->tahun)->where('bulan', $formc->bulan)->where('shuttle_id', $formc->shuttle->id)->first();

            $batch->status = "Sedang Diproses";
            $batch->borang_c = 1;
            $batch->save();
        } else {
            $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)->where('bulan', $bulan_id)->where('tahun', $year)->first();
            $formc->status = 'Sedang Diisi';
            $formc->tiada_pengeluaran = 0;
            $formc->save();
        }


        $kemasukan_bahans = KemasukanBahan::with('spesis_id')->whereHas('spesis_id', function ($q) use ($kayu_id) {
            $q->where('kumpulan_kayu_id', $kayu_id);
        })->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $formc->id)->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $request->baki_stoks[$keySpecies] ?? 0,
                    'kayu_masuk' => $request->kayu_masuk[$keySpecies] ?? 0,
                    'jumlah_stok_kayu_balak' => $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0,
                    'proses_masuk' => $request->proses_masuk[$keySpecies] ?? 0,
                    'proses_keluar' => $request->proses_keluar[$keySpecies] ?? 0,
                    'baki_stok_kehadapan' => $request->baki_stok_kehadapan[$keySpecies] ?? 0,


                    'jumlah_baki_stok' => $request->jumlah_baki_stok[$keySpecies] ?? 0,
                    'jumlah_kayu_masuk' => $request->jumlah_kayu_masuk[$keySpecies] ?? 0,
                    'total_stok_kayu_balak' => $request->total_stok_kayu_balak[$keySpecies] ?? 0,
                    'total_kayu_masuk_jentera' => $request->total_kayu_masuk_jentera[$keySpecies] ?? 0,
                    'total_kayu_keluar_jentera' => $request->total_kayu_keluar_jentera[$keySpecies] ?? 0,
                    'total_kayu_dibawa_bulan_hadapan' => $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0,

                    'jumlah_besar_baki_stok_bulan_lepas' => $request->jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $request->jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $request->jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,
                ]);
            }
        } else {
            foreach ($kemasukan_bahans as $keySpecies => $data) {
                $data->baki_stok = $request->baki_stoks[$keySpecies] ?? 0;
                $data->kayu_masuk = $request->kayu_masuk[$keySpecies] ?? 0;
                $data->jumlah_stok_kayu_balak = $request->jumlah_stok_kayu_balak[$keySpecies] ?? 0;
                $data->proses_masuk = $request->proses_masuk[$keySpecies] ?? 0;
                $data->proses_keluar = $request->proses_keluar[$keySpecies] ?? 0;
                $data->baki_stok_kehadapan = $request->baki_stok_kehadapan[$keySpecies] ?? 0;

                $data->jumlah_baki_stok = $request->jumlah_baki_stok[$keySpecies] ?? 0;
                $data->jumlah_kayu_masuk = $request->jumlah_kayu_masuk[$keySpecies] ?? 0;
                $data->total_stok_kayu_balak = $request->total_stok_kayu_balak[$keySpecies] ?? 0;
                $data->total_kayu_masuk_jentera = $request->total_kayu_masuk_jentera[$keySpecies] ?? 0;
                $data->total_kayu_keluar_jentera = $request->total_kayu_keluar_jentera[$keySpecies] ?? 0;
                $data->total_kayu_dibawa_bulan_hadapan = $request->total_kayu_dibawa_bulan_hadapan[$keySpecies] ?? 0;

                $data->jumlah_besar_baki_stok_bulan_lepas = $request->jumlah_besar_baki_stok_bulan_lepas ?? 0;
                $data->jumlah_besar_kemasukan_kayu_ke_kilang = $request->jumlah_besar_kemasukan_kayu_ke_kilang ?? 0;
                $data->jumlah_besar_stok_kayu_balak = $request->jumlah_besar_stok_kayu_balak ?? 0;
                $data->jumlah_besar_kayu_ke_dalam_jentera = $request->jumlah_besar_kayu_ke_dalam_jentera ?? 0;
                $data->jumlah_besar_pengeluaran_kayu_daripada_jentera = $request->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0;
                $data->jumlah_besar_baki_stok_bulan_depan = $request->jumlah_besar_baki_stok_bulan_depan ?? 0;

                $data->save();
            }
        }

        if ($request->sebelumnya == 1) {
            return redirect()->route('user.view.shuttle-3-formC.KayuLembut', [$bulan_id, $year]);
        }

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where(
            'kategori_pengguna',
            'PHD'
        )->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formc))->delay($delay));
        }

        return redirect()->route('home-user')->with('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
    }

    public function tiadaPengeluaran($bulan_id, $year = null)
    {
        // Default to current year if not provided
        if (!$year) {
            $year = date('Y');
        }
        
        // dd($bulan_id);
        $id = auth()->user();
        $kilang_info = Shuttle::where('id', $id->shuttle_id)->first();

        $status = 'Sedang Diproses';
        $shuttle_id = Shuttle::where('id', $id->shuttle_id)->first();

        if ($bulan_id != 1) {
            $lastmonth = $bulan_id - 1; //create
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $lastmonth)->where('tahun', $year)->first();

            if ($lastMonthformc) {
                $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                    ->whereHas('spesis_id', function ($q) {
                        $q->where('kumpulan_kayu_id', '5');
                    })
                    ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->first();
            }
        }

        if (isset($kemasukan_bahans_lastmonth)) {
            $jumlah_besar_baki_stok_bulan_lepas = $kemasukan_bahans_lastmonth->jumlah_besar_baki_stok_bulan_depan;
            $jumlah_besar_kemasukan_kayu_ke_kilang = $kemasukan_bahans_lastmonth->jumlah_besar_kemasukan_kayu_ke_kilang;
            $jumlah_besar_stok_kayu_balak = $kemasukan_bahans_lastmonth->jumlah_besar_stok_kayu_balak;
            $jumlah_besar_kayu_ke_dalam_jentera = $kemasukan_bahans_lastmonth->jumlah_besar_kayu_ke_dalam_jentera;
            $jumlah_besar_pengeluaran_kayu_daripada_jentera = $kemasukan_bahans_lastmonth->jumlah_besar_pengeluaran_kayu_daripada_jentera;
            $jumlah_besar_baki_stok_bulan_depan = $kemasukan_bahans_lastmonth->jumlah_besar_baki_stok_bulan_depan;
        } else {
            $jumlah_besar_baki_stok_bulan_lepas = 0;
            $jumlah_besar_kemasukan_kayu_ke_kilang = 0;
            $jumlah_besar_stok_kayu_balak = 0;
            $jumlah_besar_kayu_ke_dalam_jentera = 0;
            $jumlah_besar_pengeluaran_kayu_daripada_jentera = 0;
            $jumlah_besar_baki_stok_bulan_depan = 0;
        }

        if ($bulan_id ==  '1') {
            $bulan = "Januari";
        } else if ($bulan_id ==  '2') {
            $bulan = "Februari";
        } else if ($bulan_id ==  '3') {
            $bulan = "Mac";
        } else if ($bulan_id ==  '4') {
            $bulan = "April";
        } else if ($bulan_id ==  '5') {
            $bulan = "Mei";
        } else if ($bulan_id ==  '6') {
            $bulan = "Jun";
        } else if ($bulan_id ==  '7') {
            $bulan = "Julai";
        } else if ($bulan_id ==  '8') {
            $bulan = "Ogos";
        } else if ($bulan_id ==  '9') {
            $bulan = "September";
        } else if ($bulan_id ==  '10') {
            $bulan = "Oktober";
        } else if ($bulan_id ==  '11') {
            $bulan = "November";
        } else if ($bulan_id ==  '12') {
            $bulan = "Disember";
        }


        $user = auth()->user();
        $formc = ModelsFormC::where('shuttle_id', $user->shuttle_id)
            ->where('bulan', $bulan_id)
            ->where('tahun', $year)
            ->first();

        // Check if there is any pengeluaran value in any KemasukanBahan for this form
        $pengeluaranExists = KemasukanBahan::where('shuttle_id', $user->shuttle_id)
            ->where('formcs_id', $formc->id)
            ->where(function($q) {
                $q->where('proses_keluar', '>', 0)
                  ->orWhere('jumlah_besar_pengeluaran_kayu_daripada_jentera', '>', 0);
                  // Add other relevant fields if needed
            })
            ->exists();

        if ($pengeluaranExists) {
            return redirect()->back()->with('error', 'Tidak boleh set Tiada Pengeluaran kerana ada data pengeluaran pada spesies lain.');
        }

        $status_terkini = $formc->status;
        $formc->status = 'Tiada Pengeluaran';
        $formc->tiada_pengeluaran = 1;
        $formc->save();

        $batch = Batch::where('tahun', $formc->tahun)
            ->where('shuttle_id', $formc->shuttle->id)
            ->where('bulan', $formc->bulan)
            ->first();

        $batch->status = "Sedang Diproses";
        $batch->borang_c = 1;
        $batch->save();

        if ($status_terkini == 'Sedang Diisi') {
            // Delete existing records before creating new ones with Tiada Pengeluaran
            KemasukanBahan::where('shuttle_id', auth()->user()->shuttle_id)
                ->where('formcs_id', $formc->id)
                ->delete();
        }

        $kemasukan_bahans = KemasukanBahan::with('spesis_id')
            ->where('shuttle_id', auth()->user()->shuttle_id)
            ->where('formcs_id', $formc->id)
            ->get();

        if ($bulan_id != 1) {
            $lastmonth = $bulan_id - 1; //create
            $lastMonthformc = ModelsFormC::where('shuttle_id', auth()->user()->shuttle_id)->where('bulan', $lastmonth)->where('tahun', $year)->first();

            if ($lastMonthformc) {
                $kemasukan_bahans_lastmonth = KemasukanBahan::with('spesis_id')
                    ->where('shuttle_id', auth()->user()->shuttle_id)->where('formcs_id', $lastMonthformc->id)->get();
            }
        }

        // dd($kemasukan_bahans_lastmonth);

        $species = Spesis::orderBy('kumpulan_kayu_id')->orderBy('id')->get();

        if ($kemasukan_bahans->isEmpty()) {
            foreach ($species as $keySpecies => $data) {
                $baki_stok = 0;
                $jumlah_baki_stok = 0;
                if (!isset($kemasukan_bahans_lastmonth)) {
                    $baki_stok = 0;
                    $jumlah_baki_stok = 0;
                } else {
                    foreach ($kemasukan_bahans_lastmonth as $key2 => $data2) {
                        // dd($data2);
                        $baki_stok = $data2->baki_stok_kehadapan;
                        // $jumlah_besar_baki_stok_bulan_lepas = $data2->jumlah_besar_baki_stok_bulan_depan;
                        $jumlah_baki_stok = $data2->total_kayu_dibawa_bulan_hadapan;
                        // dd($data2);
                        if ($key2 == $keySpecies)
                            break;
                    }
                }

                KemasukanBahan::create([
                    'spesis_id' => $data->id,
                    'baki_stok' => $baki_stok ?? 0,
                    'kayu_masuk' => 0,
                    'jumlah_stok_kayu_balak' => $baki_stok ?? 0, // baki_stok + kayu_masuk (0)
                    'proses_masuk' => 0,
                    'proses_keluar' => 0,
                    'baki_stok_kehadapan' => $baki_stok ?? 0,

                    'jumlah_baki_stok' => $jumlah_baki_stok ?? 0,
                    'jumlah_kayu_masuk' => 0,
                    'total_stok_kayu_balak' => $jumlah_baki_stok ?? 0, // jumlah_baki_stok + jumlah_kayu_masuk (0)
                    'total_kayu_masuk_jentera' =>  0,
                    'total_kayu_keluar_jentera' => 0,
                    'total_kayu_dibawa_bulan_hadapan' =>  $jumlah_baki_stok ?? 0, // Should equal jumlah_baki_stok when no processing

                    'jumlah_besar_baki_stok_bulan_lepas' => $jumlah_besar_baki_stok_bulan_lepas ?? 0,
                    'jumlah_besar_kemasukan_kayu_ke_kilang' => $jumlah_besar_kemasukan_kayu_ke_kilang ?? 0,
                    'jumlah_besar_stok_kayu_balak' => $jumlah_besar_stok_kayu_balak ?? 0,
                    'jumlah_besar_kayu_ke_dalam_jentera' => $jumlah_besar_kayu_ke_dalam_jentera ?? 0,
                    'jumlah_besar_pengeluaran_kayu_daripada_jentera' => $jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 0,
                    'jumlah_besar_baki_stok_bulan_depan' => $jumlah_besar_baki_stok_bulan_depan ?? 0,

                    'shuttle_id' => $shuttle_id->id,
                    'kategori_guna_tenaga_id' => $data->id,
                    'bulan' => $bulan_id,
                    'tahun' => $year,
                    'formcs_id' => $formc->id,

                ]);
            }
        }

        //notification hantar borang IBK to PHD
        $pengguna_kilang = auth()->user();
        $daerah_id = $pengguna_kilang->shuttle()->first('daerah_id');

        $pegawais = User::where('daerah', $daerah_id->daerah_id)->where(
            'kategori_pengguna',
            'PHD'
        )->get();

        $delay = now()->addMinutes(1);

        foreach ($pegawais as $pegawai) {
            $pegawai->notify((new BorangDiHantar($pengguna_kilang, $pegawai, $formc))->delay($delay));
        }

        return redirect()->route('home-user')->with('success', 'Maklumat berjaya dimasukkan. Sila tunggu untuk pengesahan PHD.');
    }
}
