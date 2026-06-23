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
                    <h2 style="padding-top: 2%;"><b>{{ $formB_count }}/{{ (int) ceil($currentMonth / 3) }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG B</h3>
                </div>
            </div>
        </a>
        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiC', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formC_count }}/{{ $currentMonth }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG C</h3>
                </div>
            </div>
        </a>
        <a class="col-md-3" href="{{ route('user.shuttle-3-senaraiD', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 10px;text-align:center;">
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $formD_count }}/{{ $currentMonth }}</b></h2>
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
                        <h2 style="padding-top: 2%;"><b>{{ $form4B_count }}/{{ (int) ceil($currentMonth / 3) }}</b></h2>
                        <h3 style="padding-top: 2%;">BORANG B</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiC', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4C_count }}/{{ $currentMonth }}</b></h2>
                        <h3 style="padding-top: 2%;">BORANG C</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiD', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173 ;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4D_count }}/{{ $currentMonth }}</b></h2>
                        <h3 style="padding-top: 2%;">BORANG D</h3>
                    </div>
                </div>
            </a>
            <a class="col-md" href="{{ route('user.shuttle-4-senaraiE', date("Y")) }}" style="color:black;">
                <div class="card bg-info card-hover" style="border-radius: 10px">
                    <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #74d4f1 ;border-radius: 10px;text-align:center;">
                        <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                        <h2 style="padding-top: 2%;"><b>{{ $form4E_count }}/{{ $currentMonth }}</b></h2>
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
                    <h2 style="padding-top: 2%;"><b>{{ $form5B_count }}/{{ (int) ceil($currentMonth / 3) }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG B</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiC', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #f0e10dbd;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="font-size: 15px;">BORANG 5C:<br> PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI DAN PENGELUARAN KAYU KUMAI MENGIKUT KUMPULAN KAYU-KAYAN</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5C_count }}/{{ $currentMonth }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG C</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiD', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #6df173;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 15%;">BORANG 5D:<br> PENYATA PENGELUARAN KAYU KUMAI MENGIKUT JENIS KAYU KUMAI</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5D_count }}/{{ $currentMonth }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG D</h3>
                </div>
            </div>
        </a>
        <a class="col-md" href="{{ route('user.shuttle-5-senaraiE', date("Y")) }}" style="color:black;">
            <div class="card bg-info card-hover" style="border-radius: 10px">
                <div class="card-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #a0e4ff;border-radius: 10px;text-align:center;">
                    <!-- <h5 style="padding-top: 15%;">BORANG 5E:<br> PENYATA PENJUALAN KAYU KUMAI DALAM PASARAN TEMPATAN DAN EKSPORT</h5> -->
                    <h2 style="padding-top: 2%;"><i class="fas fa-copy"></i></h2>
                    <h2 style="padding-top: 2%;"><b>{{ $form5E_count }}/{{ $currentMonth }}</b></h2>
                    <h3 style="padding-top: 2%;">BORANG E</h3>
                </div>
            </div>
        </a>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="border card" style="border-radius: 5px;">
                <div class="border card-header bg-info">
                    <h3 class="text-white m-b-0" style="text-align: center; font-size: 20px; font-weight: bold;">SENARAI TUGASAN</h3>
                </div>
                <div class="border card-body">
                    @php
                        $shuttleType = $user->shuttle_type;
                        $thisYear    = (int) date('Y');
                        $months      = [1=>'Jan',2=>'Feb',3=>'Mac',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ogs',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Dis'];
                        $quarters    = [1=>'Suku 1<br><small>Jan-Mac</small>',2=>'Suku 2<br><small>Apr-Jun</small>',3=>'Suku 3<br><small>Jul-Sep</small>',4=>'Suku 4<br><small>Okt-Dis</small>'];
                    @endphp

                    @foreach($requirements['years_to_fill'] as $reqYear)
                    <div style="overflow-x: auto; margin-bottom: 24px;">
                        <h5 style="font-weight: bold; border-bottom: 2px solid #17a2b8; padding-bottom: 6px; margin-bottom: 12px;">
                            TAHUN {{ $reqYear }}
                        </h5>

                        {{-- BORANG A --}}
                        @if(in_array($reqYear, $requirements['forma_required']))
                        @php
                            $cellFormA  = $tableData[$reqYear]['formA'] ?? null;
                            $aFillLink  = route('user.shuttle-' . $shuttleType . '-formA', $reqYear);
                            $aViewLink  = $cellFormA ? route('pengguna.shuttle-3-view-formA', $cellFormA->id) : $aFillLink;
                        @endphp
                        <p style="font-weight: bold; margin-bottom: 4px;">Borang {{ $shuttleType }}A &mdash; Maklumat Kilang (Tahunan)</p>
                        <table class="table-bordered text-center" style="margin-bottom: 16px;">
                            <thead style="background-color: #c5d6eb;">
                                <tr>
                                    <th style="padding: 6px 20px;">Tahun</th>
                                    <th style="padding: 6px 40px;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 6px 20px;">{{ $reqYear }}</td>
                                    <td style="padding: 6px 20px;">
                                        @include('partials.form-status-cell', [
                                            'form'     => $cellFormA,
                                            'fillLink' => $aFillLink,
                                            'viewLink' => $aViewLink,
                                            'isDue'    => true,
                                        ])
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endif

                        {{-- BORANG B --}}
                        @if(!empty($requirements['quarters_to_fill'][$reqYear]))
                        <p style="font-weight: bold; margin-bottom: 4px;">Borang {{ $shuttleType }}B &mdash; Guna Tenaga (Suku Tahunan)</p>
                        <table class="table-bordered text-center" style="width: 100%; margin-bottom: 16px;">
                            <thead style="background-color: #ee8dcd;">
                                <tr>
                                    <th style="width: 8%; padding: 6px;">Tahun</th>
                                    @foreach($quarters as $q => $qLabel)
                                    <th style="width: 23%; padding: 6px;">{!! $qLabel !!}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 8px;">{{ $reqYear }}</td>
                                    @foreach($quarters as $q => $qLabel)
                                    @php
                                        $isDue     = in_array($q, $requirements['quarters_to_fill'][$reqYear] ?? [])
                                                  && ($reqYear < $thisYear || ($reqYear == $thisYear && $currentMonth >= $q * 3));
                                        $cellFormB = ($tableData[$reqYear]['formB'] ?? collect())->get($q);
                                        $bFillLink = route('user.shuttle-' . $shuttleType . '-formB', [$q, $reqYear]);
                                        $bViewLink = $cellFormB ? route('pengguna.shuttle-3-view-formB', $cellFormB->id) : $bFillLink;
                                    @endphp
                                    <td style="padding: 8px;">
                                        @include('partials.form-status-cell', [
                                            'form'     => $cellFormB,
                                            'fillLink' => $bFillLink,
                                            'viewLink' => $bViewLink,
                                            'isDue'    => $isDue,
                                        ])
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        @endif

                        {{-- BORANG C --}}
                        @if(!empty($requirements['months_to_fill'][$reqYear]))
                        <p style="font-weight: bold; margin-bottom: 4px;">Borang {{ $shuttleType }}C &mdash; Penyata Bulanan</p>
                        <table class="table-bordered text-center" style="width: 100%; margin-bottom: 16px;">
                            <thead style="background-color: #f0e10dbd;">
                                <tr>
                                    <th style="width: 8%; padding: 6px;">Tahun</th>
                                    @foreach($months as $m => $mLabel)
                                    <th style="padding: 6px;">{{ $mLabel }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 8px;">{{ $reqYear }}</td>
                                    @foreach($months as $m => $mLabel)
                                    @php
                                        $isDue     = in_array($m, $requirements['months_to_fill'][$reqYear] ?? [])
                                                  && ($reqYear < $thisYear || ($reqYear == $thisYear && $currentMonth >= $m));
                                        $cellFormC = ($tableData[$reqYear]['formC'] ?? collect())->get($m);
                                        $cFillLink = route('user.shuttle-' . $shuttleType . '-formC.KKB', [$m, $reqYear]);
                                        $viewRouteType = ($shuttleType == 3) ? 3 : 4;
                                        $cViewLink = $cellFormC ? route('pengguna.shuttle-' . $viewRouteType . '-view-formC', $cellFormC->id) : $cFillLink;
                                    @endphp
                                    <td style="padding: 8px;">
                                        @include('partials.form-status-cell', [
                                            'form'     => $cellFormC,
                                            'fillLink' => $cFillLink,
                                            'viewLink' => $cViewLink,
                                            'isDue'    => $isDue,
                                        ])
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        @endif

                        {{-- BORANG D --}}
                        @if(!empty($requirements['months_to_fill'][$reqYear]) && isset($tableData[$reqYear]['formD']))
                        <p style="font-weight: bold; margin-bottom: 4px;">Borang {{ $shuttleType }}D &mdash; Penyata Bulanan</p>
                        <table class="table-bordered text-center" style="width: 100%; margin-bottom: 16px;">
                            <thead style="background-color: #6df173;">
                                <tr>
                                    <th style="width: 8%; padding: 6px;">Tahun</th>
                                    @foreach($months as $m => $mLabel)
                                    <th style="padding: 6px;">{{ $mLabel }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 8px;">{{ $reqYear }}</td>
                                    @foreach($months as $m => $mLabel)
                                    @php
                                        $isDue     = in_array($m, $requirements['months_to_fill'][$reqYear] ?? [])
                                                  && ($reqYear < $thisYear || ($reqYear == $thisYear && $currentMonth >= $m));
                                        $cellFormD = ($tableData[$reqYear]['formD'] ?? collect())->get($m);
                                        if ($shuttleType == 3) {
                                            $dFillLink = route('user.shuttle-3-formD', ['year' => $reqYear, 'id' => $m]);
                                            $dViewLink = $cellFormD ? route('pengguna.shuttle-3-view-formD', $cellFormD->id) : $dFillLink;
                                        } elseif ($shuttleType == 4) {
                                            $dFillLink = route('user.shuttle-4-formD', [$reqYear, $m]);
                                            $dViewLink = $cellFormD ? route('pengguna.shuttle-4-view-form4D', $cellFormD->id) : $dFillLink;
                                        } else {
                                            $dFillLink = route('user.shuttle-5-formD', $m);
                                            $dViewLink = $cellFormD ? route('pengguna.shuttle-5-view-form5D', $cellFormD->id) : $dFillLink;
                                        }
                                    @endphp
                                    <td style="padding: 8px;">
                                        @include('partials.form-status-cell', [
                                            'form'     => $cellFormD,
                                            'fillLink' => $dFillLink,
                                            'viewLink' => $dViewLink,
                                            'isDue'    => $isDue,
                                        ])
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        @endif

                        {{-- BORANG E (Shuttle 4 & 5 only) --}}
                        @if(in_array($shuttleType, [4, 5]) && !empty($requirements['months_to_fill'][$reqYear]) && isset($tableData[$reqYear]['formE']))
                        <p style="font-weight: bold; margin-bottom: 4px;">Borang {{ $shuttleType }}E &mdash; Penyata Bulanan</p>
                        <table class="table-bordered text-center" style="width: 100%; margin-bottom: 16px;">
                            <thead style="background-color: #74d4f1;">
                                <tr>
                                    <th style="width: 8%; padding: 6px;">Tahun</th>
                                    @foreach($months as $m => $mLabel)
                                    <th style="padding: 6px;">{{ $mLabel }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 8px;">{{ $reqYear }}</td>
                                    @foreach($months as $m => $mLabel)
                                    @php
                                        $isDue     = in_array($m, $requirements['months_to_fill'][$reqYear] ?? [])
                                                  && ($reqYear < $thisYear || ($reqYear == $thisYear && $currentMonth >= $m));
                                        $cellFormE = ($tableData[$reqYear]['formE'] ?? collect())->get($m);
                                        if ($shuttleType == 4) {
                                            $eFillLink = route('user.shuttle-4-formE', [$reqYear, $m]);
                                            $eViewLink = $cellFormE ? route('pengguna.shuttle-4-view-form4E', $cellFormE->id) : $eFillLink;
                                        } else {
                                            $eFillLink = route('user.shuttle-5-formE', [$reqYear, $m]);
                                            $eViewLink = $cellFormE ? route('pengguna.shuttle-5-view-form5E', $cellFormE->id) : $eFillLink;
                                        }
                                    @endphp
                                    <td style="padding: 8px;">
                                        @include('partials.form-status-cell', [
                                            'form'     => $cellFormE,
                                            'fillLink' => $eFillLink,
                                            'viewLink' => $eViewLink,
                                            'isDue'    => $isDue,
                                        ])
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        @endif

                    </div>
                    @endforeach

                    {{-- PENGUMUMAN --}}
                    @if($pengumuman && count($pengumuman) > 0)
                    <div style="border-top: 1px solid #dee2e6; padding-top: 12px; margin-top: 8px;">
                        <h6 style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                            <i class="fas fa-bullhorn"></i> PENGUMUMAN
                        </h6>
                        @foreach($pengumuman as $data)
                        <div style="border-bottom: 1px solid #eee; padding: 8px 0;">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 style="font-size: 16px; font-weight: bold;">{{ $data->tajuk }}</h6>
                                <small class="text-muted">{{ date('d-m-Y', strtotime($data->created_at)) }}</small>
                            </div>
                            <p style="font-size: 14px; margin: 0;">{{ $data->keterangan }}</p>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
