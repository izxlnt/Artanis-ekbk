<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\FormD;
use App\Models\Shuttle;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SenaraiPDFController extends Controller
{
    public function printSenaraiD($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = FormD::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 3D - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle3-d', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    public function printSenaraiB($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\FormB::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 3B - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle3-b', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    public function printSenaraiC($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\FormC::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 3C - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle3-c', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    // Shuttle 4 methods
    public function printSenarai4D($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\Form4D::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 4D - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle4-d', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    public function printSenarai4E($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\Form4E::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 4E - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle4-e', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    // Shuttle 5 methods
    public function printSenarai5D($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\Form5D::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 5D - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle5-d', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
    
    public function printSenarai5E($year)
    {
        $user = auth()->user();
        $shuttle = Shuttle::where('id', $user->shuttle_id)->first();
        
        if (!$shuttle) {
            return redirect()->back()->with('error', 'Kilang tidak dijumpai');
        }
        
        $list = \App\Models\Form5E::where('shuttle_id', $shuttle->id)
                     ->where('tahun', $year)
                     ->where('status', 'Dihantar ke IPJPSM')
                     ->orWhere('status', 'Lulus')
                     ->get();
        
        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Tiada borang yang telah selesai untuk tahun ' . $year);
        }
        
        $title = 'Senarai Borang 5E - ' . $shuttle->nama_kilang . ' (' . $year . ')';
        $print_date = date('d/m/Y H:i:s');
        
        $pdf = Pdf::loadView('pdf.senarai.shuttle5-e', compact('list', 'shuttle', 'year', 'title', 'print_date'));
        
        return $pdf->stream($title . '.pdf');
    }
}
