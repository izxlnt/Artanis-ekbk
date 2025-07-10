@extends('layouts.layout-ibk-nicepage')
@section('content')


<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    @if (session()->has('message'))
    <div class="row" id="message">
        <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
        </div>
    </div>
    @endif

    <div class="page-breadcrumb">
        <div class="pb-2 row">
            <div class="col-5 align-self-center">
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
                                Laman Utama
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->pengguna_kilang_id != null)
    <div class="row" style="justify-content: space-around;">

        @if($user->shuttle_type == "3")

        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiA', date("Y")) }}" style="color:black; ">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #c5d6eb;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formA_count }}/1</b></h2>
                    <h3 style="padding-top: 2%;">BORANG A</h3>

                </div>
            </div>
        </a>
        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiB', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formB_count }}/4</b></h2>
                    <h3 style="padding-top: 2%;">BORANG B</h3>
                </div>
            </div>
        </a>
        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiC', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formC_count }}/12</b></h2>
                    <h3 style="padding-top: 2%;">BORANG C</h3>
                </div>
            </div>
        </a>
        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiD', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formD_count }}/12</b></h2>
                    <h3 style="padding-top: 2%;">BORANG D</h3>
                </div>
            </div>
        </a>
        @elseif($user->shuttle_type == "4")

            <a class="col-md" href="{{ route('user.shuttle-4-senaraiA', date("Y")) }}" style="color:black; ">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #c5d6eb;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4A_count }}/1</b></h2>
                        <h3 style="padding-top: 2%;">BORANG A</h3>

                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiB', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd ;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4B_count }}/4</b></h2>
                        <h3 style="padding-top: 2%;">BORANG B</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiC', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4C_count }}/12</b></h2>
                        <h3 style="padding-top: 2%;">BORANG C</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiD', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4D_count }}/12</b></h2>
                        <h3 style="padding-top: 2%;">BORANG D</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiE', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #74d4f1 ;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4E_count }}/12</b></h2>
                        <h3 style="padding-top: 2%;">BORANG E</h3>
                    </div>
                </div>
            </a>


        @elseif($user->shuttle_type == "5")
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiA', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #c5d6eb;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 25%;">BORANG 5A:<br> MAKLUMAT KILANG PAPAN</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5A_count }}/1</b></h2>
                    <h3 style="padding-top: 2%;">BORANG A</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiB', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #ee8dcd;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 25%;">BORANG 5B:<br> JUMLAH GUNA TENAGA</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5B_count }}/4</b></h2>
                    <h3 style="padding-top: 2%;">BORANG B</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiC', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="font-size: 15px;">BORANG 5C:<br> PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI DAN PENGELUARAN KAYU KUMAI MENGIKUT KUMPULAN KAYU-KAYAN</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5C_count }}/12</b></h2>
                    <h3 style="padding-top: 2%;">BORANG C</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiD', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 15%;">BORANG 5D:<br> PENYATA PENGELUARAN KAYU KUMAI MENGIKUT JENIS KAYU KUMAI</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5D_count }}/12</b></h2>
                    <h3 style="padding-top: 2%;">BORANG D</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiE', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #a0e4ff;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 15%;">BORANG 5E:<br> PENYATA PENJUALAN KAYU KUMAI DALAM PASARAN TEMPATAN DAN EKSPORT</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5E_count }}/12</b></h2>
                    <h3 style="padding-top: 2%;">BORANG E</h3>
                </div>
            </div>
        </a>
        @endif
    </div>
    @endif

    <div class="row">

        <div class="col-md-12">
          <div class="border card" style="border-radius: 5px;">
            <div class="border card-header bg-info">
              <h3 class="text-white m-b-0" style="text-align: center;font-size: 20px;font-weight: bold;">SENARAI TUGASAN</h3>
            </div>
            <div class="border card-body">
                <div class="list-group" style="overflow:auto;height:300px;width:100%;border:1px solid #ccc">
                        <!-- <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"> -->
                    @if($pengumuman)
                        @foreach($pengumuman as $data)
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">{{ $data->tajuk }}</h6>
                            <small class="text-muted" style="font-size: 110%;">{{ date('d-m-Y', strtotime($data->created_at)) }}</small>
                            </div>
                            <p class="my-1" style="font-size: 15px; text-align:left;">{{ $data->keterangan }}</p>
                          </div>
                        @endforeach
                        @else
                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                            {{-- <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">{{ $data->tajuk }}</h6> --}}
                            {{-- <small class="text-muted" style="font-size: 110%;">{{ $data->created_at->toDateString() }}</small> --}}
                            </div>
                            <p class="my-1" style="font-size: 30px; text-align:center;">Tiada Pengumuman</p>
                          </div>
                        @endif


                        {{-- <div class="list-group-item list-group-item-action flex-column align-items-start">
                          <div class="d-flex w-100 justify-content-between">
                          <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                          <small class="text-muted" style="font-size: 110%;">26-01-2021</small>
                          </div>
                          <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>

                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                          <div class="d-flex w-100 justify-content-between">
                          <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                          <small class="text-muted" style="font-size: 110%;">05-01-2021</small>
                          </div>
                          <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>

                        <div class="list-group-item list-group-item-action flex-column align-items-start">
                          <div class="d-flex w-100 justify-content-between">
                          <h6 class="mb-1 card-title" style="font-size: 20px; font-weight: bold;">Pengumuman</h6>
                          <small class="text-muted" style="font-size: 110%;">01-01-2021</small>
                          </div>
                          <p class="my-1" style="font-size: 15px; text-align:justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div> --}}

                        <!-- </a> -->

                    </div>
            </div>
          </div>
        </div>

      </div>
</div>
@endsection
