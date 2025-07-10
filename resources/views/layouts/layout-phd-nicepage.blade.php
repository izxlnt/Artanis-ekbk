<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Halaman Utama Pengguna</title>
    @livewireStyles
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="target-densitydpi=device-dpi">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- toastr --}}
    <link href="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.css') }}" rel="stylesheet">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png')  }}">

    <!-- font-awesome icon -->
    <link rel="stylesheet" href="{{ asset('nice-admin/icon/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('nice-admin/icon/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('nice-admin/icon/css/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('nice-admin/icon/css/solid.css') }}">


    <link rel="stylesheet" href="{{ asset('nice-admin/assets/libs/magnific-popup/dist/magnific-popup.css') }}">


    {{-- focus input box --}}
    <style>
        input:focus {
          /* background-color: yellow; */

          border: solid 3px black;
        }
        </style>
    <!-- Custom CSS -->
    {{-- <link href="{{ asset('nice-admin/assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('nice-admin/assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('nice-admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" /> --}}

    <!-- Custom CSS -->
    <link href="{{ asset('nice-admin/dist/css/style.min.css') }}" rel="stylesheet">

    <script src="{{ asset('nice-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>

    {{-- Datatables --}}
    <link href="{{ asset('nice-admin/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
        rel="stylesheet" />

    {{-- Datatables --}}
    <script src="{{ asset('nice-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/pages/datatable/datatable-basic.init.js') }}"></script>



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- NICE PAGE DEVELOPMENT END HERE!!! --}}

    <style>
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey;
            border-radius: 10px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: rgb(90, 90, 90);
            border-radius: 10px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #4b4b4b;
        }

        .required:after {
            content: " *";
            color: red;
        }

        /* font */
        .sispaa {
            font-weight: bold;
            color: #000;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }

        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }

        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }

        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }

        .dropdown-submenu.pull-left {
            float: none;
        }

        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }

    </style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="float-left navbar-nav">


                        <span class="logo-text" style="align:left;">

                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/94/Jata_MalaysiaV2.svg/1200px-Jata_MalaysiaV2.svg.png"
                                style="height: 50px;" alt="homepage" class="dark-logo" />
                        </span>

                        <span class="logo-icon" style="align:left;">

                            <img src="https://www.forestry.gov.my/images/halaman/logo-jpsm.jpg" style="height: 50px;"
                                alt="homepage" class="dark-logo" />

                        </span>
                    </ul>
                    <ul class="mr-auto navbar-nav" style="text-align:center;margin-left: auto !important">
                        <span class=""
                            style="color: #000; font-weight: bold; font-size: 20px;text-align:center;">SISTEM eSHUTTLE<br>
                            JABATAN PERHUTANAN SEMENANJUNG MALAYSIA
                        </span>

                    </ul>
                    <ul class="float-right navbar-nav">
                        <!-- ============================================================== -->
                        <!-- Notification -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown border-right">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-bell-outline font-22"></i>
                                <span class="badge badge-pill badge-info noti">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <ul class="list-style-none">
                                    <li>
                                        <div class="drop-title bg-primary text-white">
                                            <h4 class="m-b-0 m-t-5" style="color: #000">{{ auth()->user()->unreadNotifications->count() }} Notifikasi</h4>
                                            <span class="font-light" style="color: #000">Baharu</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-center notifications">
                                            <!-- Message -->
                                            @foreach(auth()->user()->unreadNotifications as $notification)
                                            <a href="{{ route('notification.show', $notification->id) }}" class="message-item">
                                                <span class="btn btn-danger btn-circle">
                                                    <i class="fab fa-wpforms"></i>
                                                </span>
                                                <div class="mail-contnet">
                                                    <h5 class="message-title">{{ $notification->data['tajuk'] }}</h5>
                                                    {{-- <span class="mail-desc">Just see the my new admin!</span> --}}
                                                    <span class="time">{{ date('d-m-Y H:i:s', strtotime($notification->created_at))  }}</span>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                    </li>
                                    {{-- <li>
                                        <a class="nav-link text-center m-b-5 text-dark" href="javascript:void(0);">
                                            <strong>Check all notifications</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Notification -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <img src="{{asset('nice-admin/assets/images/users/2.jpg')}}" alt="user"
                                class="rounded-circle" width="40"> --}}
                                <span class="font-medium m-l-5 d-none d-sm-inline-block">{{ Auth::user()->name }} <i
                                        class="mdi mdi-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-primary"></span>
                                </span>
                                <div class="text-white d-flex no-block align-items-center p-15 m-b-10"
                                    style="padding: 15px;background-color: #f3ce8f">
                                    {{-- <div class="">
                                        <img src="{{asset('nice-admin/assets/images/users/2.jpg')}}" alt="user"
                                    class="rounded-circle" width="60">
                                </div> --}}
                                    <div class="m-l-10">
                                        <h4 class="m-b-0">{{ Auth::user()->name }}</h4>
                                        <p class=" m-b-0">{{ Auth::user()->email }}</p>
                                        <p class=" m-b-0">{{ Auth::user()->negeri }}</p>
                                        <p class=" m-b-0">PHD - {{ Auth::user()->daerah }}</p>


                                        {{-- <p class=" m-b-0">Pengguna</p> --}}
                                    </div>
                                </div>
                                <a class="dropdown-item" href="{{ route('phd.kemaskini-profil') }}">
                                    <i class="ti-user m-r-5 m-l-5"></i> Kemaskini Profil Pengguna</a>




                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="{{ route('tukar-kata-laluan') }}">

                                    <i class="fas fa-unlock-alt"></i> Tukar Kata Laluan</a>


                                <div class="dropdown-divider"></div>


                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                                    <i class="fa fa-power-off m-r-5 m-l-5"></i> Log Keluar</a>
                                <!-- <div class="dropdown-divider"></div> -->
                                <!-- <div class="p-10 p-l-30" style="padding: 10px;">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a>
                                </div> -->
                            </div>

                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </nav>
        </header>



        {{-- <div class="container" style="background-color: #4c32e9;">
        <div class="row" style="justify-content: space-around;">
            <a role="button" class="btn btn-primary" href="{{ route('home') }}"> <i class="fas fa-home fa-lg "></i> &nbsp Laman Utama <span class="caret"></span></a>

            <div class="dropdown">
                <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#"
                    href="#"> <i class="fas fa-bars fa-lg"></i> &nbsp Menu Utama Modul <span class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-submenu" >
                        <a tabindex="-1" href="#" >Kemasukan Maklumat</a>
                        <ul class="dropdown-menu">

                            <li class="dropdown-submenu">
                                <a href="{{ route('shuttle-3') }}">Shuttle 3- Kilang Papan</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('shuttle-3-formA') }}">Shuttle 3 - Borang 3A</a></li>
                                    <li><a href="{{ route('shuttle-3-formB') }}">Shuttle 3 - Borang 3B</a></li>
                                    <li><a href="{{ route('shuttle-3-formC') }}">Shuttle 3 - Borang 3C</a></li>
                                    <li><a href="#">Shuttle 3 - Borang 3D</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">Shuttle 4- Kilang Papan</a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Shuttle 4 - Borang 4A</a></li>
                                    <li><a href="#">Shuttle 4 - Borang 4B</a></li>
                                    <li><a href="#">Shuttle 4 - Borang 4C</a></li>
                                    <li><a href="#">Shuttle 4 - Borang 4D</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="#">Shuttle 5- Kilang Papan</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Shuttle 5 - Borang 5A</a></li>
                                    <li><a href="#">Shuttle 5 - Borang 5B</a></li>
                                    <li><a href="#">Shuttle 5 - Borang 5C</a></li>
                                    <li><a href="#">Shuttle 5 - Borang 5D</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#">Carian Maklumat</a></li>
                    <li><a href="#">Laporan</a></li>
                    <li><a href="#">Pengurusan Pengguna</a></li>

                    <li class="dropdown-submenu">
                        <a href="#">Pengurusan Data Asas</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Hak Milik Syarikat</a></li>
                            <li><a href="#">Jenis Kayu Kumai</a></li>
                            <li><a href="#">Jenis Pembeli - Shuttle 3 (Kilang Papan)</a></li>
                            <li><a href="#">Jenis Pembeli - Shuttle 4 (Kilang Papan Lapis/Venir)</a></li>
                            <li><a href="#">Kategori Pekerja</a></li>
                            <li><a href="#">Kewarganegaraan</a></li>
                            <li><a href="#">Kumpulan Kayu Kayan</a></li>
                            <li><a href="#">Spesies</a></li>
                            <li><a href="#">Spesies Aktif</a></li>
                            <li><a href="#">Status Operasi</a></li>
                            <li><a href="#">Taraf Sah Syarikat</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="dropdown">
                <a id="dLabel" role="button" data-toggle="dropdown" class="btn btn-primary" data-target="#"
                    href="#"> <i class="fas fa-info-circle fa-lg"></i> &nbsp Bantuan <span class="caret"></span></a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li><a href="#">Panduan Pentadbir Modul</a></li>
                    <li><a href="#">Panduan Pengguna Modul</a></li>
                </ul>
            </div>
            <a role="button" data-toggle="dropdown" class="btn btn-primary" href="#"> <i class="fas fa-exchange-alt fa-lg"></i> &nbsp Tukar Modul<span
                class="caret"></span></a>
        </div>
    </div> --}}

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark"
                                href="{{ route('home') }}" aria-expanded="false"><i
                                    class="mdi mdi-home-variant"></i><span class="hide-menu"
                                    style="padding-left: 10px;font-size: large;">Laman Utama</span></a>

                        </li>



                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-view-module"></i><span
                                    class="hide-menu" style="padding-left: 10px;font-size: large;">Pengesahan
                                    Maklumat</span></a>
                            <ul aria-expanded="false" class="collapse first-level">



                                <li class="sidebar-item"><a href="#"
                                        class="sidebar-link has-arrow waves-effect waves-dark">&nbsp&nbsp <i
                                            class="fas fa-file"></i>&nbsp&nbsp&nbsp <span class="hide-menu">
                                            Pengesahan Borang
                                        </span></a>
                                    <ul aria-expanded="false" class="collapse second-level">


                                        <li class="sidebar-item"><a
                                                href="{{ route('phd.shuttle-3-listA', date('Y')) }}"
                                                class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                                    class="hide-menu">&nbsp Shuttle 3 - Kilang Papan</span></a>
                                        </li>
                                        <li class="sidebar-item"><a
                                                href="{{ route('phd.shuttle-4-listA', date('Y')) }}"
                                                class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                                    class="hide-menu"> &nbsp
                                                    Shuttle 4 - Kilang Papan Lapis/Venir</span></a></li>
                                        <li class="sidebar-item"><a href="{{ route('phd.shuttle-5-listA', date('Y')) }}"
                                                class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                                    class="hide-menu"> &nbsp
                                                    Shuttle 5 - Kilang Kayu Kumai</span></a></li>
                                    </ul>
                                </li>

                                <li class="sidebar-item"><a href="#"
                                    class="sidebar-link has-arrow waves-effect waves-dark">&nbsp&nbsp <i
                                        class="fas fa-cubes"></i>&nbsp&nbsp&nbsp <span class="hide-menu">
                                        Pengesahan Pakej
                                    </span></a>
                                <ul aria-expanded="false" class="collapse second-level">


                                    <li class="sidebar-item"><a
                                        href="{{ route('phd.batch.s3', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                            class="hide-menu">&nbsp Shuttle 3 - Kilang Papan</span></a>
                                </li>
                                <li class="sidebar-item"><a
                                        href="{{ route('phd.batch.s4', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                            class="hide-menu"> &nbsp
                                            Shuttle 4 - Kilang Papan Lapis/Venir</span></a></li>
                                <li class="sidebar-item"><a href="{{ route('phd.batch.s5', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                            class="hide-menu"> &nbsp
                                            Shuttle 5 - Kilang Kayu Kumai</span></a></li>
                            </ul>
                        </li>

                                <li class="sidebar-item"><a href="#"
                                        class="sidebar-link has-arrow waves-effect waves-dark">&nbsp&nbsp <i
                                            class="fas fa-bell"></i>&nbsp&nbsp&nbsp <span class="hide-menu">
                                            Notifikasi Kilang
                                        </span></a>
                                    <ul aria-expanded="false" class="collapse second-level">
                                        <li class="sidebar-item"><a href="{{ route('phd.notifikasi-kilang.s3') }}"
                                                class="sidebar-link"><i class="mdi mdi-priority-low"></i><span
                                                    class="hide-menu">&nbsp
                                                    Shuttle 3 - Kilang Papan</span></a></li>
                                        <li class="sidebar-item"><a href="{{ route('phd.notifikasi-kilang.s4') }}" class="sidebar-link"><i
                                                    class="mdi mdi-priority-low"></i><span class="hide-menu"> &nbsp
                                                    Shuttle 4 - Kilang Papan Lapis/Venir</span></a></li>
                                        <li class="sidebar-item"><a href="{{ route('phd.notifikasi-kilang.s5') }}" class="sidebar-link"><i
                                                    class="mdi mdi-priority-low"></i><span class="hide-menu"> &nbsp
                                                    Shuttle 5 - Kilang Kayu Kumai</span></a></li>
                                    </ul>
                                </li>

                                <li class="sidebar-item"><a href="{{ route('phd.pengumuman')}}"
                                    class="sidebar-link"><i class="mdi mdi-adjust"></i><span
                                        class="hide-menu">&nbsp Pengumuman IBK</span></a>
                            </li>

                            </ul>
                        </li>






                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="fas fa-file"></i><span class="hide-menu"
                                    style="padding-left: 10px;font-size: large;">Status Borang</span></a>
                            <ul aria-expanded="false" class="collapse first-level">

                                <li class="sidebar-item"><a href="{{ route('phd.senarai-tugasan-3A', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-adjust"></i><span
                                            class="hide-menu">&nbsp Shuttle 3 - Kilang Papan</span></a>
                                </li>

                                <li class="sidebar-item"><a href="{{ route('phd.senarai-tugasan-4A', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-adjust"></i><span
                                            class="hide-menu">&nbsp
                                            Shuttle 4 - Kilang Papan Lapis/Venir</span></a>
                                </li>
                                <li class="sidebar-item"><a href="{{ route('phd.senarai-tugasan-5A', date('Y')) }}"
                                        class="sidebar-link"><i class="mdi mdi-adjust"></i><span
                                            class="hide-menu">&nbsp
                                            Shuttle 5 - Kilang Kayu Kumai</span></a>
                                </li>

                            </ul>

                        </li>


                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-television-guide"></i><span class="hide-menu"
                                    style="padding-left: 10px;font-size: large;">Bantuan</span></a>
                            <ul aria-expanded="false" class="collapse first-level">

                                <li class="sidebar-item"><a target="_blank" href="{{ asset('Manual_PHD.pdf') }}"
                                        class="sidebar-link"><i class="mdi mdi-collage"></i><span
                                            class="hide-menu">&nbsp Panduan Pentadbir
                                            Modul</span></a>
                                </li>

                                {{-- <li class="sidebar-item"><a href="{{ route('taraf-syarikat') }}"
                                        class="sidebar-link"><i class="mdi mdi-adjust"></i><span
                                            class="hide-menu">&nbsp Panduan Pengguna
                                            Modul</span></a>
                                </li> --}}

                            </ul>

                        </li>




                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <br>
        <div class="page-wrapper">
            @if ($message = Session::get('success'))
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#modal').modal();
                    });
                </script>
                {{-- <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content alert alert-card alert-success">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Successful!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
            @elseif ($message = Session::get('error'))
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#error_modal').modal();
                    });
                </script>
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content alert alert-card warning-danger">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Failed!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @livewireScripts
            <div class="container-fluid" style="height:100%">
                @yield('content')
            </div>




        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <footer class="text-center footer" style="bottom:0;text-align:center;left:0; color: rgb(0, 0, 0) !important;background-image: url(/bghutan.png); background-position: bottom; opacity: 0.75;">
        <span style=" color: rgb(255, 255, 255)">Hakcipta Terpelihara © 2021. SISTEM eSHUTTLE. <br>
        Paparan terbaik untuk sistem ini adalah 1920x1080 resolusi piksel.</span>
    </footer>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('nice-admin/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/app.init.horizontal.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/app-style-switcher.horizontal.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('nice-admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('nice-admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('nice-admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('nice-admin/dist/js/custom.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    {{-- <script src="{{ asset('nice-admin/assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}">
    </script> --}}
    <!--c3 charts -->
    {{-- <script src="{{ asset('nice-admin/assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/c3/c3.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('nice-admin/dist/js/pages/dashboards/dashboard1.js') }}"></script> --}}
    {{-- font-awesome icon --}}
    <script src="{{ asset('nice-admin/icon/js/all.js') }}"></script>
    <script src="{{ asset('nice-admin/icon/js/brands.js') }}"></script>
    <script src="{{ asset('nice-admin/icon/js/solid.js') }}"></script>
    <script src="{{ asset('nice-admin/icon/js/fontawesome.js') }}"></script>



    <script src="{{ asset('nice-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>


    <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(function() {
                $("#message").remove(); //tambah untuk remove flash message
            }, 5000); // 5 secs  (1 sec = 1000)
        });
    </script>
    @yield('script')
    <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
                return false;
            return true;
        }
    </script>

    {{-- toaster --}}
    <script src="{{ asset('nice-admin/assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('nice-admin/assets/extra-libs/toastr/toastr-init.js') }}"></script>

    {{-- toaster display --}}
    <script>
        toastr.options.fadeOut = 2500;

        @if (Session::get('success'))
            toastr.success('{{ session('success') }}', 'Berjaya', { "progressBar": true });
        @elseif ($message = Session::get('error'))
            toastr.error('{{ session('error') }}', 'Ralat', { "progressBar": true });
        @endif
    </script>
    <!-- ============================================================== -->
    <!-- END Jquery NICE PAGE -->
    <!-- ============================================================== -->
</body>

</html>
