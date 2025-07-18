<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Daerah;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class AdminController extends Controller{

   public function index(){
      return view('admins.shuttle-3');
   }

   public function kemaskini_profil_phd()
    {
        // return redirect()->back()->withInput();
        $user = auth()->user();


        // dd($pengguna);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('phd.kemaskini-profil', date('Y')), 'name' => "Kemaskini Profil Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('kemaskini-profil-phd', compact('user', 'returnArr'));
    }

    public function kemaskini_profil_jpn()
    {
        // return redirect()->back()->withInput();
        $user = auth()->user();


        // dd($pengguna);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('jpn.kemaskini-profil', date('Y')), 'name' => "Kemaskini Profil Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('kemaskini-profil-jpn', compact('user', 'returnArr'));
    }


    public function kemaskini_profil_ipjpsm()
    {
        // return redirect()->back()->withInput();
        $user = auth()->user();


        // dd($pengguna);

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('ipjpsm.kemaskini-profil', date('Y')), 'name' => "Kemaskini Profil Pengguna"],
        ];

        $kembali = route('home');

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];

        return view('kemaskini-profil-ipjpsm', compact('user', 'returnArr'));
    }

    public function update_profile_ipjpsm(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $oldEmail = $user->email;

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        // Update user fields
        $user->email = $request->email;
        $user->jawatan = $request->jawatan;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists and matches the old email
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang && $penggunaKilang->email === $oldEmail) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists and matches the old email
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle && $shuttle->email === $oldEmail) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Profil dan emel berkaitan berjaya dikemaskini.");
    }

    public function update_emel_kilang(Request $request, $id)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail($id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        // Update the user's email
        $user->email = $request->email;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Emel pengguna dan maklumat berkaitan berjaya dikemaskini.");
    }

    public function update_emel_phd(Request $request, $id)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail($id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        $negeri_name= Daerah::where('id',$request->negeri_id)->first('negeri');
        $daerah_name= Daerah::where('id',$request->daerah_id)->first('daerah_hutan');

        // Update user fields
        $user->email = $request->email;
        $user->daerah = $daerah_name->daerah_hutan;
        $user->negeri = $negeri_name->negeri;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Maklumat pengguna dan emel berkaitan berjaya dikemaskini.");
    }


    public function update_emel_jpn(Request $request, $id)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail($id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        $negeri_name= Daerah::where('id',$request->negeri_id)->first('negeri');

        // Update user fields
        $user->email = $request->email;
        $user->negeri = $negeri_name->negeri;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Maklumat pengguna dan emel berkaitan berjaya dikemaskini.");
    }

    public function update_emel_pengguna(Request $request, $id)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail($id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        // Update user email
        $user->email = $request->email;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Maklumat pengguna dan emel berkaitan berjaya dikemaskini.");
    }

    public function update_emel_ipjpsm(Request $request, $id)
    {
        $user = User::with(['pengguna_kilang', 'shuttle'])->findOrFail($id);
        $oldEmail = $user->getCurrentEmail(); // Get the current email from the appropriate table

        // Validate email with unique check across all tables
        $request->validate([
            'email' => [
                'required',
                'email',
                new \App\Rules\UniqueEmailAcrossAllTables($user->id)
            ]
        ]);

        // Update user email
        $user->email = $request->email;
        
        // Update updated_at timestamp
        $user->updated_at = now();
        
        $user->save();

        // Update related PenggunaKilang email if it exists
        if ($user->pengguna_kilang_id) {
            $penggunaKilang = \App\Models\PenggunaKilang::find($user->pengguna_kilang_id);
            if ($penggunaKilang) {
                $penggunaKilang->email = $request->email;
                $penggunaKilang->updated_at = now();
                $penggunaKilang->save();
            }
        }

        // Update related Shuttle email if it exists
        if ($user->shuttle_id) {
            $shuttle = \App\Models\Shuttle::find($user->shuttle_id);
            if ($shuttle) {
                $shuttle->email = $request->email;
                $shuttle->updated_at = now();
                $shuttle->save();
            }
        }

        return redirect()->back()->with("success", "Maklumat pengguna dan emel berkaitan berjaya dikemaskini.");
    }

    public function update_profile_phd(Request $request)
    {

        // Validate change password form
        // $this->validator($request->all())->validate();

        $user = User::findOrFail(Auth::user()->id);
        // dd($user);


        $user->email = $request->email;

        $user->jawatan= $request->jawatan;



        $user->save();

        return redirect()->back()->with("success", "Berjaya kemaskini profil.");
    }

    public function update_profile_jpn(Request $request)
    {

        // Validate change password form
        // $this->validator($request->all())->validate();

        $user = User::findOrFail(Auth::user()->id);
        // dd($user);


        $user->email = $request->email;

        $user->jawatan= $request->jawatan;



        $user->save();

        return redirect()->back()->with("success", "Berjaya kemaskini profil.");
    }


   /*
   AJAX request
   */
   public function getShuttle3(Request $request){

    // dd($request->all());
     ## Read value
     $draw = $request->get('draw');
     $start = $request->get("start");
     $rowperpage = $request->get("length"); // Rows display per page

     $columnIndex_arr = $request->get('order');
     $columnName_arr = $request->get('columns');
     $order_arr = $request->get('order');
     $search_arr = $request->get('search');

     $columnIndex = $columnIndex_arr[0]['column']; // Column index
     $columnName = $columnName_arr[$columnIndex]['data']; // Column name
     $columnSortOrder = $order_arr[0]['dir']; // asc or desc
     $searchValue = $search_arr['value']; // Search value

     // Total records
     $totalRecords = User::select('count(*) as allcount')->count();
     $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

     // Fetch records
     $records = User::orderBy($columnName,$columnSortOrder)
       ->where('users.name', 'like', '%' .$searchValue . '%')
       ->select('users.*')
       ->skip($start)
       ->take($rowperpage)
       ->get();

     $data_arr = array();

     foreach($records as $record){
        $id = $record->id;
        $username = $record->username;
        $name = $record->name;
        $email = $record->email;

        $data_arr[] = array(
          "id" => $id,
          "username" => $username,
          "name" => $name,
          "email" => $email
        );
     }

     $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
     );

     echo json_encode($response);
     exit;
   }

//    public function laporan(){
//        return view('admins.laporan.senarai _laporan');
//    }

public function viewAuditList()
{
    $users = User::where('kategori_pengguna','BPE')->where('is_approved_ipjpsm',0)->get();

    $data = Audit::get();
    $breadcrumbs    = [
        ['link' => route('home'), 'name' => "Laman Utama"],
        ['link' => route('audit'), 'name' => "Audit Trails"],
    ];

    $kembali = route('home');

    $layout = 'layouts.layout-bpm-nicepage';

    $returnArr = [
        'breadcrumbs' => $breadcrumbs,
        'kembali'     => $kembali,
    ];
    return view('admins.audit.audit', compact('data','users', 'returnArr','layout'));
}

public function audit_datatable()
      {
        $data = Audit::with('user')->where('event','!=','Log Masuk')->where('event','!=','Log Keluar')->where('user_id','!=', null)->get();

        // dd($data);

        return Datatables::of($data)
          ->addIndexColumn()
          ->editColumn('created_at', function ($row) {
              $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('d-m-Y g:i A');
              return $formatedDate;
          })
          ->editColumn('updated_at', function ($row) {
              $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at)->format('d-m-Y g:i A');
              return $formatedDate;
          })->make(true);
      }

      public function auditTrailLogUser()
      {
        // $data = Audit::with('user')->get();
        // $data = User::where('role','!=','5')->get();
        // $all = $user->audits;

        $breadcrumbs    = [
            ['link' => route('home'), 'name' => "Laman Utama"],
            ['link' => route('audit'), 'name' => "Audit Trails"],
        ];

        $kembali = route('home');

        $layout = 'layouts.layout-bpm-nicepage';

        $returnArr = [
            'breadcrumbs' => $breadcrumbs,
            'kembali'     => $kembali,
        ];
        $data = Audit::where('event','Log Masuk')->orWhere('event','Log Keluar')->get();
        // dd($data);
        return view('admins.audit.auditUser', compact('data', 'returnArr','layout'));
      }
}
