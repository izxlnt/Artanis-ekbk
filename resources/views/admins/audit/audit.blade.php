@extends('layouts.layout-bpm-nicepage')


@section('content')


<div>

    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>

    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid" style="width: 100%;">

                @if (session()->has('message'))
        <div class="row" id="message">
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
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <a class="btn btn-secondary" href="{{ route('ipjpsm.status-permohonan-pengguna') }}">IBK</a>
                                <a class="btn btn-primary" href="{{ route('ipjpsm.status-permohonan-phd') }}">PHD</a>
                                <a class="btn btn-secondary" href="{{ route('ipjpsm.status-permohonan-jpn') }}">JPN</a>
                            </div>
                         </div> --}}

                        <div><h4>AUDIT TRAILS</h4></div>
                        <a class="btn btn-primary mb-2" href="{{route('user.it.auditUser')}}">Audit Keluar Masuk Pengguna</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="example" style="width: 100%;">
                                <!-- Table head -->
                                <thead style="background-color:#8ed7f8">
                                    <tr>
                                        <th class="all">No</th>
                                        <th class="all">Nama Pengguna</th>
                                        <th class="all">Alamat IP</th>
                                        <th class="all">Masa</th>
                                        {{-- <th class="all">Role</th> --}}
                                        <th class="all">Acara</th>
                                        {{-- <th class="40%">Database</th> --}}
                                        <th class="40">Data Lama</th>
                                        <th class="40">Data Baharu</th>
                                        <th class="all">URL</th>

                                    </tr>
                                </thead>
                                <!-- Table body -->
                                <tbody>

                                </tbody>
                              </table>
                              <br>

                        </div>
                        <br>
                            <br>
                        <div class="row">
                            <a class="btn btn-primary" href="{{ route('home') }}" style="color:white">Kembali</a>
                        </div>
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




<script type="text/javascript">
    $(document).ready(function() {
        var buttonCommon = {
          exportOptions: {
               // Any other settings used
               grouped_array_index: 0,
          },
        };
        var groupColumn = 1;
        var tableTitle = $('.card-title').html();
        var table = $('#example').DataTable({
          processing: false,
          serverSide: true,
          responsive: true,
          ajax: "{{ route('user.it.audit.datatable') }}",
          columns: [{
                  data: 'DT_RowIndex',
                  name: 'id'
              },
              {
                  data: 'user.name',
                  name: 'user.name'
              },
              {
                  data: 'ip_address',
                  name: 'ip_address'
              },
              {
                  data: 'created_at',
                  name: 'created_at'
              },
            //   {
            //       data: 'user.role',
            //       name: 'user.role'
            //   },
              {
                  data: 'event',
                  name: 'event'
              },
            //   {
            //       data: 'auditable_type',
            //       name: 'auditable_type'
            //   },
              {
                  data: 'old_values',
                  name: 'old_values'
              },
              {
                  data: 'new_values',
                  name: 'new_values'
              },
              {
                  data: 'url',
                  name: 'url'
              },
          ],
             dom: 'Bfrtip',
             "buttons": [
                 {
                     extend: 'excel',
                     orientation: 'landscape',
                     pageSize: 'A2',
                     title: tableTitle,
                 },
                 {
                     extend: 'pdfHtml5',
                     orientation: 'landscape',
                     pageSize: 'A2',
                     title: tableTitle,
                 },
                 {
                     extend: 'print',
                     text: 'Cetak',
                     pageSize: 'LEGAL',
                     title: tableTitle,
                     customize: function(win)
                     {
                         var last = null;
                         var current = null;
                         var bod = [];
                         var css = '@page { size: landscape; }',
                             head = win.document.head || win.document.getElementsByTagName('head')[0],
                             style = win.document.createElement('style');
                         style.type = 'text/css';
                         style.media = 'print';
                         if (style.styleSheet)
                         {
                           style.styleSheet.cssText = css;
                         }
                         else
                         {
                           style.appendChild(win.document.createTextNode(css));
                         }
                         head.appendChild(style);
                  },
                 },
             ],
         "language": {
             "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
             "zeroRecords": "Maaf, tiada rekod.",
             "info": "Memaparkan halaman _PAGE_ daripada _PAGES_",
             "infoEmpty": "Tidak ada rekod yang tersedia",
             "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
             "search": "Carian",
             "previous": "Sebelum",
             "paginate": {
                 "first":      "Pertama",
                 "last":       "Terakhir",
                 "next":       "Seterusnya",
                 "previous":   "Sebelumnya"
             },
         },
         } );
     } );
     </script>

@endsection
