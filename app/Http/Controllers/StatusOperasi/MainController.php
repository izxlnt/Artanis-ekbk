<?php

namespace App\Http\Controllers\StatusOperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function status_operasi()
    {
        return view('admins.status-operasi.status-operasi');
    }
}
