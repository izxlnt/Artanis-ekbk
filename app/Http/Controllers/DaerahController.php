<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    public function daerah()
    {

        $daerah = Daerah::get();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Senarai Daerah"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.daerah.daerah', compact('returnArr','daerah'));
    }

    public function daerah_tambah()
    {

        // $daerah = Daerah::get();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Senarai Daerah"],
            ['link' => route('daerah', date('Y')), 'name' => "Tambah Daerah"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.daerah.daerah-tambah', compact('returnArr'));
    }

    protected function validator(array $data)
    {

            return Validator::make($data, [
                'negeri' => ['required', 'string'],
                'daerah_hutan' => ['required', 'string'],
                'daerah_sivil' => ['required', 'string'],
            ]);



    }

    public function daerah_add(Request $request)
    {
        // dd($request->all());
        $this->validator($request->all())->validate();

        Daerah::create([
            'negeri'=> $request->negeri,
            'daerah_hutan'=> $request->daerah_hutan,
            'daerah_sivil'=> $request->daerah_sivil,


        ]);

        // dd('masuk');
		return redirect('admin/daerah')->with('success','Maklumat Anda Telah Berjaya Ditambah.');


        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Senarai Daerah"],
            ['link' => route('daerah', date('Y')), 'name' => "Tambah Daerah"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];



        return view('admins.daerah.daerah-tambah', compact('returnArr'));
    }

    public function daerah_kemaskini($id)
    {
        // dd($id);
        $daerah = Daerah::where('id',$id)->first();

        // dd($daerah);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('daerah', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('daerah', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Senarai Daerah"],
            ['link' => route('daerah', date('Y')), 'name' => "Kemaskini Daerah"],
        ];

        $kembali = route('daerah');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.daerah.daerah-edit', compact('returnArr','daerah'));
    }

    public function daerah_edit(Request $request, $id)
    {

        $this->validator($request->all())->validate();

        Daerah::create([
            'negeri'=> $request->negeri,
            'daerah_hutan'=> $request->daerah_hutan,
            'daerah_sivil'=> $request->daerah_sivil,


        ]);
        $daerah = Daerah::findOrFail($id);

        // dd($daerah);
        $daerah->negeri = $request->negeri;
        $daerah->daerah_hutan = $request->daerah_hutan;
        $daerah->daerah_sivil = $request->daerah_sivil;

        $daerah->save();


        return redirect('admin/daerah')->with('success','Maklumat Anda Telah Berjaya Dikemaskini.');

    }

    public function delete($id){
        // dd('masuikkk');
        $data = Daerah::find($id);
        $data->delete();
        return redirect()->back()->with('success','Maklumat Anda Telah Berjaya Dihapuskan.');
    }
}
