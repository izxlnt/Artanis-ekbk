<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\Form4D;
use App\Models\Form4E;
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

class ShuttleFourPDFController extends Controller
{
    /**
     * Print PDF for Shuttle 4 Form A
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
            'title' => 'Borang 4A - Maklumat Kilang',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('pdf.shuttle4.form-a', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream("Borang_4A_{$shuttle->nama_kilang}_{$formA->tahun}.pdf");
    }

    /**
     * Print PDF for Shuttle 4 Form B
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
            'title' => 'Borang 4B - Maklumat Guna Tenaga',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('pdf.shuttle4.form-b', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream("Borang_4B_{$shuttle->nama_kilang}_{$formB->tahun}_S{$formB->suku_tahun}.pdf");
    }

    /**
     * Print PDF for Shuttle 4 Form C
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
            'title' => 'Borang 4C - Kemasukan Bahan Mentah',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        $pdf = PDF::loadView('pdf.shuttle4.form-c', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("Borang_4C_{$shuttle->nama_kilang}_{$formC->tahun}_{$bulan_nama[$formC->bulan]}.pdf");
    }

    /**
     * Print PDF for Shuttle 4 Form D
     */
    public function printFormD($id)
    {
        $formD = Form4D::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formD->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang D belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formD->shuttle_id);
        
        $data = [
            'formD' => $formD,
            'shuttle' => $shuttle,
            'title' => 'Borang 4D - Pengeluaran dan Jualan',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        $pdf = PDF::loadView('pdf.shuttle4.form-d', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream("Borang_4D_{$shuttle->nama_kilang}_{$formD->tahun}_{$bulan_nama[$formD->bulan]}.pdf");
    }

    /**
     * Print PDF for Shuttle 4 Form E
     */
    public function printFormE($id)
    {
        $formE = Form4E::findOrFail($id);
        
        // Check if form is completed/approved
        if (!in_array($formE->status, ['Dihantar ke IPJPSM', 'Lulus'])) {
            return redirect()->back()->with('error', 'Borang E belum selesai untuk dicetak.');
        }

        $shuttle = Shuttle::findOrFail($formE->shuttle_id);
        
        $data = [
            'formE' => $formE,
            'shuttle' => $shuttle,
            'title' => 'Borang 4E - Maklumat Eksport',
            'print_date' => now()->format('d/m/Y H:i:s')
        ];

        $bulan_nama = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        $pdf = PDF::loadView('pdf.shuttle4.form-e', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream("Borang_4E_{$shuttle->nama_kilang}_{$formE->tahun}_{$bulan_nama[$formE->bulan]}.pdf");
    }
}
