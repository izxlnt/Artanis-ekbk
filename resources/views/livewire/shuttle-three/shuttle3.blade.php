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
                                <a type="button" class="btn waves-effect waves-light btn-outline-info">Form A</a>
                                <a type="button" class="btn waves-effect waves-light btn-outline-info">Form B</a>
                                <a type="button" class="btn waves-effect waves-light btn-outline-info">Form C</a>
                                <a type="button" href="{{ route('home') }}" class="btn waves-effect waves-light btn-outline-info">Form D</a>
                                {{-- <select name="form_type" class="form-control" wire:model='form_type' id="form_type">
                                    <option value="3A">Form 3A</option>
                                    <option value="3B">Form 3B</option>
                                    <option value="3C">Form 3C</option>
                                    <option value="3D">Form 3D</option>
                                </select> --}}
                                </div>
                            </div>
                         </div>
                        <br>
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
                                        <th>Tindakan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shuttles as $shuttle)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $shuttle->negeri->negeri }}</td>
                                            <td>{{ $shuttle->negeri->bandar }}</td>
                                            <td>{{ $shuttle->nama_kilang }}</td>
                                            <td>{{ $shuttle->no_ssm }}</td>
                                            <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>
                                            <td> <a href={{ $route }} class="mr-1 btn btn-success"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger" type="button"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            {{ $shuttles->links() }}
                            <br>
                            <a class="btn btn-primary" href=""> Tambah </a>
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
