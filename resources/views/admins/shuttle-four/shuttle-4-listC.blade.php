@extends('layouts.layout-ipjpsm-nicepage')

@section('content')


    {{-- @livewire('shuttle-three.shuttle3') --}}


    <div>

        <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


        <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
        <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <div class="page-breadcrumb" style="padding: 0px">
                <div class="pb-2 row">
                    <div class="col-5 align-self-center">
                        <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
                    </div>

                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center justify-content-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                        @if (!$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                                </a>
                                            </li>
                                        @else
                                        <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
                                            {{ $breadcrumb['name'] }}
                                        </li>
                                        @endif
                                    @endforeach

                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="select_year" id="select_year" class="form-control"
                                        onchange="return changePage();">
                                        <option value="" selected hidden disabled>
                                            TIADA BORANG DIREKODKAN
                                        </option>
                                        @foreach ($year_list as $data)
                                            <option value="{{ $data->tahun }}"
                                                {{ $data->tahun == $year ? 'selected' : '' }}>
                                                Tahun {{ $data->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a type="button " href="{{ route('shuttle-4-listA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 4A</a>
                                        <a type="button" href="{{ route('shuttle-4-listB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#ee8dcd">Borang 4B</a>
                                        <a type="button" href="{{ route('shuttle-4-listC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:#bbb235f3;color:black;border-color:#bbb235f3">Borang
                                            4C</a>
                                        <a type="button" href="{{ route('shuttle-4-listD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 4D</a>

                                        <a type="button" href="{{ route('shuttle-4-listE', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1145f0f3">Borang 4E</a>


                                    </div>
                                </div>
                            </div>
                            <div class="pt-5 row">
                                <div class="col-md-12">
                                    <h4 class="text-center">BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK <br>
                                        DAN PENGELUARAN KAYU GERGAJI
                                        MENGIKUT KUMPULAN KAYU-KAYAN</h4>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead style="background-color:#f3e741f3;">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>Negeri</th>
                                            <th>Daerah</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mac</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Ogo</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Dis</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formC_kilang as $shuttle)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td style="text-align:left">{{ $shuttle->nama_kilang }}</td>
                                                <td>{{ $shuttle->negeri_id }}</td>
                                                <td>{{ $shuttle->daerah_id }}</td>
                                                <td>{{ $shuttle->no_ssm }}</td>
                                                <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>

                                                <td>
                                                    @foreach ($formC as $data)
                                                        @if ($shuttle->id == $data->shuttle_id)
                                                            @if ($data->status == 'Tidak Diisi' && $data->bulan == '1')

                                                                <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                    style="color: grey; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang ditutup"></i>


                                                            @elseif($data->status =="Tidak Lengkap" && $data->bulan
                                                                =='1' &&
                                                                $shuttle->id == $data->shuttle_id)
                                                               <img src="{{ asset('history.png') }}" height='30px' alt=""
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang tidak lengkap "></i>

                                                            @elseif($data->status =="Sedang Diproses" &&
                                                                $data->bulan
                                                                =='1' && $shuttle->id = $data->shuttle_id)
                                                                <i class="fas fa-sync"
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang belum disahkan PHD "></i>
                                                            @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                                $data->bulan =='1' && $shuttle->id =
                                                                $data->shuttle_id)
                                                                <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                                    class="btn btn-primary"> <i class="fas fa-eye"
                                                                        style="color: white; font-size: 18pt;"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        title="Borang perlu disahkan"></i></a>
                                                            @elseif($data->status =="Lulus" &&
                                                                $data->bulan =='1' && $shuttle->id =
                                                                $data->shuttle_id)
                                                                <img src="{{ asset('check.png') }}" height='30px' alt=""
                                                                    style="color: green; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang telah disahkan"></i>

                                                            @elseif($data->status =="Tiada Pengeluaran" &&
                                                                $data->bulan =='1' && $shuttle->id =
                                                                $data->shuttle_id)
                                                                <i class="fas fa-times"
                                                                    style="color: #dbd400; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang belum disahkan PHD "></i>
                                                            @else
                                                                <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                                    style="color: grey; font-size: 20pt;"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Borang ditutup"></i>
                                                            @break

                                                        @endif
                                                    @endif
                                        @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '2')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='2' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='2' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='2' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='2' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='2' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '3')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='3' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='3' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='3' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='3' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='3' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '4')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='4' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='4' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='4' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='4' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='4' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '5')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='5' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='5' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='5' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='5' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='5' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '6')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>

                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='6' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='6' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='6' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='6' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='6' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '7')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>

                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='7' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='7' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='7' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='7' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='7' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '8')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>

                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='8' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='8' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='8' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='8' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='8' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '9')


                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='9' &&
                                                        $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='9' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='9' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='9' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='9' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '10')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>

                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='10'
                                                        && $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='10' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-sync" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='10' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='10' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='10' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>



                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '11')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>



                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='11'
                                                        && $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='11' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='11' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='11' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='11' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>


                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($formC as $data)
                                                @if ($shuttle->id == $data->shuttle_id)
                                                    @if ($data->status == 'Tidak Diisi' && $data->bulan == '12')

                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>


                                                    @elseif($data->status =="Tidak Lengkap" && $data->bulan =='12'
                                                        && $shuttle->id == $data->shuttle_id)
                                                       <img src="{{ asset('history.png') }}" height='30px' alt="" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap "></i>
                                                    @elseif($data->status =="Sedang Diproses" &&
                                                        $data->bulan
                                                        =='12' && $shuttle->id = $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @elseif($data->status =="Dihantar ke IPJPSM" &&
                                                        $data->bulan =='12' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <a href="{{ route('ipjpsm.shuttle-3-view-formC', $data->shuttle_id) }}"
                                                            class="btn btn-primary"> <i class="fas fa-eye"
                                                                style="color: white; font-size: 18pt;" data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Borang perlu disahkan"></i></a>
                                                    @elseif($data->status =="Lulus" &&
                                                        $data->bulan =='12' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <img src="{{ asset('check.png') }}" height='30px' alt="" style="color: green; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang telah disahkan"></i>

                                                    @elseif($data->status =="Tiada Pengeluaran" &&
                                                        $data->bulan =='12' && $shuttle->id =
                                                        $data->shuttle_id)
                                                        <i class="fas fa-times" style="color: #dbd400; font-size: 20pt;"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang belum disahkan PHD "></i>
                                                    @else
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt=""
                                                            style="color: grey; font-size: 20pt;" data-toggle="tooltip"
                                                            data-placement="bottom" title="Borang ditutup"></i>
                                                    @break
                                                @endif
                                            @endif
                                            @endforeach
                                        </td>



                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ URL::previous() }}" style="color:white">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->


    </div>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     Livewire.hook('component.initialized', (component) => {
        //         console.log(component);
        //         $(document).ready(function() {
        //             $('#example').DataTable();
        //         });
        //     })
        // });
    </script>

    <script>
        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/admin/shuttle-4-listC/" + year +"'); ?>";
        }
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
            ordering : false,
                "language": {
                    "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
                    "zeroRecords": "Maaf, tiada rekod.",
                    "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada rekod yang tersedia",
                    "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
                    "search": "Carian",
                    "previous": "Sebelum",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Seterusnya",
                        "previous": "Sebelumnya"
                    },
                },
            });
        });

        $(window).on('changed', (e) => {
            // if($('#example').DataTable().clear().destroy()){
            // $('#example').DataTable();
            // }
        });

        // document.getElementById("form_type").onchange = function() {
        //     myFunction()
        // };

        // function myFunction() {
        //     console.log('asasa');
        //     table.clear().draw();
        // }
    </script>

    <script>
        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

@endsection
