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
    <div class="container-fluid" style="width:100%">
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

                    <div class="card-body" style="width: 100%">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="form_type" class="form-control">
                                    <option value="3A">2021</option>
                                    <option value="3B">2020</option>
                                    <option value="3C">2019</option>
                                    <option value="3D">2018</option>
                                </select>
                            </div>
                         </div>
                        <br><br>
                        <div><h3>Status Pengurusan Pengguna</h3></div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Kad Pengenalan</th>
                                        <th>Nama Penuh</th>
                                        <th>Gelaran Jawatan</th>
                                        <th>Negeri/Bahagian</th>
                                        <th>Peranan</th>
                                        <th>Status</th>
                                        <th>Tindakan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user as $data)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->login_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->jawatan }}</td>
                                        <td>{{ $data->negeri }}</td>
                                        <td>{{ $data->peranan }}</td>
                                        @if($data->status==1)
                                        <td class="txt-oflo">Aktif</td>
                                        @else
                                        <td class="txt-oflo">Tidak Aktif</td>
                                        @endif
                                        <td><a href="{{ route('phd.lampiran-permohonan-pengguna',$data->id) }}"  class="mr-1 btn btn-success"><i
                                            class="far fa-eye"></i></a>
                                    <button class="btn btn-danger" type="button"><i
                                            class="fas fa-trash-alt"></i></button></td>


                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center form-group m-b-0">
                                <a href="{{ route('bpm.tambah-pengurusan-pengguna-bpm') }}" type="button" class="btn btn-primary">Tambah Pengguna</a>

                            </div>

                            <br>
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

<script>
    @if (Session::get('success'))
        toastr.success('{{ session('success') }}', 'Berjaya', { "progressBar": true });
    @elseif ($message = Session::get('error'))
        toastr.error('{{ session('error') }}', 'Ralat', { "progressBar": true });
    @endif
</script>

@endsection




