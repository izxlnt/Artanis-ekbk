@extends('layouts.layout-phd-nicepage')

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
                        <div><h4>SENARAI TUGASAN</h4></div>
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Bil</th>
                                        <th>Nama Kilang</th>
                                        <th>Jenis Kilang</th>
                                        <th>Status</th>
                                        <th>Jenis Lampiran</th>
                                        <th>Tarikh</th>
                                        <th>Tindakan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formB as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Kilang Papan Lapis</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                            @else
                                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                                            @endif
                                            <td>
                                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                            </td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Shuttle 3B</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Shuttle 4B</td>
                                            @else
                                            <td class="txt-oflo">Shuttle 5B</td>
                                            @endif
                                            <td>{{ $data->updated_at }}</td>
                                            <td> <a href="{{ route('ipjpsm.shuttle-3-view-formB',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                            </td>
                                    @endforeach

                                    @foreach ($formC as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Kilang Papan Lapis</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                            @else
                                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                                            @endif
                                            <td>
                                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                            </td>

                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Shuttle 3C</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Shuttle 4C</td>
                                            @else
                                            <td class="txt-oflo">Shuttle 5C</td>
                                            @endif

                                            <td>{{ $data->updated_at }}</td>
                                            <td> <a href="{{ route('ipjpsm.shuttle-3-view-formC',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                            </td>
                                    @endforeach

                                    @foreach ($formD as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Kilang Papan Lapis</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                            @else
                                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                                            @endif
                                            <td>
                                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                            </td>
                                            <td>
                                                Shuttle 3D
                                            </td>
                                            <td>{{ $data->updated_at }}</td>
                                            <td> <a href="{{ route('ipjpsm.shuttle-3-view-formD',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                            </td>
                                    @endforeach

                                    @foreach ($form4D as $data)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $data->nama_kilang}}</td>
                                            @if( $data->shuttle_type == '3')
                                            <td class="txt-oflo">Kilang Papan Lapis</td>
                                            @elseif( $data->shuttle_type == '4')
                                            <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                            @else
                                            <td class="txt-oflo">Kilang Kayu Kumai</td>
                                            @endif
                                            <td>
                                                <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                            </td>
                                            <td>
                                                Shuttle 4D
                                            </td>
                                            <td>{{ $data->updated_at }}</td>
                                            <td> <a href="{{ route('ipjpsm.shuttle-4-view-formD',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                            </td>
                                    @endforeach

                                    @foreach ($form4E as $data)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->nama_kilang}}</td>
                                        @if( $data->shuttle_type == '3')
                                        <td class="txt-oflo">Kilang Papan Lapis</td>
                                        @elseif( $data->shuttle_type == '4')
                                        <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                        @else
                                        <td class="txt-oflo">Kilang Kayu Kumai</td>
                                        @endif
                                        <td>
                                            <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                        </td>
                                        <td>
                                            Shuttle 4E
                                        </td>
                                        <td>{{ $data->updated_at }}</td>
                                        <td> <a href="{{ route('ipjpsm.shuttle-4-view-formE',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                    class="fas fa-pencil-alt"></i></a>

                                        </td>
                                @endforeach

                                @foreach ($form5D as $data)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $data->nama_kilang}}</td>
                                    @if( $data->shuttle_type == '3')
                                    <td class="txt-oflo">Kilang Papan Lapis</td>
                                    @elseif( $data->shuttle_type == '4')
                                    <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                    @else
                                    <td class="txt-oflo">Kilang Kayu Kumai</td>
                                    @endif
                                    <td>
                                        <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                    </td>
                                    <td>
                                        Shuttle 5D
                                    </td>
                                    <td>{{ $data->updated_at }}</td>
                                    <td> <a href="{{ route('ipjpsm.shuttle-5-view-formD',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                                class="fas fa-pencil-alt"></i></a>

                                    </td>
                            @endforeach

                            @foreach ($form5E as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->nama_kilang}}</td>
                                @if( $data->shuttle_type == '3')
                                <td class="txt-oflo">Kilang Papan Lapis</td>
                                @elseif( $data->shuttle_type == '4')
                                <td class="txt-oflo">Kilang Papan Lapis/Venir</td>
                                @else
                                <td class="txt-oflo">Kilang Kayu Kumai</td>
                                @endif
                                <td>
                                    <span class="label label-warning label-rounded">{{ $data->status }}</span>
                                </td>
                                <td>
                                    Shuttle 5E
                                </td>
                                <td>{{ $data->updated_at }}</td>
                                <td> <a href="{{ route('ipjpsm.shuttle-5-view-formE',$data->shuttle_id) }}" class="mr-1 btn btn-success"><i
                                            class="fas fa-pencil-alt"></i></a>

                                </td>
                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
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
