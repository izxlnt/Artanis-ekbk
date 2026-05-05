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
                                                <a href="{{ $breadcrumb['link'] }}" style="color: white !important;"
                                                    onMouseOver="this.style.color='lightblue'"
                                                    onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                                </a>
                                            </li>
                                        @else
                                            <li class="breadcrumb-item active" aria-current="page"
                                                style="color: #dbd400 !important;">
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
                                        <option value="" selected hidden disabled>
                                            2025
                                        </option>
                                        @foreach ($year_list as $data)
                                            <option value="{{ $data->tahun }}"
                                                {{ $data->tahun == $year ? 'selected' : '' }}>
                                                Tahun {{ $data->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                                                @include('partials.borang-nav', ['shuttle_type' => 5, 'current_form' => 'D', 'role' => 'ipjpsm'])
                            </div>
                            <div class="pt-5 row">
                                <div class="col-md-12">

                                    <h4 class="text-center">SENARAI PENUH MAKLUMAT BORANG - BORANG 5D</h4>

                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead style="background-color:rgb(33, 235, 77);">
                                        <tr>
                                            <th>Bil</th>
                                            <th>Nama Kilang</th>
                                            <th>Negeri</th>
                                            <th>Daerah Hutan</th>
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
                                        @foreach ($list_kilang as $shuttle)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="text-align:left">{{ $shuttle->nama_kilang }}</td>
                                                <td>{{ $shuttle->negeri_id }}</td>
                                                <td>{{ $shuttle->daerah_id }}</td>
                                                <td>{{ $shuttle->no_ssm }}</td>
                                                <td>{{ $shuttle->no_lesen ?? 'Tiada' }}</td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][1] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][1] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][2] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][2] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][3] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][3] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][4] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][4] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][5] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][5] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][6] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][6] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][7] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][7] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][8] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][8] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][9] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][9] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][10] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][10] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][11] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][11] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                                <td>
                                                    @php $data = $form5DIndex[$shuttle->id][12] ?? null; $cb = $data ? ($batchIndex[$shuttle->id][12] ?? null) : null; @endphp
                                                    @include('partials.cell-borang-monthly', ['data' => $data, 'current_batch' => $cb, 'buffer' => $buffer, 'viewRoute' => 'ipjpsm.shuttle-5-view-formD', 'batchField' => 'borang_d'])
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                            <div class="row">
                                <a class="btn btn-primary" href="{{ route('home') }}" style="color:white">Kembali</a>
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

            window.location.href = "<?php echo URL::to('/admin/borang-keseluruhan/shuttle-5/borang-D/" + year +"'); ?>";

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
                    "zeroRecords": "Tahun: {{ $year ?? date('Y') }}",
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
