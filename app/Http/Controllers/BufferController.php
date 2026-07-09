<?php

namespace App\Http\Controllers;

use App\Models\Buffer;
use Illuminate\Http\Request;

class BufferController extends Controller
{
    public function papar_buffer(){

        $buffer = Buffer::get();

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('tetapan.buffer.papar'), 'name' => "Menu Utama Modul"],
            ['link' => route('tetapan.buffer.papar'), 'name' => "Tetapan Buffer Penghantaran Borang"],
        ];

        $kembali = route('home');
        $currMonth = date('n');
        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('admins.tetapan.buffer.senarai-buffer', compact('buffer', 'returnArr','currMonth'));
    }

    public function update_buffer(Request $request){

        $aktif = $request->has('aktif') ? 1 : 0;

        if($request->buffer_id == "0"){
            $buffer = Buffer::get();

            foreach( $buffer as $data){

                $data->delay = $request->delay;
                $data->aktif = $aktif;
                $data->save();
            }

        }else{
            $buffer = Buffer::findorfail($request->buffer_id);

            $buffer->delay = $request->delay;
            $buffer->aktif = $aktif;
            $buffer->save();
        }



        return redirect('/admin/tetapan/senarai-buffer')->with('success', 'Buffer berjaya dikemaskini');
    }
}
