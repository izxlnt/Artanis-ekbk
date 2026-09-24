@extends('layouts.layout-ibk-nicepage')

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
            @if (session()->has('message'))
            <div class="row">
                <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                </div>
            </div>
            @endif

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="select_year" id="select_year" class="form-control"
                                        onchange="return changePage();">

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
                                        <a type="button " href="{{ route('user.shuttle-3-listA', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:black">Borang 3A</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listB', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#e72cc8f3">Borang 3B</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listC', date('Y')) }}"
                                            class="btn"
                                            style="background-color:#f3e741f3;color:black;border-color:#f3e741f3">Borang
                                            3C</a>
                                        <a type="button" href="{{ route('user.shuttle-3-listD', date('Y')) }}"
                                            class="btn"
                                            style="background-color:white;color:black;border-color:#1b9e21f3">Borang 3D</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                            <h4 class="text-center">PENYATA SHUTTLE 3 - KILANG PAPAN</h4>

                                <h4 class="text-center">BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK DAN PENGELUARAN KAYU GERGAJI
                                    MENGIKUT KUMPULAN KAYU-KAYAN</h4>
                            </div>
                            <br>
                            <div class="">
                                <table class="text-center table-bordered" style="width:100%;">
                                    <thead style="background-color:#f3e741f3">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No. Lesen</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($list as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align:left">{{ $data->nama_kilang }}</td>
                                                <td>{{ $data->no_ssm }}</td>
                                                <td>{{ $data->no_lesen }}</td>
                                                <td>
                                                    @if($data->bulan == 1)
                                                    Januari
                                                    @elseif($data->bulan == 2)
                                                    Februari
                                                    @elseif($data->bulan == 3)
                                                    Mac
                                                    @elseif($data->bulan == 4)
                                                    April
                                                    @elseif($data->bulan == 5)
                                                    Mei
                                                    @elseif($data->bulan == 6)
                                                    Jun
                                                    @elseif($data->bulan == 7)
                                                    Julai
                                                    @elseif($data->bulan == 8)
                                                    Ogos
                                                    @elseif($data->bulan == 9)
                                                    September
                                                    @elseif($data->bulan == 10)
                                                    Oktober
                                                    @elseif($data->bulan == 11)
                                                    November
                                                    @elseif($data->bulan == 12)
                                                    Disember
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- Same wording as the Tindakan icon (see partials/status-label). --}}
                                                    @include('partials.status-label', ['role' => 'IBK', 'form' => $data])
                                                </td>

                                                <td>
                                                    @if ($data->status == 'Tidak Lengkap')
                                                        <a href="{{ route('edit-form3c', $data->id) }}"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Borang tidak lengkap">
                                                            <img src="{{ asset('history.png') }}" height='30px' alt=""></a>
                                                    @elseif($data->status == 'Tidak Diisi')
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt=""
                                                            style="color:red;font-size:25pt"
                                                            data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
                                                    @elseif($data->status == 'Sedang Diisi')
                                                        {{-- Per the official status spec, IBK sees "belum diisi" and "sedang diisi" as the same icon. --}}
                                                        <img src="{{ asset('circle_times.png') }}" height='30px' alt=""
                                                            style="color:red;font-size:25pt"
                                                            data-toggle="tooltip" data-placement="bottom" title="Borang sedang diisi">
                                                    @elseif($data->status == 'Sedang Diproses')
                                                        <img src="{{ asset('circle_check_yellow.png') }}" height='30px' alt=""
                                                            data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
                                                    @elseif($data->status == 'Tiada Pengeluaran')
                                                        <img src="{{ asset('tp_logo2.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar - Tiada Pengeluaran">
                                                    @elseif($data->status == 'Ditutup')
                                                        <img src="{{ asset('calendar.png') }}" height='30px' alt="" data-toggle="tooltip" data-placement="bottom" title="Borang ditutup">
                                                    @elseif(in_array($data->status, ['Lulus', 'Dihantar ke IPJPSM']))
                                                        <img src="{{ asset((!empty($data->tiada_pengeluaran) && $data->tiada_pengeluaran == 1) ? 'tpbiru.png' : 'circle_check.png') }}" height='30px' alt=""
                                                            data-toggle="tooltip" data-placement="bottom" title="{{ (!empty($data->tiada_pengeluaran) && $data->tiada_pengeluaran == 1) ? 'Borang telah disahkan PHD - Tiada Pengeluaran' : 'Borang telah disahkan PHD' }}">
                                                    @else
                                                        <a href="" class="mr-1 btn btn-dark disabled"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                </td>


                                                @empty
                                                <tr >
                                                    <td colspan="7">

                                                        Tiada Data
                                                    </td>
                                                </tr>

                                        @endforelse
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <a class="btn btn-primary" href="{{  route('home-user')  }}" style="color:white">Kembali</a>
                                </div>
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
        function changePage() {

            var year = $("#select_year").val();

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-3-listC/" + year +"'); ?>";
        }
    </script>

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

    {{-- <style >

    table, th, td {
      border: 1px solid black;
    }
    </style> --}}



@endsection
