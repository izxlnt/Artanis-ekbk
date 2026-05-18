<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MaintenanceSettingController extends Controller
{
    public function papar()
    {
        $tetapan = MaintenanceSetting::firstOrCreate([], [
            'is_active' => false,
        ]);

        $breadcrumbs = [
            ['link' => route('home'), 'name' => 'Laman Utama'],
            ['link' => route('tetapan.penyelenggaraan.papar'), 'name' => 'Tetapan Penyelenggaraan Sistem'],
        ];

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => route('home'),
        ];

        return view('admins.tetapan.penyelenggaraan.tetapan-penyelenggaraan', compact('tetapan', 'returnArr'));
    }

    public function toggle()
    {
        $tetapan = MaintenanceSetting::firstOrCreate([]);
        $tetapan->is_active        = !$tetapan->is_active;
        $tetapan->dikemaskini_oleh = Auth::user()->name;
        $tetapan->save();

        Cache::forget('maintenance_setting');

        $status = $tetapan->is_active ? 'diaktifkan' : 'dinyahaktifkan';

        return redirect()->back()->with('success', "Mod penyelenggaraan telah {$status}.");
    }

    public function kemaskini(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'message'    => 'nullable|string|max:500',
            'catatan'    => 'nullable|string|max:1000',
        ]);

        $tetapan = MaintenanceSetting::firstOrCreate([]);

        $tetapan->is_active        = $request->boolean('is_active');
        $tetapan->start_date       = $request->filled('start_date') ? $request->start_date : null;
        $tetapan->end_date         = $request->filled('end_date') ? $request->end_date : null;
        $tetapan->message          = $request->filled('message') ? $request->message : null;
        $tetapan->catatan          = $request->filled('catatan') ? $request->catatan : null;
        $tetapan->dikemaskini_oleh = Auth::user()->name;
        $tetapan->save();

        Cache::forget('maintenance_setting');

        $status = $tetapan->is_active ? 'diaktifkan' : 'dinyahaktifkan';

        return redirect()->route('tetapan.penyelenggaraan.papar')
            ->with('success', "Tetapan penyelenggaraan berjaya dikemaskini. Mod penyelenggaraan telah {$status}.");
    }
}
