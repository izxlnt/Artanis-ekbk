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
        <div class="container-fluid" style="width: 100%;">

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
                                        <a type="button " href="{{ route('user.shuttle-5-listA', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:rgb(196, 188, 186)">Borang 5A</a>
                                    <a type="button" href="{{ route('user.shuttle-5-listB', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:#e72cc8f3">Borang 5B</a>
                                    <a type="button" href="{{ route('user.shuttle-5-listC', date('Y')) }}"
                                        class="btn" style="background-color:#f3e741f3;color:black;border-color:#bbb235f3">Borang 5C</a>
                                    <a type="button" href="{{ route('user.shuttle-5-listD', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:#1b9e21f3">Borang 5D</a>
                                        <a type="button" href="{{ route('user.shuttle-5-listE', date('Y')) }}"
                                        class="btn" style="background-color:white;color:black;border-color:rgb(54, 140, 238">Borang 5E</a>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div>
                                <h4 class="text-center">BORANG 5C -  PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI DAN PENGELUARAN KAYU KUMAI MENGIKUT KUMPULAN KAYU-KAYAN</h4>
                            </div>
                            <div class="">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>No. SSM</th>
                                            <th>No.Lesen</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Tindakan</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($list as $data)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            <td>{{ $data->no_ssm }}</td>
                                            <td>{{ $data->no_lesen }}</td>
                                            <td>{{ $data->bulan }}</td>
                                            <td>
                                                @if ($data->status == 'Sedang Diproses')
                                                    <span
                                                        class="label label-warning label-rounded">{{ $data->status }}</span>
                                                @elseif($data->status =="Dihantar ke IPJPSM")
                                                    <span class="label label-warning label-rounded">Sedang
                                                        Diproses</span>
                                                @elseif($data->status =="Tidak Lengkap")
                                                    <span
                                                        class="label label-danger label-rounded">{{ $data->status }}</span>
                                                @elseif($data->status =="Lulus")
                                                    <span
                                                        class="label label-success label-rounded">Diperaku</span>
                                                @else
                                                    <span
                                                        class="label label-dark bg-dark label-rounded">{{ $data->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($data->status =="Sedang Diproses")
                                                <a href="" class="mr-1 btn btn-dark disabled"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                @elseif($data->status =="Dihantar ke IPJPSM")
                                                <a href="" class="mr-1 btn btn-dark disabled"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                @elseif($data->status =="Tidak Lengkap")
                                                <a href="{{ route('edit-form3b',$shuttle->id) }}" class="mr-1 btn btn-success"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                @else
                                                <a href="" class="mr-1 btn btn-dark disabled"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                                @endif
                                            </td>




                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

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
        function changePage(){

            var year = $( "#select_year" ).val();

            window.location.href = "<?php echo URL::to('/pengguna/shuttle-5-listC/" + year +"'); ?>";
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

{{-- <style >

    table, th, td {
      border: 1px solid black;
    }
    </style> --}}



@endsection
