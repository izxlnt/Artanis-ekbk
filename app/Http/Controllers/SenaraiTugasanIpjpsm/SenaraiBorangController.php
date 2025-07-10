<?php

namespace App\Http\Controllers\SenaraiTugasanIpjpsm;

use App\Http\Controllers\Controller;
use App\Models\Shuttle;
use Illuminate\Http\Request;

class SenaraiBorangController extends Controller
{
    public function borang_belum_lengkap()
    {

        $shuttle = Shuttle::get();
        return view('admins.senarai-tugasan-ipjpsm.senarai-tugasan-ipjpsm',compact('shuttle'));
    }

}
