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
        <div class="col-md-12" style="padding-top: 1% ; text-align:center">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body" style="width: 100%">
                        <div class="row">
                            <div class="col-md-12">
                                <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-shuttle-3') }}">Shuttle 3</a>
                                <a class="btn btn-secondary" href="{{ route('ipjpsm.status-permohonan-shuttle-4') }}">Shuttle 4</a>
                                <a class="btn btn-secondary" href="{{ route('ipjpsm.status-permohonan-shuttle-5') }}">Shuttle 5</a>

                            </div>
                         </div>
                        <br><br>
                        <div><h3>STATUS PERMOHONAN INDUSTRI BERASAS KAYU (IBK)</h3></div>
                        <br>
                        <div class="row">
                            <div class="col-md-12" style="text-align:left">
                                <a class="btn btn-secondary" href="{{ route('ipjpsm.status-permohonan-shuttle-3') }}">Pengguna Kilang</a>
                                <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-shuttle-3-kilang') }}">Kilang</a>

                            </div>
                         </div>
                         <br>
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead style="background-color:#ee8dcd">
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Penuh</th>
                                        <th>No. SSM</th>
                                        <th>No. Lesen</th>
                                        <th>Jenis Kilang</th>
                                        <th>Tarikh Permohonan</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $data)
                                    @if($data->kategori_pengguna =='IBK')
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align:left">{{ $data->name }}</td>
                                        <td>{{ $data->login_id }}</td>
                                        <td>{{ $data->shuttle->no_lesen }}</td>
                                        @if( $data->shuttle_type == '3')
                                        <td class="txt-oflo">Kilang Papan</td>
                                        @elseif( $data->shuttle_type == '4')
                                        <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                        @else
                                        <td class="txt-oflo">Kilang Kayu Kumai</td>
                                        @endif
                                        <td>{{ $data->created_at }}</td>

                                        @if($data->is_approved == '1')
                                        <td><span class="label label-success label-rounded">Lulus</span> </td>
                                        @elseif($data->is_approved == '0')
                                        <td><span class="label label-danger label-rounded">Belum Diluluskan</span> </td>
                                        @else
                                        <td><span class="label label-info label-rounded">Tiada Data</span> </td>
                                        @endif
                                        <td> <a href="{{ route('ipjpsm.lampiran-permohonan-pengguna',$data->id) }}"  class="mr-1 btn btn-success"><i
                                                    class="far fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
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
</div>
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
