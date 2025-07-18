<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\Shuttle;
use App\Models\KemasukanBahan;
use App\Models\Spesis;
use App\Models\KumpulanKayu;
use App\Models\Pembeli;
use App\Models\PenjualanPembeli;
use App\Models\KategoriGunaTenaga;
use App\Models\PenggunaKilang;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class ShuttleThreePDFController extends Controller
{
    /**
     * Print PDF for Shuttle 3 Form A
     */
    public function printFormA($id)
    {
        $formA = FormA::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formA->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang A belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formA->shuttle_id);
        
        $data = [
            'formA' => $formA,
            'shuttle' => $shuttle,
            'title' => 'Borang 3A - Maklumat Kilang',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('pdf.shuttle3.form-a', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream("Borang_3A_{$shuttle->nama_kilang}_{$formA->tahun}.pdf");
    }

    /**
     * Print PDF for Shuttle 3 Form B
     */
    public function printFormB($id)
    {
        $formB = FormB::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formB->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang B belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formB->shuttle_id);
        $penggunaKilang = PenggunaKilang::where('formbs_id', $formB->id)->get();
        
        $data = [
            'formB' => $formB,
            'shuttle' => $shuttle,
            'penggunaKilang' => $penggunaKilang,
            'title' => 'Borang 3B - Maklumat Guna Tenaga',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('pdf.shuttle3.form-b', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream("Borang_3B_{$shuttle->nama_kilang}_{$formB->tahun}_S{$formB->suku_tahun}.pdf");
    }

    /**
     * Print PDF for Shuttle 3 Form C
     */
    public function printFormC($id)
    {
        $formC = FormC::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formC->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang C belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formC->shuttle_id);
        $kemasukanBahan = KemasukanBahan::where('formcs_id', $formC->id)->get();
        $species = Spesis::all();
        $kumpulanKayu = KumpulanKayu::all();
        
        $data = [
            'formC' => $formC,
            'shuttle' => $shuttle,
            'kemasukanBahan' => $kemasukanBahan,
            'species' => $species,
            'kumpulanKayu' => $kumpulanKayu,
            'title' => 'Borang 3C - Kemasukan Bahan Mentah',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        $pdf = PDF::loadView('pdf.shuttle3.form-c', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("Borang_3C_{$shuttle->nama_kilang}_{$formC->tahun}_{$bulan_nama[$formC->bulan]}.pdf");
    }

    /**
     * Print PDF for Shuttle 3 Form D
     */
    public function printFormD($id)
    {
        $formD = FormD::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formD->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang D belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formD->shuttle_id);
        $pembeli = Pembeli::where('formd_id', $formD->id)->get();
        $penjualanPembeli = PenjualanPembeli::where('formd_id', $formD->id)->get();
        
        $data = [
            'formD' => $formD,
            'shuttle' => $shuttle,
            'pembeli' => $pembeli,
            'penjualanPembeli' => $penjualanPembeli,
            'title' => 'Borang 3D - Pengeluaran dan Jualan',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        $pdf = PDF::loadView('pdf.shuttle3.form-d', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("Borang_3D_{$shuttle->nama_kilang}_{$formD->tahun}_{$bulan_nama[$formD->bulan]}.pdf");
    }
}
