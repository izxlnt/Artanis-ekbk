<?php

namespace App\Http\Controllers\ShuttleThree;

use App\Http\Controllers\Controller;
use App\Mail\JPN\BorangTidakDiambilTindakanMail;
use App\Mail\PHD\BorangTidakDiisiMail;
use App\Models\Batch;
use App\Models\Buffer;
use App\Models\Daerah;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\Shuttle;
use App\Models\User;
use App\Notifications\JPN\BorangTidakDiambilTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ListAController extends Controller
{
    public function shuttle_3_listA_phd($year)
    {
        $user = auth()->user();

        // Get FormA entries that are waiting for PHD validation
        $formA = FormA::whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
            })->where('tahun', $year)
            ->whereIn('status', ['Dihantar ke IPJPSM', 'Sedang Diproses'])
            ->get();

        // Temporary debug: Let's see what statuses exist
        $allFormA = FormA::whereHas('shuttle', function ($q) {
                $q->whereIn('daerah_id', auth()->user()->daerah_ids)->where('shuttle_type', '3');
            })->where('tahun', $year)->get();
        
        \Log::info('All FormA statuses for PHD area: ' . $allFormA->pluck('status')->unique()->implode(', '));
        \Log::info('Filtered FormA count: ' . $formA->count());
        if($formA->count() > 0) {
            \Log::info('Showing FormA with statuses: ' . $formA->pluck('status')->unique()->implode(', '));
        }


        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->whereIn('daerah_id', auth()->user()->daerah_ids);
        })->distinct()->pluck('tahun')->unique()->sort()->values();
        $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();

        $breadcrumbs    = [
            ['link' => route('home-phd'), 'name' => "Laman Utama"],
            ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Pengesahan Borang"],
            ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('phd.shuttle-3-listA', date('Y')), 'name' => "Senarai Borang 3A"],
        ];

        $kembali = route('home-phd');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.shuttle-three.shuttle-3-listA', compact(
            'user',
            'formA',
            // 'formB_kilang',
            'year_list',
            'year',
            'buffer',
            'returnArr'
        ));
    }

    public function shuttle_3_listA_jpn($year)
    {
        $user = auth()->user();

        // $formB_kilang = FormB::select('shuttle_id')->distinct()->where('tahun', $year)->get();


        // $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        // $list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', $year)->first();

        // $year_list = FormA::where('shuttle_id', $shuttle->id)->where('tahun', '>=', config('app.data_start_year'))->distinct()->orderBy('tahun')->get('tahun');

        $formA_kilang = FormA::select('shuttle_id')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
            })
            ->distinct()->where('tahun', $year)->get();

        $formA = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
        })->where('tahun', $year)
        ->whereNotIn('status', ['Lulus', 'Tidak Diisi'])
        ->get();

        // dd($formA);

        $year_list = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('tahun', '>=', config('app.data_start_year'))->distinct()->orderBy('tahun')->get('tahun');

        // $formA = FormA::where('status', '!=', 'Tidak Diisi')
        //     ->whereHas('shuttle', function ($q) {
        //         $q->where('negeri_id', auth()->user()->negeri)->where('shuttle_type', '3');
        //     })->where('tahun', $year)->get();

        $buffer = Buffer::where('borang', 'b')->where('shuttle', '3')->first();
        // dd($formA);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Status Borang"],
            ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Shuttle 3 - Kilang Papan"],
            ['link' => route('jpn.shuttle-3-listA-jpn', date('Y')), 'name' => "Borang 3A"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.shuttle-three.shuttle-3-listA-jpn', compact(
            'user',
            'formA',
            // 'formB_kilang',
            'year_list',
            'year',
            'buffer',
            'formA_kilang',
            'returnArr'
        ));
    }

    public function notifikasi_peringatan(Request $request){

        $daerah_list = Daerah::where('negeri', auth()->user()->negeri)->distinct()->get('daerah_hutan');

        $form_a = FormA::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_b = FormB::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_c = FormC::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->whereIn('status', ['Sedang Diproses', 'Tiada Pengeluaran'])->get();

        // Shuttle type 3's own Form D model — previously never queried here at
        // all, so a shuttle-3 mill's pending Form D backlog was invisible to
        // this reminder from any angle (only Form4D/Form5D were checked).
        $form_d = FormD::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_4d = Form4D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_4e = Form4E::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_5d = Form5D::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        $form_5e = Form5E::whereHas('shuttle', function ($q) {
            $q->where('negeri_id', auth()->user()->negeri);
        })->where('status', 'Sedang Diproses')->get();

        // Batches where PHD has already resolved every submitted form (nothing left
        // awaiting a first look) but never sent the package on to IPJPSM. The form_*
        // queries above only catch "PHD hasn't verified yet" — this catches "PHD
        // verified everything but forgot to click Hantar Pakej", which otherwise
        // shows 0 here even though IPJPSM still has nothing for that month.
        $batches_belum_hantar = Batch::where('status', 'Sedang Diproses')
            ->whereHas('shuttle', function ($q) {
                $q->where('negeri_id', auth()->user()->negeri);
            })
            ->with('shuttle')
            ->get()
            ->filter(function ($batch) {
                $fields = ['borang_a', 'borang_b', 'borang_c', 'borang_d'];
                if ((int) $batch->shuttle->shuttle_type !== 3) {
                    $fields[] = 'borang_e';
                }

                $hasApproved = false;
                foreach ($fields as $field) {
                    $value = (int) $batch->$field;
                    if ($value === 1) {
                        return false; // still awaiting PHD's first look, already counted above
                    }
                    if ($value === 2) {
                        $hasApproved = true;
                    }
                }

                return $hasApproved; // approved and ready, but package itself was never sent
            });

        // dd($daerah_list);


        $breadcrumbs    = [
            ['link' => route('home-user'), 'name' => "Laman Utama"],
            ['link' => route('jpn.notifikasi.list', date('Y')), 'name' => "Pemantauan Maklumat"],
            ['link' => route('jpn.notifikasi.list', date('Y')), 'name' => "Notifikasi Peringatan"],

        ];

        $kembali = route('home-user');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];


        return view('notifikasiPHD.phd_list', compact(
            'daerah_list',
            'form_a',
            'form_b',
            'form_c',
            'form_d',
            'form_4d',
            'form_4e',
            'form_5d',
            'form_5e',
            'batches_belum_hantar',
            'returnArr',

        ));
    }

    public function send_email(Request $request){

        $pegawai_list = User::where('kategori_pengguna', 'PHD')->where('daerah', $request->daerah_hutan)->get();

        foreach($pegawai_list as $pegawai){
            $pegawai->notify(new BorangTidakDiambilTindakan($pegawai));
        }


        return redirect()->back()->with('success', 'Email telah dihantar kepada Pejabat Hutan Daerah');
    }
}
