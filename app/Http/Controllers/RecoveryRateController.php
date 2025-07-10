<?php

namespace App\Http\Controllers;

use App\Models\RecoveryRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecoveryRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recovery_rate = RecoveryRate::get();
        $data = [
            'recovery_rate' => $recovery_rate,
        ];

        // dd($array);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('recovery-rate', date('Y')), 'name' => "Menu Utama Modul"],
            ['link' => route('recovery-rate', date('Y')), 'name' => "Pengurusan Data Asas"],
            ['link' => route('recovery-rate', date('Y')), 'name' => "Kemaskini Senarai Recovery Rate"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.recovery-rate.recovery-rate', $data, compact('returnArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $recovery_rate = RecoveryRate::where('id', $id)->first();
        $data = [
            'recovery_rate' => $recovery_rate,
        ];

        // dd($data);


        return view('admins.recovery-rate.recovery-rate-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $recovery_rate = RecoveryRate::findOrFail($id);

        $recovery_rate->min_recovery_rate = $request->min_recovery_rate;
        $recovery_rate->max_recovery_rate = $request->max_recovery_rate;
        $recovery_rate->save();

        // Session::flash('message', 'Maklumat berjaya dikemaskini');

        return redirect()->route('recovery-rate')->with('success','Maklumat berjaya dikemaskini.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
