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
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-12" style="padding-top: 1% ; text-align:center">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="form_type" class="form-control">
                                    <option value="3A">2021</option>
                                    <option value="3B">2020</option>
                                    <option value="3C">2019</option>
                                    <option value="3D">2018</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- <a type="button" href="{{ route('phd.shuttle-3-listA') }}" class="btn waves-effect waves-light btn-outline-info">Borang 3A</a> --}}
                                    @if($user->kategori_pengguna == 'PHD')
                                    {{-- <a type="button" href="{{ route('phd.shuttle-3-listA') }}" class="btn waves-effect waves-light btn-outline-info">Borang 3A</a> --}}
                                    <a type="button" href="{{ route('phd.shuttle-3-listB') }}" class="btn waves-effect waves-light btn-outline-info ">Borang 3B</a>
                                    <a type="button" href="{{ route('phd.shuttle-3-listC') }}" class="btn waves-effect waves-light btn-outline-info ">Borang 3C</a>
                                    <a type="button" href="{{ route('phd.shuttle-3-listD') }}" class="btn waves-effect waves-light btn-outline-info active">Borang 3D</a>

                                    @elseif($user->kategori_pengguna == 'IPJPSM')
                                    <a type="button" href="{{ route('shuttle-3-listB') }}" class="btn waves-effect waves-light btn-outline-info ">Borang 3B</a>
                                    <a type="button" href="{{ route('shuttle-3-listC') }}" class="btn waves-effect waves-light btn-outline-info">Borang 3C</a>
                                    <a type="button" href="{{ route('shuttle-3-listD') }}" class="btn waves-effect waves-light btn-outline-info active">Borang 3D</a>
                                    @endif
                                {{-- <select name="form_type" class="form-control" wire:model='form_type' id="form_type">
                                    <option value="3A">Form 3A</option>
                                    <option value="3B">Form 3B</option>
                                    <option value="3C">Form 3C</option>
                                    <option value="3D">Form 3D</option>
                                </select> --}}
                                </div>
                            </div>
                         </div>
                         <br><br>
                         <div><h4>BORANG 3D - PENYATA PENJUALAN KAYU GERGAJI DALAM PASARAN TEMPATAN DAN EKSPORT</h4></div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Negeri</th>
                                        <th>Daerah</th>
                                        <th>Nama Kilang</th>
                                        <th>No. SSM</th>
                                        <th>No.Lesen</th>
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
                                    @foreach ($shuttle_listD as $shuttle)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $shuttle->daerah_id}}</td>
                                            <td>{{ $shuttle->alamat_kilang_daerah}}</td>
                                            <td>{{ $shuttle->nama_kilang }}</td>
                                            <td>{{ $shuttle->no_ssm }}</td>
                                            <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>
                                            <td> <a href="{{ route('shuttle-3-formD') }}" class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-danger"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-danger"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-danger"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-secondary"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-secondary"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-secondary"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-secondary"><i class="mdi mdi-folder-plus"></i></a></td>
                                            <td> <a href="{{ route('shuttle-3-formC') }}" class="mr-1 btn btn-success"><i class="fas fa-pencil-alt"></i></a></td>

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
      var table = $('#example').DataTable();
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
