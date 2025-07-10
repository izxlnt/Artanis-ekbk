<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\PengumumanIpjpsm;
use App\Models\PengumumanJpn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PengumumanController extends Controller
{
    public function pengumuman()
    {
        $user = auth()->user();
        // dd($user);
        $pengumuman = pengumuman::where('daerah_hutan',$user->daerah)->get();

        // dd($pengumuman);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman', compact('returnArr','pengumuman'));
    }

    public function pengumuman_jpn()
    {
        $user = auth()->user();
        // dd($user);
        $pengumuman = PengumumanJpn::where('negeri',$user->negeri)->get();

        // dd($pengumuman);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-jpn', compact('returnArr','pengumuman'));
    }

    public function pengumuman_ipjpsm()
    {
        $user = auth()->user();
        // dd($user);
        $pengumuman = PengumumanIpjpsm::get();

        // dd($pengumuman);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengesahan Maklumat"],
            ['link' => route('phd.pengumuman', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-ipjpsm', compact('returnArr','pengumuman'));
    }

    public function pengumuman_tambah()
    {

        // $daerah = Daerah::get();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-tambah', compact('returnArr'));
    }

    public function pengumuman_tambah_jpn()
    {

        // $daerah = Daerah::get();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-tambah-jpn', compact('returnArr'));
    }

    public function pengumuman_tambah_ipjpsm()
    {

        // $daerah = Daerah::get();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-tambah-ipjpsm', compact('returnArr'));
    }

    protected function validator(array $data)
    {

            return Validator::make($data, [
                'tajuk' => ['required', 'string'],
                'keterangan' => ['required', 'string'],
            ]);



    }


    public function pengumuman_add(Request $request)
    {

        $id = auth()->user();
        // dd($id);
        $this->validator($request->all())->validate();


        Pengumuman::create([
            'tajuk'=> $request->tajuk,
            'keterangan'=> $request->keterangan,
            'daerah_hutan'=> $id->daerah,


        ]);

        // dd('masuk');
		return redirect('phd/pengumuman')->with('success','Maklumat Anda Telah Berjaya Ditambah.');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Tambah Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.pengumuman.pengumuman-tambah', compact('returnArr'));
    }

    public function pengumuman_add_jpn(Request $request)
    {

        $id = auth()->user();
        // dd($id->negeri);
        // dd($request->all());

        $this->validator($request->all())->validate();

        PengumumanJpn::create([
            'tajuk'=> $request->tajuk,
            'keterangan'=> $request->keterangan,
            'negeri'=> $id->negeri,


        ]);

        // dd('masuk');
		return redirect('jpn/pengumuman-jpn')->with('success','Maklumat Anda Telah Berjaya Ditambah.');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Tambah Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.pengumuman.pengumuman-tambah-jpn', compact('returnArr'));
    }

    public function pengumuman_add_ipjpsm(Request $request)
    {

        $id = auth()->user();
        // dd($id);
        // dd($request->all());

        $this->validator($request->all())->validate();

        PengumumanIpjpsm::create([
            'tajuk'=> $request->tajuk,
            'keterangan'=> $request->keterangan,
            'negeri'=> $request->negeri,


        ]);

        // dd('masuk');
		return redirect('admin/pengumuman-ipjpsm')->with('success','Maklumat Anda Telah Berjaya Ditambah.');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
            ['link' => route('daerah', date('Y')), 'name' => "Tambah Pengumuman"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.pengumuman.pengumuman-tambah-ipjpsm', compact('returnArr'));
    }

    public function pengumuman_kemaskini($id)
    {
        // dd($id);
        $pengumuman = Pengumuman::where('id',$id)->first();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman "],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
        ];

        $kembali = route('daerah');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-edit', compact('returnArr','pengumuman'));
    }

    public function pengumuman_kemaskini_jpn($id)
    {
        // dd($id);
        $pengumuman = PengumumanJpn::where('id',$id)->first();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman "],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
        ];

        $kembali = route('daerah');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-edit-jpn', compact('returnArr','pengumuman'));
    }

    public function pengumuman_kemaskini_ipjpsm($id)
    {
        // dd($id);
        $pengumuman = PengumumanIpjpsm::where('id',$id)->first();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman "],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Pengumuman"],
        ];

        $kembali = route('daerah');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.pengumuman.pengumuman-edit-ipjpsm', compact('returnArr','pengumuman'));
    }

    public function pengumuman_edit(Request $request, $id)
    {


        $pengumuman = Pengumuman::findOrFail($id);
        $this->validator($request->all())->validate();


        // dd($daerah);
        $pengumuman->tajuk = $request->tajuk;
        $pengumuman->keterangan = $request->keterangan;

        $pengumuman->save();


        return redirect('jpn/pengumuman-jpn')->with('success','Maklumat Anda Telah Berjaya Dikemaskini.');

    }

    public function pengumuman_edit_jpn(Request $request, $id)
    {


        $pengumuman = PengumumanJpn::findOrFail($id);
        $this->validator($request->all())->validate();


        // dd($daerah);
        $pengumuman->tajuk = $request->tajuk;
        $pengumuman->keterangan = $request->keterangan;

        $pengumuman->save();


        return redirect('jpn/pengumuman-jpn')->with('success','Maklumat Anda Telah Berjaya Dikemaskini.');

    }

    public function pengumuman_edit_ipjpsm(Request $request, $id)
    {


        $pengumuman = PengumumanIpjpsm::findOrFail($id);
        $this->validator($request->all())->validate();


        // dd($daerah);
        $pengumuman->tajuk = $request->tajuk;
        $pengumuman->keterangan = $request->keterangan;
        $pengumuman->negeri = $request->negeri;

        $pengumuman->save();


        return redirect('admin/pengumuman-ipjpsm')->with('success','Maklumat Anda Telah Berjaya Dikemaskini.');

    }

    public function pengumuman_delete($id){
        // dd($id);
        $pengumuman = Pengumuman::find($id);
        // dd($pengumuman);
        $pengumuman->delete();
        return redirect('phd/pengumuman')->with('success','Maklumat Telah Berjaya Dihapuskan.');

    }

    public function pengumuman_delete_jpn($id){
        // dd($id);
        $pengumuman = PengumumanJpn::find($id);
        // dd($pengumuman);
        $pengumuman->delete();
        return redirect('jpn/pengumuman-jpn')->with('success','Maklumat Telah Berjaya Dihapuskan.');

    }

    public function pengumuman_delete_ipjpsm($id){
        // dd($id);
        $pengumuman = PengumumanIpjpsm::find($id);
        // dd($pengumuman);
        $pengumuman->delete();
        return redirect('admin/pengumuman-ipjpsm')->with('success','Maklumat Telah Berjaya Dihapuskan.');

    }
}
