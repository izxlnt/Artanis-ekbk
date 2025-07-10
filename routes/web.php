<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

//Pendaftaran User
Route::get('/pendaftaran', [App\Http\Controllers\DaftarController::class, 'daftar_pilih'])->name('daftar.pilih');
Route::get('/pendaftaran/phd', [App\Http\Controllers\DaftarController::class, 'daftar_phd'])->name('daftar.phd');
Route::get('/pendaftaran/jpn', [App\Http\Controllers\DaftarController::class, 'daftar_jpn'])->name('daftar.jpn');
Route::get('/pendaftaran/hantar', [App\Http\Controllers\DaftarController::class, 'create_phd_user'])->name('daftar.phd.create');


//graph dashboard
Route::get('/data/graph/default', [App\Http\Controllers\HomeController::class, 'graph_dashboard_default'])->name('ipjpsm.graph_dashboard.default');

Route::post('/data/graph', [App\Http\Controllers\HomeController::class, 'graph_dashboard'])->name('ipjpsm.graph_dashboard');


Route::get('/register/ajax/fetch-daerah/{kod_negeri}', [App\Http\Controllers\AjaxController::class, 'fetch_daerah'])->name('ajax-daerah');
Route::get('/register/ajax/fetch-warganegara/{warganegara}', [App\Http\Controllers\AjaxController::class, 'fetch_warganegara'])->name('ajax-warganegara');
Route::get('/register/ajax/fetch-poskod/{poskod}', [App\Http\Controllers\AjaxController::class, 'poskod'])->name('ajax-poskod');
Route::get('/register/ajax/fetch-poskod-surat-menyurat/{poskod_surat}', [App\Http\Controllers\AjaxController::class, 'poskod_surat_menyurat'])->name('ajax-poskod-surat-menyurat');

Route::get('/shuttle-3-view-form3B/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_form3B'])->name('shuttle-3-view-formB');

//custom forget password
Route::get('/terlupa-kata-laluan', [App\Http\Controllers\ForgetPasswordController::class, 'forgetPassword'])->name('forget-password.show');

Route::get('/terlupa-kata-laluan/submit', [App\Http\Controllers\ForgetPasswordController::class, 'forgetPasswordSubmit'])->name('forget-password.submit');

Route::get('/password/resets/{token}/{email}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('/terlupa-kata-laluan/kemaskini-kata-laluan-baru', [App\Http\Controllers\ForgetPasswordController::class, 'customChangePassword'])->name('forget.password.update');

// //pengurusan pengguna
Route::get('/admin/pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'pengurusan_pengguna_ipjpsm'])->name('pengurusan-pengguna');
Route::get('/admin/pengurusan-pengguna-tambah', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengurusan_pengguna_ipjpsm'])->name('tambah-pengurusan-pengguna-ipjpsm');
Route::post('/admin/tambah_pengguna_ipjpsm', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengguna_ipjpsm'])->name('tambah-pengurusan-pengguna.store');


Route::get('/admin/senarai-phd', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_phd'])->name('ipjpsm.senaraiphd');
Route::get('/admin/senarai-ipjpsm', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_ipjpsm'])->name('ipjpsm.senaraiipjpsm');
Route::get('/admin/senarai-jpn', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_jpn'])->name('ipjpsm.senaraijpn');
Route::get('/admin/senarai-bpm', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_bpm'])->name('ipjpsm.senaraibpm');

Route::get('/admin/kemaskini-status-pengguna/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'updateStatusUser'])->name('ipjpsm.updateStatus');
Route::get('/admin/kemaskini-status-pengguna-aktif/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'updateStatusUserAktif'])->name('ipjpsm.updateStatusAktif');

Route::get('/admin/kemaskini-status-kilang/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'updateStatusKilang'])->name('ipjpsm.updateStatusKilang');
Route::get('/admin/kemaskini-status-kilang-aktif/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'updateStatusKilangAktif'])->name('ipjpsm.updateStatusAktifKilang');

Route::get('/admin/status-permohonan-bpe', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_bpe_ipjpsm'])->name('ipjpsm.status-permohonan-bpe');
Route::get('/admin/status-permohonan-phd', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_phd_ipjpsm'])->name('ipjpsm.status-permohonan-phd');
Route::get('/admin/status-permohonan-jpn', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_jpn_ipjpsm'])->name('ipjpsm.status-permohonan-jpn');
Route::get('/admin/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_ipjpsm'])->name('ipjpsm.lampiran-permohonan-pengguna');
Route::get('/admin/lampiran-permohonan-bpe/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_bpe'])->name('ipjpsm.lampiran-permohonan-bpe');
Route::get('/admin/lampiran-permohonan-phd/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_phd'])->name('ipjpsm.lampiran-permohonan-phd');
Route::get('/admin/lampiran-permohonan-jpn/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_jpn'])->name('ipjpsm.lampiran-permohonan-jpn');
Route::post('/admin/pengesahan-phd/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_phd_ipjpsm'])->name('sahkan_permohonan_phd_ipjpsm');


Route::get('/admin/tugasan-ibk', [App\Http\Controllers\HomeController::class, 'ajax_count_user_ibk'])->name('ajax_count_user_ibk');
Route::get('/admin/tugasan-phd', [App\Http\Controllers\HomeController::class, 'ajax_count_user_phd'])->name('ajax_count_user_phd');
Route::get('/admin/tugasan-jpn', [App\Http\Controllers\HomeController::class, 'ajax_count_user_jpn'])->name('ajax_count_user_jpn');
Route::get('/admin/tugasan-ipjpsm', [App\Http\Controllers\HomeController::class, 'ajax_count_user_bpe'])->name('ajax_count_user_bpe');

//middleware is active user?
//ambil dari kernel
Route::middleware('auth')->group(
    function () {

        Route::get('/kemaskini-profil', [App\Http\Controllers\UserController::class, 'update_profile_pengguna'])->name('kemaskini-profil');
        Route::post('/kemaskini-profil-update', [App\Http\Controllers\UserController::class, 'update_profile'])->name('kemaskini-profil-update');
        Route::get('/profil/tukar-kata-laluan', [App\Http\Controllers\UserController::class, 'change_password'])->name('tukar-kata-laluan');
        Route::post('/tukar-kata-laluan/kemaskini', [App\Http\Controllers\UserController::class, 'update_password'])->name('tukar-kata-laluan.kemaskini');

        //notification redirect user in app
        Route::get('/notifikasi/papar/{id}', [App\Http\Controllers\NotifikasiKilangController::class, 'redirect_notification'])->name('notification.show');

        Route::middleware('active_user')->group(function () {

            Route::middleware('user')->group(function () {
                Route::get('/pengguna/halaman-utama', [App\Http\Controllers\UserController::class, 'index_user'])->name('home-user');

                //pengurusan pengguna
                Route::get('/pengguna/pengurusan-pengguna', [App\Http\Controllers\UserController::class, 'user_management'])->name('home-user.user-management');
                Route::get('/pengguna/pengurusan-pengguna/tambah-pengguna-baru', [App\Http\Controllers\UserController::class, 'user_management_add'])->name('home-user.user-management.add');
                Route::post('/pengguna/pengurusan-pengguna/tambah-pengguna-baru/create', [App\Http\Controllers\UserController::class, 'user_management_create'])->name('home-user.user-management.create');
                Route::get('/pengguna/pengurusan-pengguna/kemaskini-status', [App\Http\Controllers\UserController::class, 'user_status_update'])->name('home-user.user-management.user-status.update');



                //shuttle 3
                Route::get('/pengguna/shuttle-3', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3'])->name('shuttle-3');

                Route::get('/pengguna/shuttle-3-formA/', [App\Http\Controllers\ShuttleThree\MainController::class, 'editFormA'])->name('user.shuttle-3-formA');

                Route::post('/pengguna/shuttle-3-formA/update/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'updateFormA'])->name('update.formA');

                Route::get('/pengguna/shuttle-3-formB/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formB'])->name('user.shuttle-3-formB');

                Route::get('/pengguna/shuttle-3-formC/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formC'])->name('user.shuttle-3-formC');

                Route::get('/pengguna/shuttle-3-formC/KKB/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKKB'])->name('user.shuttle-3-formC.KKB');
                Route::get('/pengguna/shuttle-3-formC/view/KKB/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'shuttle_3_formCKKB'])->name('user.view.shuttle-3-formC.KKB');
                Route::post('/pengguna/shuttle-3-formC/store/KKB/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'store_kkb'])->name('user.view.shuttle-3-formC.KKB.store');

                Route::get('/pengguna/shuttle-3-formC/KKS/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKKS'])->name('user.shuttle-3-formC.KKS');
                Route::get('/pengguna/shuttle-3-formC/view/KKS/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'shuttle_3_formCKKS'])->name('user.view.shuttle-3-formC.KKS');
                Route::post('/pengguna/shuttle-3-formC/store/KKS/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'store_kks'])->name('user.view.shuttle-3-formC.KKS.store');


                Route::get('/pengguna/shuttle-3-formC/KKR/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKKR'])->name('user.shuttle-3-formC.KKR');
                Route::get('/pengguna/shuttle-3-formC/view/KKR/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'shuttle_3_formCKKR'])->name('user.view.shuttle-3-formC.KKR');
                Route::post('/pengguna/shuttle-3-formC/store/KKR/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'store_kkr'])->name('user.view.shuttle-3-formC.KKR.store');


                Route::get('/pengguna/shuttle-3-formC/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKayuLembut'])->name('user.shuttle-3-formC.KayuLembut');
                Route::get('/pengguna/shuttle-3-formC/view/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'shuttle_3_formCKayuLembut'])->name('user.view.shuttle-3-formC.KayuLembut');
                Route::post('/pengguna/shuttle-3-formC/store/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'store_kayulembut'])->name('user.view.shuttle-3-formC.KayuLembut.store');

                Route::get('/pengguna/shuttle-3-formC/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCLainLain'])->name('user.shuttle-3-formC.LainLain');
                Route::get('/pengguna/shuttle-3-formC/view/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'shuttle_3_formCLainLain'])->name('user.view.shuttle-3-formC.LainLain');
                Route::post('/pengguna/shuttle-3-formC/store/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'store_kayulainlain'])->name('user.view.shuttle-3-formC.LainLain.store');

                Route::get('/pengguna/shuttle-3-formC/store/tiada-pengeluaran/{bulan}', [App\Http\Controllers\ShuttleThree\FormCController::class, 'tiadaPengeluaran'])->name('user.shuttle-3-formC.tiadaPengeluaran');

                // Route::get('/pengguna/shuttle-3-formC/KKS/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKKS'])->name('user.shuttle-3-formC.KKS');
                // Route::get('/pengguna/shuttle-3-formC/KKR/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKKR'])->name('user.shuttle-3-formC.KKR');
                // Route::get('/pengguna/shuttle-3-formC/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCKayuLembut'])->name('user.shuttle-3-formC.KayuLembut');
                // Route::get('/pengguna/shuttle-3-formC/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formCLainLain'])->name('user.shuttle-3-formC.LainLain');

                Route::get('/pengguna/shuttle-3-formD/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formD'])->name('user.shuttle-3-formD');
                Route::get('/pengguna/edit-shuttle-3B/{id}', [App\Http\Controllers\UserController::class, 'editform3B'])->name('edit-form3b');
                Route::get('/pengguna/edit-shuttle-3C/{id}', [App\Http\Controllers\UserController::class, 'editform3C'])->name('edit-form3c');
                Route::get('/pengguna/edit-shuttle-3D/{id}', [App\Http\Controllers\UserController::class, 'editform3D'])->name('edit-form3d');


                //SENARAI
                Route::middleware('shuttle3')->group(function () {
                    //shuttle 3
                    Route::get('/pengguna/shuttle-3-senaraiA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_senaraiA_ibk'])->name('user.shuttle-3-senaraiA');
                    Route::get('/pengguna/shuttle-3-senaraiB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_senaraiB_ibk'])->name('user.shuttle-3-senaraiB');
                    Route::get('/pengguna/shuttle-3-senaraiC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_senaraiC_ibk'])->name('user.shuttle-3-senaraiC');
                    Route::get('/pengguna/shuttle-3-senaraiD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_senaraiD_ibk'])->name('user.shuttle-3-senaraiD');
                    Route::get('/pengguna/shuttle-3-listA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_listA_ibk'])->name('user.shuttle-3-listA');
                    Route::get('/pengguna/shuttle-3-listB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_listB_ibk'])->name('user.shuttle-3-listB');
                    Route::get('/pengguna/shuttle-3-listC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_listC_ibk'])->name('user.shuttle-3-listC');
                    Route::get('/pengguna/shuttle-3-listD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_3_listD_ibk'])->name('user.shuttle-3-listD');
                });

                Route::middleware('shuttle4')->group(function () {
                    //shuttle 4
                    Route::get('/pengguna/shuttle-4-senaraiA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_senaraiA_ibk'])->name('user.shuttle-4-senaraiA');
                    Route::get('/pengguna/shuttle-4-senaraiB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_senaraiB_ibk'])->name('user.shuttle-4-senaraiB');
                    Route::get('/pengguna/shuttle-4-senaraiC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_senaraiC_ibk'])->name('user.shuttle-4-senaraiC');
                    Route::get('/pengguna/shuttle-4-senaraiD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_senaraiD_ibk'])->name('user.shuttle-4-senaraiD');
                    Route::get('/pengguna/shuttle-4-senaraiE/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_senaraiE_ibk'])->name('user.shuttle-4-senaraiE');
                    Route::get('/pengguna/shuttle-4-listA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_listA_ibk'])->name('user.shuttle-4-listA');
                    Route::get('/pengguna/shuttle-4-listB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_listB_ibk'])->name('user.shuttle-4-listB');
                    Route::get('/pengguna/shuttle-4-listC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_listC_ibk'])->name('user.shuttle-4-listC');
                    Route::get('/pengguna/shuttle-4-listD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_listD_ibk'])->name('user.shuttle-4-listD');
                    Route::get('/pengguna/shuttle-4-listE/{year}', [App\Http\Controllers\UserController::class, 'shuttle_4_listE_ibk'])->name('user.shuttle-4-listE');
                });

                Route::middleware('shuttle5')->group(function () {
                    //shuttle 5
                    Route::get('/pengguna/shuttle-5-senaraiA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_senaraiA_ibk'])->name('user.shuttle-5-senaraiA');
                    Route::get('/pengguna/shuttle-5-senaraiB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_senaraiB_ibk'])->name('user.shuttle-5-senaraiB');
                    Route::get('/pengguna/shuttle-5-senaraiC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_senaraiC_ibk'])->name('user.shuttle-5-senaraiC');
                    Route::get('/pengguna/shuttle-5-senaraiD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_senaraiD_ibk'])->name('user.shuttle-5-senaraiD');
                    Route::get('/pengguna/shuttle-5-senaraiE/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_senaraiE_ibk'])->name('user.shuttle-5-senaraiE');

                    Route::get('/pengguna/shuttle-5-listA/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_listA_ibk'])->name('user.shuttle-5-listA');
                    Route::get('/pengguna/shuttle-5-listB/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_listB_ibk'])->name('user.shuttle-5-listB');
                    Route::get('/pengguna/shuttle-5-listC/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_listC_ibk'])->name('user.shuttle-5-listC');
                    Route::get('/pengguna/shuttle-5-listD/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_listD_ibk'])->name('user.shuttle-5-listD');
                    Route::get('/pengguna/shuttle-5-listE/{year}', [App\Http\Controllers\UserController::class, 'shuttle_5_listE_ibk'])->name('user.shuttle-5-listE');
                });

                // Route::get('/admin/shuttle-3', [App\Http\Controllers\AdminController::class, 'getShuttle3'])->name('shuttle-3-table');

                //shuttle 4
                Route::get('/pengguna/shuttle-4', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4'])->name('shuttle-4');
                Route::get('/pengguna/shuttle-4-formA', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formA'])->name('user.shuttle-4-formA');
                Route::post('/pengguna/shuttle-4-formA/update/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'updateForm4A'])->name('update.form4A');

                Route::get('/pengguna/shuttle-4-formB/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formB'])->name('user.shuttle-4-formB');
                Route::get('/pengguna/shuttle-4-formC/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formC'])->name('user.shuttle-4-formC');
                Route::get('/pengguna/shuttle-4-formD/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formD'])->name('user.shuttle-4-formD');
                Route::get('/pengguna/shuttle-4-formE/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formE'])->name('user.shuttle-4-formE');

                // Route::get('/pengguna/shuttle-4-formC/KKB/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKB'])->name('user.shuttle-4-formC.KKB');
                // Route::get('/pengguna/shuttle-4-formC/KKS/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKS'])->name('user.shuttle-4-formC.KKS');
                // Route::get('/pengguna/shuttle-4-formC/KKR/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKR'])->name('user.shuttle-4-formC.KKR');
                // Route::get('/pengguna/shuttle-4-formC/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKayuLembut'])->name('user.shuttle-4-formC.KayuLembut');
                // Route::get('/pengguna/shuttle-4-formC/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCLainLain'])->name('user.shuttle-4-formC.LainLain');

                Route::get('/pengguna/shuttle-4-formC/KKB/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKB'])->name('user.shuttle-4-formC.KKB');
                Route::get('/pengguna/shuttle-4-formC/view/KKB/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'shuttle_4_formCKKB'])->name('user.view.shuttle-4-formC.KKB');
                Route::post('/pengguna/shuttle-4-formC/store/KKB/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'store_kkb'])->name('user.view.shuttle-4-formC.KKB.store');

                Route::get('/pengguna/shuttle-4-formC/KKS/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKS'])->name('user.shuttle-4-formC.KKS');
                Route::get('/pengguna/shuttle-4-formC/view/KKS/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'shuttle_4_formCKKS'])->name('user.view.shuttle-4-formC.KKS');
                Route::post('/pengguna/shuttle-4-formC/store/KKS/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'store_kks'])->name('user.view.shuttle-4-formC.KKS.store');


                Route::get('/pengguna/shuttle-4-formC/KKR/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKKR'])->name('user.shuttle-4-formC.KKR');
                Route::get('/pengguna/shuttle-4-formC/view/KKR/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'shuttle_4_formCKKR'])->name('user.view.shuttle-4-formC.KKR');
                Route::post('/pengguna/shuttle-4-formC/store/KKR/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'store_kkr'])->name('user.view.shuttle-4-formC.KKR.store');


                Route::get('/pengguna/shuttle-4-formC/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCKayuLembut'])->name('user.shuttle-4-formC.KayuLembut');
                Route::get('/pengguna/shuttle-4-formC/view/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'shuttle_4_formCKayuLembut'])->name('user.view.shuttle-4-formC.KayuLembut');
                Route::post('/pengguna/shuttle-4-formC/store/Kayu-Lembut/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'store_kayulembut'])->name('user.view.shuttle-4-formC.KayuLembut.store');

                Route::get('/pengguna/shuttle-4-formC/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formCLainLain'])->name('user.shuttle-4-formC.LainLain');
                Route::get('/pengguna/shuttle-4-formC/view/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'shuttle_4_formCLainLain'])->name('user.view.shuttle-4-formC.LainLain');
                Route::post('/pengguna/shuttle-4-formC/store/Lain-Lain/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'store_kayulainlain'])->name('user.view.shuttle-4-formC.LainLain.store');

                Route::get('/pengguna/shuttle-4-formC/store/tiada-pengeluaran/{bulan}', [App\Http\Controllers\ShuttleFour\FormCController::class, 'tiadaPengeluaran'])->name('user.shuttle-4-formC.tiadaPengeluaran');

                Route::get('/pengguna/edit-shuttle-4D/{id}', [App\Http\Controllers\UserController::class, 'editform4D'])->name('edit-form4D');
                Route::get('/pengguna/edit-shuttle-4E/{id}', [App\Http\Controllers\UserController::class, 'editform4E'])->name('edit-form4E');


                //shuttle 5
                Route::get('/pengguna/shuttle-5-formA', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formA'])->name('user.shuttle-5-formA');
                Route::post('/pengguna/shuttle-5-formA/update/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'updateForm5A'])->name('update.form5A');

                Route::get('/pengguna/shuttle-5-formB/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formB'])->name('user.shuttle-5-formB');
                Route::get('/pengguna/shuttle-5-formC/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formC'])->name('user.shuttle-5-formC');
                Route::get('/pengguna/shuttle-5-formD/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formD'])->name('user.shuttle-5-formD');
                Route::get('/pengguna/shuttle-5-formE/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formE'])->name('user.shuttle-5-formE');

                Route::get('/pengguna/shuttle-5-edit-formD/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_edit_formD'])->name('user.shuttle-5-edit-formD');
                Route::get('/pengguna/shuttle-5-edit-formE/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_edit_formE'])->name('user.shuttle-5-edit-formE');



                Route::get('/pengguna/shuttle-view-formA/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'ibk_shuttle_3_formA_view'])->name('pengguna.shuttle-3-view-formA');
                Route::get('/pengguna/shuttle-view-formB/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'ibk_shuttle_3_form_view_form3B'])->name('pengguna.shuttle-3-view-formB');
                Route::get('/pengguna/shuttle-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'ibk_shuttle_3_formC_view'])->name('pengguna.shuttle-3-view-formC');
                Route::get('/pengguna/shuttle-view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'ibk_shuttle_3_formD_view'])->name('pengguna.shuttle-3-view-formD');

                Route::get('/pengguna/shuttle-view-form4D/{id}', [App\Http\Controllers\ShuttleFour\ListDController::class, 'ibk_shuttle_4_form4D_view'])->name('pengguna.shuttle-4-view-form4D');
                Route::get('/pengguna/shuttle-view-form4E/{id}', [App\Http\Controllers\ShuttleFour\ListEController::class, 'ibk_shuttle_4_form4E_view'])->name('pengguna.shuttle-4-view-form4E');

                Route::get('/pengguna/shuttle-view-form5D/{id}', [App\Http\Controllers\ShuttleFive\ListDController::class, 'ibk_shuttle_5_form5D_view'])->name('pengguna.shuttle-5-view-form5D');
                Route::get('/pengguna/shuttle-view-form5E/{id}', [App\Http\Controllers\ShuttleFive\ListEController::class, 'ibk_shuttle_5_form5E_view'])->name('pengguna.shuttle-5-view-form5E');

                //shuttle 4 phd view
                Route::get('/pengguna/shuttle-4-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'ibk_shuttle_4_formC_view'])->name('pengguna.shuttle-4-view-formC');
            });

            Route::middleware('jpn')->group(function () {
                Route::get('/jpn/halaman-utama', [App\Http\Controllers\UserController::class, 'index_jpn'])->name('home-jpn');
                Route::get('/jpn/senarai-tugasan', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_jpn'])->name('jpn.senarai-tugasan');

                Route::get('/jpn/tugasan-shuttle3', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_jpn_shuttle3'])->name('ajax_count_tugasan_jpn_shuttle3');
                Route::get('/jpn/tugasan-shuttle4', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_jpn_shuttle4'])->name('ajax_count_tugasan_jpn_shuttle4');
                Route::get('/jpn/tugasan-shuttle5', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_jpn_shuttle5'])->name('ajax_count_tugasan_jpn_shuttle5');

                //shuttle 3
                Route::get('/jpn/shuttle-3-listA/{year}', [App\Http\Controllers\ShuttleThree\ListAController::class, 'shuttle_3_listA_jpn'])->name('jpn.shuttle-3-listA-jpn');
                Route::get('/jpn/shuttle-3-listB/{year}', [App\Http\Controllers\ShuttleThree\ListBController::class, 'shuttle_3_listB_jpn'])->name('jpn.shuttle-3-listB-jpn');
                Route::get('/jpn/shuttle-3-listC/{year}', [App\Http\Controllers\ShuttleThree\ListCController::class, 'shuttle_3_listC_jpn'])->name('jpn.shuttle-3-listC-jpn');
                Route::get('/jpn/shuttle-3-listD/{year}', [App\Http\Controllers\ShuttleThree\ListDController::class, 'shuttle_3_listD_jpn'])->name('jpn.shuttle-3-listD-jpn');

                Route::get('/jpn/shuttle-4-listA/{year}', [App\Http\Controllers\ShuttleFour\ListAController::class, 'shuttle_4_listA_jpn'])->name('jpn.shuttle-4-listA-jpn');
                Route::get('/jpn/shuttle-4-listB/{year}', [App\Http\Controllers\ShuttleFour\ListBController::class, 'shuttle_4_listB_jpn'])->name('jpn.shuttle-4-listB-jpn');
                Route::get('/jpn/shuttle-4-listC/{year}', [App\Http\Controllers\ShuttleFour\ListCController::class, 'shuttle_4_listC_jpn'])->name('jpn.shuttle-4-listC-jpn');
                Route::get('/jpn/shuttle-4-listD/{year}', [App\Http\Controllers\ShuttleFour\ListDController::class, 'shuttle_4_listD_jpn'])->name('jpn.shuttle-4-listD-jpn');
                Route::get('/jpn/shuttle-4-listE/{year}', [App\Http\Controllers\ShuttleFour\ListEController::class, 'shuttle_4_listE_jpn'])->name('jpn.shuttle-4-listE-jpn');

                Route::get('/jpn/shuttle-5-listA/{year}', [App\Http\Controllers\ShuttleFive\ListAController::class, 'shuttle_5_listA_jpn'])->name('jpn.shuttle-5-listA-jpn');
                Route::get('/jpn/shuttle-5-listB/{year}', [App\Http\Controllers\ShuttleFive\ListBController::class, 'shuttle_5_listB_jpn'])->name('jpn.shuttle-5-listB-jpn');
                Route::get('/jpn/shuttle-5-listC/{year}', [App\Http\Controllers\ShuttleFive\ListCController::class, 'shuttle_5_listC_jpn'])->name('jpn.shuttle-5-listC-jpn');
                Route::get('/jpn/shuttle-5-listD/{year}', [App\Http\Controllers\ShuttleFive\ListDController::class, 'shuttle_5_listD_jpn'])->name('jpn.shuttle-5-listD-jpn');
                Route::get('/jpn/shuttle-5-listE/{year}', [App\Http\Controllers\ShuttleFive\ListEController::class, 'shuttle_5_listE_jpn'])->name('jpn.shuttle-5-listE-jpn');

                Route::get('/jpn/notifikasi-peringatan', [App\Http\Controllers\ShuttleThree\ListAController::class, 'notifikasi_peringatan'])->name('jpn.notifikasi.list');
                Route::get('/jpn/shuttle-list/email', [App\Http\Controllers\ShuttleThree\ListAController::class, 'send_email'])->name('jpn.shuttle-list-jpn.email');

                //view jpn
                Route::get('/jpn/shuttle-view-formA/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'jpn_shuttle_3_formA_view'])->name('jpn.shuttle-3-view-formA');
                Route::get('/jpn/shuttle-view-formB/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'jpn_shuttle_3_form_view_form3B'])->name('jpn.shuttle-3-view-formB');
                Route::get('/jpn/shuttle-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'jpn_shuttle_3_formC_view'])->name('jpn.shuttle-3-view-formC');
                Route::get('/jpn/shuttle-view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'jpn_shuttle_3_formD_view'])->name('jpn.shuttle-3-view-formD');
                Route::get('/jpn/shuttle-view-form4D/{id}', [App\Http\Controllers\ShuttleFour\ListDController::class, 'jpn_shuttle_4_form4D_view'])->name('jpn.shuttle-4-view-form4D');
                Route::get('/jpn/shuttle-view-form4E/{id}', [App\Http\Controllers\ShuttleFour\ListEController::class, 'jpn_shuttle_4_form4E_view'])->name('jpn.shuttle-4-view-form4E');
                Route::get('/jpn/shuttle-view-form5D/{id}', [App\Http\Controllers\ShuttleFive\ListDController::class, 'jpn_shuttle_5_form5D_view'])->name('jpn.shuttle-5-view-form5D');
                Route::get('/jpn/shuttle-view-form5E/{id}', [App\Http\Controllers\ShuttleFive\ListEController::class, 'jpn_shuttle_5_form5E_view'])->name('jpn.shuttle-5-view-form5E');
                Route::get('/jpn/shuttle-4-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'jpn_shuttle_4_formC_view'])->name('jpn.shuttle-4-view-formC');

                //pengumuman JPN-PHD
                Route::get('/jpn/pengumuman-jpn', [App\Http\Controllers\PengumumanController::class, 'pengumuman_jpn'])->name('jpn.pengumuman-jpn');
                Route::get('/jpn/pengumuman-tambah-jpn', [App\Http\Controllers\PengumumanController::class, 'pengumuman_tambah_jpn'])->name('jpn.pengumuman-tambah-jpn');
                Route::post('/jpn/pengumuman-add-jpn', [App\Http\Controllers\PengumumanController::class, 'pengumuman_add_jpn'])->name('jpn.pengumuman-add-jpn');
                Route::get('/jpn/pengumuman-kemaskini-jpn/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_kemaskini_jpn'])->name('jpn.pengumuman-kemaskini-jpn');
                Route::post('/jpn/pengumuman-edit-jpn/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_edit_jpn'])->name('jpn.pengumuman-edit-jpn');
                Route::post('/jpn/pengumuman-delete-jpn/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_delete_jpn'])->name('jpn.pengumuman-delete-jpn');

                //Senarai Status Permohonan Pengguna
                Route::get('/jpn/status-permohonan', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_pengguna_jpn'])->name('jpn.status-permohonan-pengguna');
                Route::get('/jpn/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_jpn'])->name('jpn.lampiran-permohonan-pengguna');

                //senarai kilang aktif
                Route::get('/jpn/senarai_kilang_papan_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_aktif_jpn'])->name('jpn.senarai_kilang_papan_aktif');
                Route::get('/jpn/senarai_kilang_papan_lapis_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_papan_lapis_aktif_jpn'])->name('jpn.senarai_kilang_papan_lapis_aktif');
                Route::get('/jpn/senarai_kilang_kumai_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_kumai_aktif_jpn'])->name('jpn.senarai_kilang_kumai_aktif');
            });

            Route::get('/jpn/kemaskini-profil', [App\Http\Controllers\AdminController::class, 'kemaskini_profil_jpn'])->name('jpn.kemaskini-profil');
            Route::post('/jpn/kemaskini-profil-update', [App\Http\Controllers\AdminController::class, 'update_profile_jpn'])->name('jpn.kemaskini-profil-update');
            //Senarai Status Permohonan Pengguna
            Route::get('/jpn/status-permohonan', [App\Http\Controllers\StatusPermofhonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_pengguna_jpn'])->name('jpn.status-permohonan-pengguna');
            Route::get('/jpn/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_jpn'])->name('jpn.lampiran-permohonan-pengguna');

            Route::middleware('phd')->group(function () {
                Route::get('/phd/halaman-utama', [App\Http\Controllers\UserController::class, 'index_phd'])->name('home-phd');

                //Pengurusan pengguna
                Route::get('/phd/pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'pengurusan_pengguna_phd'])->name('phd.pengurusan-pengguna');
                Route::get('/phd/tambah-pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengurusan_pengguna_phd'])->name('phd.tambah-pengurusan-pengguna');
                Route::post('/phd/tambah_pengguna_phd', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengguna_phd'])->name('phd.tambah-pengurusan-pengguna.store');
                Route::get('/phd/sahkan-lampiran-permohonan/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'lampiran_permohonan_phd'])->name('phd.lampiran-pengurusan-pengguna');
                Route::post('/phd/sahkan-permohonan-phd/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'sahkan_permohonan_phd'])->name('sahkan-permohonan-phd');


                //ajax
                Route::get('/phd/tugasan-shuttle3', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_phd_shuttle3'])->name('ajax_count_tugasan_phd_shuttle3');
                Route::get('/phd/tugasan-shuttle4', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_phd_shuttle4'])->name('ajax_count_tugasan_phd_shuttle4');
                Route::get('/phd/tugasan-shuttle5', [App\Http\Controllers\UserController::class, 'ajax_count_tugasan_phd_shuttle5'])->name('ajax_count_tugasan_phd_shuttle5');

                Route::get('/phd/undeclare-shuttle3', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle3'])->name('ajax_count_undeclare_shuttle3');
                Route::get('/phd/undeclare-shuttle4', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle4'])->name('ajax_count_undeclare_shuttle4');
                Route::get('/phd/undeclare-shuttle5', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle5'])->name('ajax_count_undeclare_shuttle5');

                //senarai kilang aktif
                Route::get('/phd/senarai_kilang_papan_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_aktif'])->name('senarai_kilang_papan_aktif');
                Route::get('/phd/senarai_kilang_papan_lapis_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_papan_lapis_aktif'])->name('senarai_kilang_papan_lapis_aktif');
                Route::get('/phd/senarai_kilang_kumai_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_kumai_aktif'])->name('senarai_kilang_kumai_aktif');


                Route::get('/phd/kemaskini-profil', [App\Http\Controllers\AdminController::class, 'kemaskini_profil_phd'])->name('phd.kemaskini-profil');
                Route::post('/phd/kemaskini-profil-update', [App\Http\Controllers\AdminController::class, 'update_profile_phd'])->name('phd.kemaskini-profil-update');

                //Pengurusan pengguna
                Route::get('/phd/pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'pengurusan_pengguna_phd'])->name('phd.pengurusan-pengguna');
                Route::get('/phd/tambah-pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengurusan_pengguna_phd'])->name('phd.tambah-pengurusan-pengguna');
                Route::post('/phd/tambah_pengguna_phd', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengguna_phd'])->name('phd.tambah-pengurusan-pengguna.store');
                Route::get('/phd/sahkan-lampiran-permohonan/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'lampiran_permohonan_phd'])->name('phd.lampiran-pengurusan-pengguna');
                Route::post('/phd/sahkan-permohonan-phd/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'sahkan_permohonan_phd'])->name('sahkan-permohonan-phd');


                Route::get('/phd/undeclare-shuttle3', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle3'])->name('ajax_count_undeclare_shuttle3');
                Route::get('/phd/undeclare-shuttle4', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle4'])->name('ajax_count_undeclare_shuttle4');
                Route::get('/phd/undeclare-shuttle5', [App\Http\Controllers\UserController::class, 'ajax_count_undeclare_shuttle5'])->name('ajax_count_undeclare_shuttle5');



                //Senarai Status Permohonan Pengguna
                Route::get('/phd/status-permohonan', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_pengguna_phd'])->name('phd.status-permohonan-pengguna');
                Route::get('/phd/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_phd'])->name('phd.lampiran-permohonan-pengguna');
                //sahkan pengguna
                Route::post('/phd/pengesahan-pengguna/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_pengguna_phd'])->name('sahkan_permohonan_pengguna_phd');
                Route::post('/phd/pengesahan-kilang/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_kilang_phd'])->name('sahkan_permohonan_kilang_phd');


                //Status borang shuttle 3
                Route::get('/phd/senarai-tugasan', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_phd'])->name('phd.senarai-tugasan');
                Route::get('/phd/senarai-tugasan-3A/{year}', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_3A'])->name('phd.senarai-tugasan-3A');
                Route::get('/phd/senarai-tugasan-3B/{year}', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_3B'])->name('phd.senarai-tugasan-3B');
                Route::get('/phd/senarai-tugasan-3C/{year}', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_3C'])->name('phd.senarai-tugasan-3C');
                Route::get('/phd/senarai-tugasan-3D/{year}', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_3D'])->name('phd.senarai-tugasan-3D');
                Route::get('/phd/senarai-tidak-lengkap', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tidak_lengkap_phd'])->name('phd.senarai-tidak-lengkap');

                //Status borang shuttle 4

                Route::get('/phd/senarai-tugasan-4A/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'senarai_tugasan_4A'])->name('phd.senarai-tugasan-4A');
                Route::get('/phd/senarai-tugasan-4B/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'senarai_tugasan_4B'])->name('phd.senarai-tugasan-4B');
                Route::get('/phd/senarai-tugasan-4C/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'senarai_tugasan_4C'])->name('phd.senarai-tugasan-4C');
                Route::get('/phd/senarai-tugasan-4D/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'senarai_tugasan_4D'])->name('phd.senarai-tugasan-4D');
                Route::get('/phd/senarai-tugasan-4E/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'senarai_tugasan_4E'])->name('phd.senarai-tugasan-4E');

                //Status borang shuttle 5
                Route::get('/phd/senarai-tugasan-5A/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'senarai_tugasan_5A'])->name('phd.senarai-tugasan-5A');
                Route::get('/phd/senarai-tugasan-5B/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'senarai_tugasan_5B'])->name('phd.senarai-tugasan-5B');
                Route::get('/phd/senarai-tugasan-5C/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'senarai_tugasan_5C'])->name('phd.senarai-tugasan-5C');
                Route::get('/phd/senarai-tugasan-5D/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'senarai_tugasan_5D'])->name('phd.senarai-tugasan-5D');
                Route::get('/phd/senarai-tugasan-5E/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'senarai_tugasan_5E'])->name('phd.senarai-tugasan-5E');



                //shuttle 3
                // Route::get('/phd/shuttle-3-listA', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_listA'])->name('phd.shuttle-3-listA');
                // Route::get('/phd/shuttle-3-listB', [App\Http\Controllers\ShuttleThree\ListBController::class, 'shuttle_3_listB_phd'])->name('phd.shuttle-3-listB');
                // Route::get('/phd/shuttle-3-listC', [App\Http\Controllers\ShuttleThree\ListCController::class, 'shuttle_3_listC_phd'])->name('phd.shuttle-3-listC');
                // Route::get('/phd/shuttle-3-listD', [App\Http\Controllers\ShuttleThree\ListDController::class, 'shuttle_3_listD_phd'])->name('phd.shuttle-3-listD');

                //shuttle 3 phd view
                Route::get('/phd/shuttle-view-formA/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_formA_view'])->name('phd.shuttle-3-view-formA');
                Route::get('/phd/view-formA/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_formA_view_phd'])->name('phd.shuttle-3-view-formA-phd');
                Route::get('/phd/shuttle-view-formB/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view'])->name('phd.shuttle-3-view-formB');
                Route::get('/phd/view-formB/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_phd'])->name('phd.shuttle-3-view-formB-phd');
                Route::get('/phd/shuttle-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'shuttle_3_formC_view'])->name('phd.shuttle-3-view-formC');
                Route::get('/phd/view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'shuttle_3_formC_view_phd'])->name('phd.shuttle-3-view-formC-phd');
                Route::get('/phd/shuttle-view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_3_formD_view'])->name('phd.shuttle-3-view-formD');
                Route::get('/phd/view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_3_formD_view_phd'])->name('phd.shuttle-3-view-formD-phd');

                //shuttle 4 phd view
                Route::get('/phd/shuttle-4-view-formC/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'shuttle_4_formC_view'])->name('phd.shuttle-4-view-formC');
                Route::get('/phd/view-form4C/{id}', [App\Http\Controllers\ShuttleThree\ViewFormCController::class, 'shuttle_4_formC_view_phd'])->name('phd.shuttle-4-view-formC-phd');



                //shuttle 3
                Route::get('/phd/shuttle-3-listA/{year}', [App\Http\Controllers\ShuttleThree\ListAController::class, 'shuttle_3_listA_phd'])->name('phd.shuttle-3-listA');
                Route::get('/phd/shuttle-3-listB/{year}', [App\Http\Controllers\ShuttleThree\ListBController::class, 'shuttle_3_listB_phd'])->name('phd.shuttle-3-listB');
                Route::get('/phd/shuttle-3-listC/{year}', [App\Http\Controllers\ShuttleThree\ListCController::class, 'shuttle_3_listC_phd'])->name('phd.shuttle-3-listC');
                Route::get('/phd/shuttle-3-listD/{year}', [App\Http\Controllers\ShuttleThree\ListDController::class, 'shuttle_3_listD_phd'])->name('phd.shuttle-3-listD');


                //shuttle 4
                Route::get('/phd/shuttle-4-listA/{year}', [App\Http\Controllers\ShuttleFour\ListAController::class, 'shuttle_4_listA'])->name('phd.shuttle-4-listA');
                Route::get('/phd/shuttle-4-listB/{year}', [App\Http\Controllers\ShuttleFour\ListBController::class, 'shuttle_4_listB'])->name('phd.shuttle-4-listB');
                Route::get('/phd/shuttle-4-listC/{year}', [App\Http\Controllers\ShuttleFour\ListCController::class, 'shuttle_4_listC'])->name('phd.shuttle-4-listC');
                Route::get('/phd/shuttle-4-listD/{year}', [App\Http\Controllers\ShuttleFour\ListDController::class, 'shuttle_4_listD'])->name('phd.shuttle-4-listD');
                Route::get('/phd/shuttle-4-listE/{year}', [App\Http\Controllers\ShuttleFour\ListEController::class, 'shuttle_4_listE'])->name('phd.shuttle-4-listE');

                //shuttle 5
                Route::get('/phd/shuttle-5-listA/{year}', [App\Http\Controllers\ShuttleFive\ListOverallController::class, 'shuttle_5_listA'])->name('phd.shuttle-5-listA');
                Route::get('/phd/shuttle-5-listB/{year}', [App\Http\Controllers\ShuttleFive\ListOverallController::class, 'shuttle_5_listB'])->name('phd.shuttle-5-listB');
                Route::get('/phd/shuttle-5-listC/{year}', [App\Http\Controllers\ShuttleFive\ListOverallController::class, 'shuttle_5_listC'])->name('phd.shuttle-5-listC');
                Route::get('/phd/shuttle-5-listD/{year}', [App\Http\Controllers\ShuttleFive\ListOverallController::class, 'shuttle_5_listD'])->name('phd.shuttle-5-listD');
                Route::get('/phd/shuttle-5-listE/{year}', [App\Http\Controllers\ShuttleFive\ListOverallController::class, 'shuttle_5_listE'])->name('phd.shuttle-5-listE');

                Route::post('/phd/shuttle-3-update-status-formA/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_phd_form3A'])->name('update_status_form3A');
                Route::post('/phd/shuttle-3-update-status-formB/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_phd_form3B'])->name('update_status_form3B');
                Route::post('/phd/shuttle-3-update-status-formC/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_phd_form3C'])->name('update_status_form3C');
                Route::post('/phd/shuttle-3-update-status-formD/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_phd_form3D'])->name('update_status_form3D');



                Route::get('/phd/shuttle-4-view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_4_formD_view'])->name('phd.shuttle-4-view-formD');
                Route::get('/phd/view-form4D/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_4_formD_view_phd'])->name('phd.shuttle-4-view-formD-phd');
                Route::get('/phd/shuttle-4-view-formE/{id}', [App\Http\Controllers\ShuttleFour\ViewFormEController::class, 'shuttle_4_formE_view'])->name('phd.shuttle-4-view-formE');
                Route::get('/phd/view-formE/{id}', [App\Http\Controllers\ShuttleFour\ViewFormEController::class, 'shuttle_4_formE_view_phd'])->name('phd.shuttle-4-view-formE-phd');


                Route::post('/phd/shuttle-4-update-status-form4D/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'update_status_phd_form4D'])->name('update_status_form4D');
                Route::post('/phd/shuttle-4-update-status-form4E/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'update_status_phd_form4E'])->name('update_status_form4E');





                //shuttle 5
                // Route::get('/phd/shuttle-5-listA', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_listA'])->name('phd.shuttle-5-listA');
                // Route::get('/phd/shuttle-5-listB', [App\Http\Controllers\ShuttleFive\ListBController::class, 'shuttle_5_listB'])->name('phd.shuttle-5-listB');
                // Route::get('/phd/shuttle-5-listC', [App\Http\Controllers\ShuttleFive\ListCController::class, 'shuttle_5_listC'])->name('phd.shuttle-5-listC');
                // Route::get('/phd/shuttle-5-listD', [App\Http\Controllers\ShuttleFive\ListDController::class, 'shuttle_5_listD'])->name('phd.shuttle-5-listD');
                // Route::get('/phd/shuttle-5-listE', [App\Http\Controllers\ShuttleFive\ListEController::class, 'shuttle_5_listE'])->name('phd.shuttle-5-listE');

                Route::get('/phd/shuttle-5-view-formD/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_5_formD_view'])->name('phd.shuttle-5-view-formD');
                Route::get('/phd/view-form5D/{id}', [App\Http\Controllers\ShuttleThree\ViewFormDController::class, 'shuttle_5_formD_view_phd'])->name('phd.shuttle-5-view-formD-phd');
                Route::get('/phd/shuttle-5-view-formE/{id}', [App\Http\Controllers\ShuttleFour\ViewFormEController::class, 'shuttle_5_formE_view'])->name('phd.shuttle-5-view-formE');
                Route::get('/phd/view-form5E/{id}', [App\Http\Controllers\ShuttleFour\ViewFormEController::class, 'shuttle_5_formE_view_phd'])->name('phd.shuttle-5-view-formE-phd');

                Route::post('/phd/shuttle-5-update-status-formD/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'update_status_phd_form5D'])->name('update_status_form5D');
                Route::post('/phd/shuttle-5-update-status-formE/{id}', [App\Http\Controllers\ShuttleFive\MainController::class, 'update_status_phd_form5E'])->name('update_status_form5E');


                //Paparan Batch
                Route::get('/phd/batch/shuttle-3/{year}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_3_phd'])->name('phd.batch.s3');
                Route::get('/phd/batch/shuttle-3/hantar/submit/{id}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_3_phd_hantar'])->name('phd.batch.s3.hantar');

                Route::get('/phd/batch/shuttle-4/{year}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_4_phd'])->name('phd.batch.s4');
                Route::get('/phd/batch/shuttle-4/hantar/submit/{id}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_4_phd_hantar'])->name('phd.batch.s4.hantar');

                Route::get('/phd/batch/shuttle-5/{year}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_5_phd'])->name('phd.batch.s5');
                Route::get('/phd/batch/shuttle-5/hantar/submit/{id}', [App\Http\Controllers\Batch\PhdController::class, 'shuttle_5_phd_hantar'])->name('phd.batch.s5.hantar');

                //Paparan Peringatan Kilang
                Route::get('/phd/notifikasi-kilang/shuttle-3/', [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_3_phd'])->name('phd.notifikasi-kilang.s3');
                Route::get('/phd/notifikasi-kilang/shuttle-3/send/', [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_3_phd_send'])->name('phd.notifikasi-kilang.s3.send');

                Route::get('/phd/notifikasi-kilang/shuttle-4/', [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_4_phd'])->name('phd.notifikasi-kilang.s4');
                Route::get('/phd/notifikasi-kilang/shuttle-4/send/', [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_4_phd_send'])->name('phd.notifikasi-kilang.s4.send');

                Route::get('/phd/notifikasi-kilang/shuttle-5/',     [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_5_phd'])->name('phd.notifikasi-kilang.s5');
                Route::get('/phd/notifikasi-kilang/shuttle-5/send/', [App\Http\Controllers\NotifikasiKilangController::class, 'shuttle_5_phd_send'])->name('phd.notifikasi-kilang.s5.send');

                //pengumuman PHD-IBK
                Route::get('/phd/pengumuman', [App\Http\Controllers\PengumumanController::class, 'pengumuman'])->name('phd.pengumuman');
                Route::get('/phd/pengumuman-tambah', [App\Http\Controllers\PengumumanController::class, 'pengumuman_tambah'])->name('phd.pengumuman-tambah');
                Route::post('/phd/pengumuman-add', [App\Http\Controllers\PengumumanController::class, 'pengumuman_add'])->name('phd.pengumuman-add');
                Route::get('/phd/pengumuman-kemaskini/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_kemaskini'])->name('phd.pengumuman-kemaskini');
                Route::post('/phd/pengumuman-edit/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_edit'])->name('phd.pengumuman-edit');
                Route::post('/phd/pengumuman-delete/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_delete'])->name('phd.pengumuman-delete');
            });

            //Admin
            Route::middleware('admin')->group(function () {
                Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

                Route::get('/admin/laporan', [App\Http\Controllers\Laporan\LaporanController::class, 'importExportView'])->name('laporan');
                Route::get('laporan', [App\Http\Controllers\Laporan\LaporanController::class, 'laporanView'])->name('laporanpopup');

                //Laporan Export Route
                Route::get('/admin/laporan/excel/shuttle3/101-104/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_1'])->name('laporan_shuttle_3_1.excel');
                Route::get('/admin/laporan/excel/shuttle3/105-106/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_5'])->name('laporan_shuttle_3_5.excel');
                Route::get('/admin/laporan/excel/shuttle3/107/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_7'])->name('laporan_shuttle_3_7.excel');

                Route::get('/admin/laporan/excel/shuttle3/111/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_11'])->name('laporan_shuttle_3_11.excel');
                Route::get('/admin/laporan/excel/shuttle3/112/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_12'])->name('laporan_shuttle_3_12.excel');
                Route::get('/admin/laporan/excel/shuttle3/113/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_13'])->name('laporan_shuttle_3_13.excel');
                Route::get('/admin/laporan/excel/shuttle3/114/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_14'])->name('laporan_shuttle_3_14.excel');
                Route::get('/admin/laporan/excel/shuttle3/115/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_15'])->name('laporan_shuttle_3_15.excel');

                Route::get('/admin/laporan/excel/shuttle3/121/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_21'])->name('laporan_shuttle_3_21.excel');
                Route::get('/admin/laporan/excel/shuttle3/122/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_22'])->name('laporan_shuttle_3_22.excel');
                Route::get('/admin/laporan/excel/shuttle3/123/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_23'])->name('laporan_shuttle_3_23.excel');
                Route::get('/admin/laporan/excel/shuttle3/124/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_24'])->name('laporan_shuttle_3_24.excel');
                Route::get('/admin/laporan/excel/shuttle3/125/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_25'])->name('laporan_shuttle_3_25.excel');

                Route::get('/admin/laporan/excel/shuttle3/131/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_31'])->name('laporan_shuttle_3_31.excel');
                Route::get('/admin/laporan/excel/shuttle3/132/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_32'])->name('laporan_shuttle_3_32.excel');
                Route::get('/admin/laporan/excel/shuttle3/133/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_33'])->name('laporan_shuttle_3_33.excel');
                Route::get('/admin/laporan/excel/shuttle3/134/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_34'])->name('laporan_shuttle_3_34.excel');
                Route::get('/admin/laporan/excel/shuttle3/135/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_35'])->name('laporan_shuttle_3_35.excel');
                Route::get('/admin/laporan/excel/shuttle3/136/{title}/{shuttle}/{spesies}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_36'])->name('laporan_shuttle_3_36.excel');


                Route::get('/admin/laporan/excel/shuttle3/141/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_41'])->name('laporan_shuttle_3_41.excel');
                Route::get('/admin/laporan/excel/shuttle3/142/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_42'])->name('laporan_shuttle_3_42.excel');
                Route::get('/admin/laporan/excel/shuttle3/143/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_43'])->name('laporan_shuttle_3_43.excel');
                Route::get('/admin/laporan/excel/shuttle3/144/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_44'])->name('laporan_shuttle_3_44.excel');
                Route::get('/admin/laporan/excel/shuttle3/145/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_45'])->name('laporan_shuttle_3_45.excel');
                Route::get('/admin/laporan/excel/shuttle3/146/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_46'])->name('laporan_shuttle_3_46.excel');
                Route::get('/admin/laporan/excel/shuttle3/147/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_47'])->name('laporan_shuttle_3_47.excel');
                Route::get('/admin/laporan/excel/shuttle3/148/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_3_48'])->name('laporan_shuttle_3_48.excel');

                //excel shuttle 4
                Route::get('/admin/laporan/excel/shuttle4/201-204/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_1'])->name('laporan_shuttle_4_1.excel');
                Route::get('/admin/laporan/excel/shuttle4/205/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_5'])->name('laporan_shuttle_4_5.excel');
                Route::get('/admin/laporan/excel/shuttle4/206/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_6'])->name('laporan_shuttle_4_6.excel');
                Route::get('/admin/laporan/excel/shuttle4/207/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_7'])->name('laporan_shuttle_4_7.excel');
                Route::get('/admin/laporan/excel/shuttle4/208/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_8'])->name('laporan_shuttle_4_8.excel');
                Route::get('/admin/laporan/excel/shuttle4/209/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_9'])->name('laporan_shuttle_4_9.excel');
                Route::get('/admin/laporan/excel/shuttle4/211/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_11'])->name('laporan_shuttle_4_11.excel');
                Route::get('/admin/laporan/excel/shuttle4/212/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_12'])->name('laporan_shuttle_4_12.excel');
                Route::get('/admin/laporan/excel/shuttle4/213/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_13'])->name('laporan_shuttle_4_13.excel');
                Route::get('/admin/laporan/excel/shuttle4/214/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_14'])->name('laporan_shuttle_4_14.excel');
                Route::get('/admin/laporan/excel/shuttle4/215/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_15'])->name('laporan_shuttle_4_15.excel');
                Route::get('/admin/laporan/excel/shuttle4/221/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_21'])->name('laporan_shuttle_4_21.excel');
                Route::get('/admin/laporan/excel/shuttle4/222/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_22'])->name('laporan_shuttle_4_22.excel');
                Route::get('/admin/laporan/excel/shuttle4/223/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_23'])->name('laporan_shuttle_4_23.excel');
                Route::get('/admin/laporan/excel/shuttle4/224/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_24'])->name('laporan_shuttle_4_24.excel');
                Route::get('/admin/laporan/excel/shuttle4/225/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_25'])->name('laporan_shuttle_4_25.excel');
                Route::get('/admin/laporan/excel/shuttle4/231/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_31'])->name('laporan_shuttle_4_31.excel');
                Route::get('/admin/laporan/excel/shuttle4/232/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_32'])->name('laporan_shuttle_4_32.excel');
                Route::get('/admin/laporan/excel/shuttle4/233/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_33'])->name('laporan_shuttle_4_33.excel');
                Route::get('/admin/laporan/excel/shuttle4/234/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_34'])->name('laporan_shuttle_4_34.excel');
                Route::get('/admin/laporan/excel/shuttle4/235/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_35'])->name('laporan_shuttle_4_35.excel');
                Route::get('/admin/laporan/excel/shuttle4/236/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_36'])->name('laporan_shuttle_4_36.excel');
                Route::get('/admin/laporan/excel/shuttle4/237/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_37'])->name('laporan_shuttle_4_37.excel');
                Route::get('/admin/laporan/excel/shuttle4/238/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_38'])->name('laporan_shuttle_4_38.excel');
                Route::get('/admin/laporan/excel/shuttle4/241/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_41'])->name('laporan_shuttle_4_41.excel');
                Route::get('/admin/laporan/excel/shuttle4/242/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_42'])->name('laporan_shuttle_4_42.excel');
                Route::get('/admin/laporan/excel/shuttle4/243/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_43'])->name('laporan_shuttle_4_43.excel');
                Route::get('/admin/laporan/excel/shuttle4/244/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_44'])->name('laporan_shuttle_4_44.excel');
                Route::get('/admin/laporan/excel/shuttle4/245/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_45'])->name('laporan_shuttle_4_45.excel');
                Route::get('/admin/laporan/excel/shuttle4/246/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_46'])->name('laporan_shuttle_4_46.excel');
                Route::get('/admin/laporan/excel/shuttle4/247/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_47'])->name('laporan_shuttle_4_47.excel');
                Route::get('/admin/laporan/excel/shuttle3/248/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_48'])->name('laporan_shuttle_4_48.excel');
                Route::get('/admin/laporan/excel/shuttle3/249/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_4_49'])->name('laporan_shuttle_4_49.excel');






















                //excel shuttle 5
                Route::get('/admin/laporan/excel/shuttle5/301-304/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_1'])->name('laporan_shuttle_5_1.excel');
                Route::get('/admin/laporan/excel/shuttle5/305-306/{title}/{shuttle}/{file_type}/{species}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_5'])->name('laporan_shuttle_5_5.excel');
                Route::get('/admin/laporan/excel/shuttle5/307/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_7'])->name('laporan_shuttle_5_7.excel');
                Route::get('/admin/laporan/excel/shuttle5/311/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_11'])->name('laporan_shuttle_5_11.excel');
                Route::get('/admin/laporan/excel/shuttle5/312/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_12'])->name('laporan_shuttle_5_12.excel');
                Route::get('/admin/laporan/excel/shuttle5/313/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_13'])->name('laporan_shuttle_5_13.excel');
                Route::get('/admin/laporan/excel/shuttle5/314/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_14'])->name('laporan_shuttle_5_14.excel');
                Route::get('/admin/laporan/excel/shuttle5/315/{title}/{shuttle}/{suku_tahun}/{suku_tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_15'])->name('laporan_shuttle_5_15.excel');
                Route::get('/admin/laporan/excel/shuttle5/321/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_21'])->name('laporan_shuttle_5_21.excel');
                Route::get('/admin/laporan/excel/shuttle5/322/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_22'])->name('laporan_shuttle_5_22.excel');
                Route::get('/admin/laporan/excel/shuttle5/323/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_23'])->name('laporan_shuttle_5_23.excel');
                Route::get('/admin/laporan/excel/shuttle5/324/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_24'])->name('laporan_shuttle_5_24.excel');
                Route::get('/admin/laporan/excel/shuttle5/325/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_25'])->name('laporan_shuttle_5_25.excel');
                Route::get('/admin/laporan/excel/shuttle5/331/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_31'])->name('laporan_shuttle_5_31.excel');
                Route::get('/admin/laporan/excel/shuttle5/332/{title}/{shuttle}/{tahun_mula}/{tahun_akhir}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_32'])->name('laporan_shuttle_5_32.excel');
                Route::get('/admin/laporan/excel/shuttle5/333/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_33'])->name('laporan_shuttle_5_33.excel');
                Route::get('/admin/laporan/excel/shuttle5/341/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_41'])->name('laporan_shuttle_5_41.excel');
                Route::get('/admin/laporan/excel/shuttle5/342/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_42'])->name('laporan_shuttle_5_42.excel');
                Route::get('/admin/laporan/excel/shuttle5/343/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_43'])->name('laporan_shuttle_5_43.excel');
                Route::get('/admin/laporan/excel/shuttle5/344/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_44'])->name('laporan_shuttle_5_44.excel');
                Route::get('/admin/laporan/excel/shuttle5/345/{title}/{shuttle}/{file_type}', [App\Http\Controllers\Laporan\ExcelController::class, 'laporan_shuttle_5_45'])->name('laporan_shuttle_5_45.excel');



















                //End of Laporan Export Route

                //Laporan Data Lama VIEW
                Route::get('/admin/laporan/redirect/{shuttle}/{tahun}/{tahunakhir}/{sukuTahun}/{suku_tahun_akhir}/{spesis}', [App\Http\Controllers\Laporan\LaporanController::class, 'redirectLaporanLama'])->name('redirectLaporanLama');
                Route::get("/admin/laporan/senarai-kilang/{shuttle}/{status}/{tahun}/{title}", [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_senaraikilang'])->name('getreport_senaraikilang');
                Route::get('/admin/laporan/senarai-kilang-top-10-pengeluar/{shuttle}/{tahun}/{lapisvenier}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_top10pengeluar'])->name('getreport_top10pengeluar');
                Route::get('/admin/laporan/senarai-kilang-top-10-pengguna/{shuttle}/{tahun}/{spesis}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_top10pengguna'])->name('getreport_top10pengguna');
                Route::get('/admin/laporan/jumlah-pelaburan-by-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jumlahpelaburan_bynegeri'])->name('getreport_jumlahpelaburan_bynegeri');
                Route::get('/admin/laporan/jumlah-pelaburan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jumlahpelaburan'])->name('getreport_jumlahpelaburan');

                Route::get('/admin/laporan/guna-tenaga-dan-pendapatan-negeri-jantina/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_gunatenagadanpendapatan_bynegeri'])->name('getreport_gunatenagadanpendapatan_bynegeri');
                Route::get('/admin/laporan/guna-tenaga-dan-pendapatan-kategori/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_gunatenagadanpendapatan_bykategori'])->name('getreport_gunatenagadanpendapatan_bykategori');
                Route::get('/admin/laporan/guna-tenaga-kategori/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_gunatenaga_bykategori'])->name('getreport_gunatenaga_bykategori');
                Route::get('/admin/laporan/guna-tenaga-negeri-kewarganegaraan/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_gunatenaga_bynegeri'])->name('getreport_gunatenaga_bynegeri');
                Route::get('/admin/laporan/guna-tenaga-jumlah-purata-kategori-kewarganegaraan/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pecahangunatenagadanpendapatan_bykategori'])->name('getreport_pecahangunatenagadanpendapatan_bykategori');

                Route::get('/admin/laporan/penggunaan-kayu-ikut-bulan-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_penggunaan_bynegeri'])->name('getreport_penggunaan_bynegeri');
                Route::get('/admin/laporan/penggunaan-kayu-ikut-negeri-tahun/{shuttle}/{tahunmula}/{tahunakhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_penggunaan_bynegeri_bytahun'])->name('getreport_penggunaan_bynegeri_bytahun');
                Route::get('/admin/laporan/penggunaan-kayu-ikut-kumpulan-kayu-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bynegeri'])->name('getreport_penggunaan_bykumpulankayu_bynegeri');
                Route::get('/admin/laporan/penggunaan-kayu-ikut-kumpulan-kayu-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bybulan'])->name('getreport_penggunaan_bykumpulankayu_bybulan');
                Route::get('/admin/laporan/penggunaan-kayu-ikut-kumpulan-kayu-tahun/{shuttle}/{tahunmula}/{tahunakhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bytahun'])->name('getreport_penggunaan_bykumpulankayu_bytahun');

                Route::get('/admin/laporan/pengeluaran-negeri-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaran_bynegeri_bybulan'])->name('getreport_pengeluaran_bynegeri_bybulan');
                Route::get('/admin/laporan/pengeluaran-negeri-tahun/{shuttle}/{tahunmula}/{tahunakhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaran_bynegeri_bytahun'])->name('getreport_pengeluaran_bynegeri_bytahun');
                Route::get('/admin/laporan/pengeluaran-kayu-ikut-kumpulan-kayu-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bynegeri'])->name('getreport_pengeluaran_bykumpulankayu_bynegeri');
                Route::get('/admin/laporan/pengeluaran-kayu-ikut-kumpulan-kayu-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bybulan'])->name('getreport_pengeluaran_bykumpulankayu_bybulan');
                Route::get('/admin/laporan/pengeluaran-kayu-ikut-kumpulan-kayu-tahun/{shuttle}/{tahunmula}/{tahunakhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bytahun'])->name('getreport_pengeluaran_bykumpulankayu_bytahun');
                Route::get('/admin/laporan/pengeluaran-kayu-ikut-spesis-negeri-bulan/{shuttle}/{tahun}/{spesis}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_pengeluaranspesies_bynegeri_bybulan'])->name('getreport_pengeluaranspesies_bynegeri_bybulan');

                Route::get('/admin/laporan/jualan-domestik-ikut-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bybulan'])->name('getreport_jualan_bybulan');
                Route::get('/admin/laporan/jualan-domestik-ikut-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bynegeri'])->name('getreport_jualan_bynegeri');
                Route::get('/admin/laporan/jualan-domestik-ikut-negeri-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bynegeridanbulan'])->name('getreport_jualan_bynegeridanbulan');
                Route::get('/admin/laporan/jualan-domestik-ikut-pembeli-bulan/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bypembeli_bybulan'])->name('getreport_jualan_bypembeli_bybulan');
                Route::get('/admin/laporan/jualan-domestik-ikut-pembeli-negeri/{shuttle}/{tahun}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bypembeli_bynegeri'])->name('getreport_jualan_bypembeli_bynegeri');
                Route::get('/admin/laporan/jualan-domestik-ikut-pembeli-tahun/{shuttle}/{tahunmula}/{tahunakhir}/{title}', [App\Http\Controllers\Laporan\LaporanDataLamaController::class, 'getreport_jualan_bypembeli_bytahun'])->name('getreport_jualan_bypembeli_bytahun');
                //END of Laporan Data Lama VIEW


                //Laporan Data Lama EXCEL
                Route::get('/admin/laporan/excel/101/{shuttle}/{status}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_senaraikilang'])->name('getreport_senaraikilang.excel');
                Route::get('/admin/laporan/excel/105/{shuttle}/{tahun}/{lapisvenier}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_top10pengeluar'])->name('getreport_top10pengeluar.excel');
                Route::get('/admin/laporan/excel/106/{shuttle}/{tahun}/{spesis}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_top10pengguna'])->name('getreport_top10pengguna.excel');
                Route::get('/admin/laporan/excel/107/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jumlahpelaburan_bynegeri'])->name('getreport_jumlahpelaburan_bynegeri.excel');
                Route::get('/admin/laporan/excel/208/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jumlahpelaburan'])->name('getreport_jumlahpelaburan.excel');

                Route::get('/admin/laporan/excel/111/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_gunatenagadanpendapatan_bynegeri'])->name('getreport_gunatenagadanpendapatan_bynegeri.excel');
                Route::get('/admin/laporan/excel/112/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_gunatenagadanpendapatan_bykategori'])->name('getreport_gunatenagadanpendapatan_bykategori.excel');
                Route::get('/admin/laporan/excel/113/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_gunatenaga_bykategori'])->name('getreport_gunatenaga_bykategori.excel');
                Route::get('/admin/laporan/excel/114/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_gunatenaga_bynegeri'])->name('getreport_gunatenaga_bynegeri.excel');
                Route::get('/admin/laporan/excel/115/{shuttle}/{tahun}/{suku_tahun_mula}/{suku_tahun_akhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pecahangunatenagadanpendapatan_bykategori'])->name('getreport_pecahangunatenagadanpendapatan_bykategori.excel');

                Route::get('/admin/laporan/excel/121/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_penggunaan_bynegeri'])->name('getreport_penggunaan_bynegeri.excel');
                Route::get('/admin/laporan/excel/122/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_penggunaan_bynegeri_bytahun'])->name('getreport_penggunaan_bynegeri_bytahun.excel');
                Route::get('/admin/laporan/excel/123/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bynegeri'])->name('getreport_penggunaan_bykumpulankayu_bynegeri.excel');
                Route::get('/admin/laporan/excel/124/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bybulan'])->name('getreport_penggunaan_bykumpulankayu_bybulan.excel');
                Route::get('/admin/laporan/excel/125/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_penggunaan_bykumpulankayu_bytahun'])->name('getreport_penggunaan_bykumpulankayu_bytahun.excel');

                Route::get('/admin/laporan/excel/131/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_bynegeri_bybulan'])->name('getreport_pengeluaran_bynegeri_bybulan.excel');
                Route::get('/admin/laporan/excel/132/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_bynegeri_bytahun'])->name('getreport_pengeluaran_bynegeri_bytahun.excel');
                Route::get('/admin/laporan/excel/133/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bynegeri'])->name('getreport_pengeluaran_bykumpulankayu_bynegeri.excel');
                Route::get('/admin/laporan/excel/134/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bybulan'])->name('getreport_pengeluaran_bykumpulankayu_bybulan.excel');
                Route::get('/admin/laporan/excel/135/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_bykumpulankayu_bytahun'])->name('getreport_pengeluaran_bykumpulankayu_bytahun.excel');
                Route::get('/admin/laporan/excel/136/{shuttle}/{tahun}/{spesis}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaranspesies_bynegeri_bybulan'])->name('getreport_pengeluaranspesies_bynegeri_bybulan.excel');
                Route::get('/admin/laporan/excel/234/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluarantebal_bynegeri_bytahun'])->name('getreport_pengeluarantebal_bynegeri_bytahun.excel');
                Route::get('/admin/laporan/excel/235/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluarantebal_bynegeri_bybulan'])->name('getreport_pengeluarantebal_bynegeri_bybulan.excel');

                Route::get('/admin/laporan/excel/141/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bybulan'])->name('getreport_jualan_bybulan.excel');
                Route::get('/admin/laporan/excel/142/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bynegeri'])->name('getreport_jualan_bynegeri.excel');
                Route::get('/admin/laporan/excel/143/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bynegeridanbulan'])->name('getreport_jualan_bynegeridanbulan.excel');
                Route::get('/admin/laporan/excel/144/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bypembeli_bybulan'])->name('getreport_jualan_bypembeli_bybulan.excel');
                Route::get('/admin/laporan/excel/145/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bypembeli_bynegeri'])->name('getreport_jualan_bypembeli_bynegeri.excel');
                Route::get('/admin/laporan/excel/146/{shuttle}/{tahunmula}/{tahunakhir}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_jualan_bypembeli_bytahun'])->name('getreport_jualan_bypembeli_bytahun.excel');

                Route::get('/admin/laporan/excel/333/{shuttle}/{tahun}/{title}/{file_type}', [App\Http\Controllers\Laporan\ExcelDataLamaController::class, 'getreport_pengeluaran_byproduk_bybulan'])->name('getreport_pengeluaran_byproduk_bybulan.excel');


                //END of Laporan Data Lama EXCEL


                // Route::get('report/{request}', [App\Http\Controllers\ReportController::class,'displayReport'])->name('Report');
                Route::get('/admin/kemaskini-profil', [App\Http\Controllers\AdminController::class, 'kemaskini_profil_ipjpsm'])->name('ipjpsm.kemaskini-profil');
                Route::post('/admin/kemaskini-profil-update', [App\Http\Controllers\AdminController::class, 'update_profile_ipjpsm'])->name('ipjpsm.kemaskini-profil-update');

                Route::post('/admin/kemaskini-emel-kilang{id}', [App\Http\Controllers\AdminController::class, 'update_emel_kilang'])->name('ipjpsm.emelkilang');
                Route::post('/admin/kemaskini-emel-phd{id}', [App\Http\Controllers\AdminController::class, 'update_emel_phd'])->name('ipjpsm.emelphd');
                Route::post('/admin/kemaskini-emel-jpn{id}', [App\Http\Controllers\AdminController::class, 'update_emel_jpn'])->name('ipjpsm.emeljpn');
                Route::post('/admin/kemaskini-emel-pengguna{id}', [App\Http\Controllers\AdminController::class, 'update_emel_pengguna'])->name('ipjpsm.emelpengguna');
                Route::post('/admin/kemaskini-emel-ipjpsm{id}', [App\Http\Controllers\AdminController::class, 'update_emel_ipjpsm'])->name('ipjpsm.emelipjpsm');

                //borang keseluruhan SHUTTLE 3
                Route::get('/admin/borang-keseluruhan/shuttle-3/borang-A/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_3_keseluruhan_borang_A'])->name('ipjpsm.borang-keseluruhan.shuttle3.borangA');
                Route::get('/admin/borang-keseluruhan/shuttle-3/borang-B/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_3_keseluruhan_borang_B'])->name('ipjpsm.borang-keseluruhan.shuttle3.borangB');
                Route::get('/admin/borang-keseluruhan/shuttle-3/borang-C/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_3_keseluruhan_borang_C'])->name('ipjpsm.borang-keseluruhan.shuttle3.borangC');
                Route::get('/admin/borang-keseluruhan/shuttle-3/borang-D/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_3_keseluruhan_borang_D'])->name('ipjpsm.borang-keseluruhan.shuttle3.borangD');

                //borang keseluruhan SHUTTLE 4
                Route::get('/admin/borang-keseluruhan/shuttle-4/borang-A/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_4_keseluruhan_borang_A'])->name('ipjpsm.borang-keseluruhan.shuttle4.borangA');
                Route::get('/admin/borang-keseluruhan/shuttle-4/borang-B/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_4_keseluruhan_borang_B'])->name('ipjpsm.borang-keseluruhan.shuttle4.borangB');
                Route::get('/admin/borang-keseluruhan/shuttle-4/borang-C/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_4_keseluruhan_borang_C'])->name('ipjpsm.borang-keseluruhan.shuttle4.borangC');
                Route::get('/admin/borang-keseluruhan/shuttle-4/borang-D/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_4_keseluruhan_borang_D'])->name('ipjpsm.borang-keseluruhan.shuttle4.borangD');
                Route::get('/admin/borang-keseluruhan/shuttle-4/borang-E/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_4_keseluruhan_borang_E'])->name('ipjpsm.borang-keseluruhan.shuttle4.borangE');

                //borang keseluruhan SHUTTLE 5
                Route::get('/admin/borang-keseluruhan/shuttle-5/borang-A/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_5_keseluruhan_borang_A'])->name('ipjpsm.borang-keseluruhan.shuttle5.borangA');
                Route::get('/admin/borang-keseluruhan/shuttle-5/borang-B/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_5_keseluruhan_borang_B'])->name('ipjpsm.borang-keseluruhan.shuttle5.borangB');
                Route::get('/admin/borang-keseluruhan/shuttle-5/borang-C/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_5_keseluruhan_borang_C'])->name('ipjpsm.borang-keseluruhan.shuttle5.borangC');
                Route::get('/admin/borang-keseluruhan/shuttle-5/borang-D/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_5_keseluruhan_borang_D'])->name('ipjpsm.borang-keseluruhan.shuttle5.borangD');
                Route::get('/admin/borang-keseluruhan/shuttle-5/borang-E/{year}', [App\Http\Controllers\HomeController::class, 'shuttle_5_keseluruhan_borang_E'])->name('ipjpsm.borang-keseluruhan.shuttle5.borangE');

                //Senarai Status Permohonan Pengguna
                Route::get('/admin/status-permohonan-shuttle-3/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_3_ipjpsm'])->name('ipjpsm.status-permohonan-shuttle-3');
                Route::get('/admin/status-permohonan-shuttle-3-kilang', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_3_ipjpsm_kilang'])->name('ipjpsm.status-permohonan-shuttle-3-kilang');
                Route::get('/admin/status-permohonan-shuttle-4-kilang', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_4_ipjpsm_kilang'])->name('ipjpsm.status-permohonan-shuttle-4-kilang');
                Route::get('/admin/status-permohonan-shuttle-5-kilang', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_5_ipjpsm_kilang'])->name('ipjpsm.status-permohonan-shuttle-5-kilang');
                Route::get('/admin/status-permohonan-shuttle-4/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_4_ipjpsm'])->name('ipjpsm.status-permohonan-shuttle-4');
                Route::get('/admin/status-permohonan-shuttle-5/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_shuttle_5_ipjpsm'])->name('ipjpsm.status-permohonan-shuttle-5');

                //sahkan pengguna
                Route::post('/admin/pengesahan-pengguna/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_pengguna_ipjpsm'])->name('sahkan_permohonan_pengguna_ipjpsm');
                Route::get('/admin/padam-pengguna/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'delete_user_application'])->name('padam_permohonan_pengguna_ipjpsm');
                Route::post('/admin/pengesahan-kilang/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_kilang_ipjpsm'])->name('sahkan_permohonan_kilang_ipjpsm');

                //pengurusan pengguna
                Route::get('/admin/senarai-ibk-shuttle3/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_ibk3'])->name('ipjpsm.senaraiibk3');
                Route::get('/admin/senarai-ibk-shuttle4/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_ibk4'])->name('ipjpsm.senaraiibk4');
                Route::get('/admin/senarai-ibk-shuttle5/{id}', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_ibk5'])->name('ipjpsm.senaraiibk5');
                Route::get('/admin/senarai-kilang-shuttle3', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_kilang3'])->name('ipjpsm.senaraikilang3');
                Route::get('/admin/senarai-kilang-shuttle4', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_kilang4'])->name('ipjpsm.senaraikilang4');
                Route::get('/admin/senarai-kilang-shuttle5', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'senarai_kilang5'])->name('ipjpsm.senaraikilang5');

                Route::get('/admin/senarai_kilang_papan_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_aktif_ipjpsm'])->name('senarai_kilang_papan_aktif_ipjpsm');
                Route::get('/admin/senarai_kilang_papan_lapis_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_papan_lapis_aktif_ipjpsm'])->name('senarai_kilang_papan_lapis_aktif_ipjpsm');
                Route::get('/admin/senarai_kilang_kumai_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_kumai_aktif_ipjpsm'])->name('senarai_kilang_kumai_aktif_ipjpsm');

                //ajax
                Route::get('/admin/tugasan-shuttle3', [App\Http\Controllers\HomeController::class, 'ajax_count_tugasan_ipjpsm_shuttle3'])->name('ajax_count_tugasan_ipjpsm_shuttle3');
                Route::get('/admin/tugasan-shuttle4', [App\Http\Controllers\HomeController::class, 'ajax_count_tugasan_ipjpsm_shuttle4'])->name('ajax_count_tugasan_ipjpsm_shuttle4');
                Route::get('/admin/tugasan-shuttle5', [App\Http\Controllers\HomeController::class, 'ajax_count_tugasan_ipjpsm_shuttle5'])->name('ajax_count_tugasan_ipjpsm_shuttle5');

                //shuttle 3 IPJPSM
                Route::get('/admin/shuttle-3-listA/{year}', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_listA_ipjpsm'])->name('shuttle-3-listA');
                Route::get('/admin/shuttle-3-listB/{year}', [App\Http\Controllers\ShuttleThree\ListBController::class, 'shuttle_3_listB_ipjpsm'])->name('shuttle-3-listB');
                Route::get('/admin/shuttle-3-listC/{year}', [App\Http\Controllers\ShuttleThree\ListCController::class, 'shuttle_3_listC_ipjpsm'])->name('shuttle-3-listC');
                Route::get('/admin/shuttle-3-listD/{year}', [App\Http\Controllers\ShuttleThree\ListDController::class, 'shuttle_3_listD_ipjpsm'])->name('shuttle-3-listD');

                //shuttle 4 IPJPSM
                Route::get('/admin/shuttle-4-listA/{year}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_listA_ipjpsm'])->name('shuttle-4-listA');
                Route::get('/admin/shuttle-4-listB/{year}', [App\Http\Controllers\ShuttleFour\ListBController::class, 'shuttle_4_listB_ipjpsm'])->name('shuttle-4-listB');
                Route::get('/admin/shuttle-4-listC/{year}', [App\Http\Controllers\ShuttleFour\ListCController::class, 'shuttle_4_listC_ipjpsm'])->name('shuttle-4-listC');
                Route::get('/admin/shuttle-4-listD/{year}', [App\Http\Controllers\ShuttleFour\ListDController::class, 'shuttle_4_listD_ipjpsm'])->name('shuttle-4-listD');
                Route::get('/admin/shuttle-4-listE/{year}', [App\Http\Controllers\ShuttleFour\ListEController::class, 'shuttle_4_listE_ipjpsm'])->name('shuttle-4-listE');

                //shuttle 5 IPJPSM
                Route::get('/admin/shuttle-5-listA/{year}', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_listA_ipjpsm'])->name('shuttle-5-listA');
                Route::get('/admin/shuttle-5-listB/{year}', [App\Http\Controllers\ShuttleFive\ListBController::class, 'shuttle_5_listB_ipjpsm'])->name('shuttle-5-listB');
                Route::get('/admin/shuttle-5-listC/{year}', [App\Http\Controllers\ShuttleFive\ListCController::class, 'shuttle_5_listC_ipjpsm'])->name('shuttle-5-listC');
                Route::get('/admin/shuttle-5-listD/{year}', [App\Http\Controllers\ShuttleFive\ListDController::class, 'shuttle_5_listD_ipjpsm'])->name('shuttle-5-listD');
                Route::get('/admin/shuttle-5-listE/{year}', [App\Http\Controllers\ShuttleFive\ListEController::class, 'shuttle_5_listE_ipjpsm'])->name('shuttle-5-listE');

                Route::get('/admin/shuttle-3-formA', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formA'])->name('shuttle-3-formA');
                Route::get('/admin/shuttle-3-formB', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formB'])->name('shuttle-3-formB');
                Route::get('/admin/shuttle-3-formC', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formC'])->name('shuttle-3-formC');
                Route::get('/admin/shuttle-3-formD', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formD'])->name('shuttle-3-formD');

                //IPJPSM PENGESAHAN BORANG VIEW SHUTTLE 3
                Route::get('/admin/shuttle-3-view-form3A-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_form3A_ipjpsm'])->name('ipjpsm.shuttle-3-view-formA');
                Route::get('/admin/shuttle-3-view-form3B-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_form3B_ipjpsm'])->name('ipjpsm.shuttle-3-view-formB');
                Route::get('/admin/shuttle-3-view-form3C-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_form3C_ipjpsm'])->name('ipjpsm.shuttle-3-view-formC');
                Route::get('/admin/shuttle-4-view-form4C-ipjpsm/{id}', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_form_view_form4C_ipjpsm'])->name('ipjpsm.shuttle-4-view-formC');
                Route::get('/admin/view-formB-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'view_form3B_ipjpsm'])->name('ipjpsm.view-formB');

                Route::get('/admin/shuttle-3-view-form3D-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_form3D_ipjpsm'])->name('ipjpsm.shuttle-3-view-formD');
                Route::get('/admin/view-form3D-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'view_form3D_ipjpsm'])->name('ipjpsm.view-formD');

                Route::get('/admin/shuttle-4-view-form4D-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_4_form_view_form4D_ipjpsm'])->name('ipjpsm.shuttle-4-view-formD');
                Route::get('/admin/shuttle-4-view-form4E-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_4_form_view_form4E_ipjpsm'])->name('ipjpsm.shuttle-4-view-formE');
                Route::get('/admin/view-form4E-ipjpsm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'view_form4E_ipjpsm'])->name('ipjpsm.view-form4E');

                Route::get('/admin/shuttle-5-view-form5D-ipjpsm/{id}', [App\Http\Controllers\ShuttleFive\ViewFormController::class, 'shuttle_5_form_view_form5D_ipjpsm'])->name('ipjpsm.shuttle-5-view-formD');
                Route::get('/admin/shuttle-5-view-form5E-ipjpsm/{id}', [App\Http\Controllers\ShuttleFive\ViewFormController::class, 'shuttle_5_form_view_form5E_ipjpsm'])->name('ipjpsm.shuttle-5-view-formE');
                Route::get('/admin/view-form5E-ipjpsm/{id}', [App\Http\Controllers\ShuttleFive\ViewFormController::class, 'view_form5E_ipjpsm'])->name('ipjpsm.view-formE');

                Route::get('/admin/senarai-tugasan', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_ipjpsm'])->name('ipjpsm.senarai-tugasan');

                Route::post('/admin/shuttle-3-update-status-formA/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm3A'])->name('update_status_form3A_ipjpsm');
                Route::post('/admin/shuttle-3-update-status-formB/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm3B'])->name('update_status_form3B_ipjpsm');
                Route::post('/admin/shuttle-3-update-status-formC/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm3C'])->name('update_status_form3C_ipjpsm');
                Route::post('/admin/shuttle-3-update-status-formD/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm3D'])->name('update_status_form3D_ipjpsm');

                Route::post('/admin/shuttle-4-update-status-formD/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm4D'])->name('update_status_form4D_ipjpsm');
                Route::post('/admin/shuttle-4-update-status-formE/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm4E'])->name('update_status_form4E_ipjpsm');

                Route::post('/admin/shuttle-5-update-status-formD/{id}', [App\Http\Controllers\ShuttleFive\ViewFormController::class, 'update_status_ipjpsm5D'])->name('update_status_form5D_ipjpsm');
                Route::post('/admin/shuttle-5-update-status-formE/{id}', [App\Http\Controllers\ShuttleFive\ViewFormController::class, 'update_status_ipjpsm5E'])->name('update_status_form5E_ipjpsm');

                // Route::get('/admin/shuttle-3', [App\Http\Controllers\AdminController::class, 'getShuttle3'])->name('shuttle-3-table');

                Route::get('/admin/shuttle-4-formA', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formA'])->name('shuttle-4-formA');
                Route::get('/admin/shuttle-4-formB', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formB'])->name('shuttle-4-formB');
                Route::get('/admin/shuttle-4-formC', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formC'])->name('shuttle-4-formC');
                Route::get('/admin/shuttle-4-formD', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formD'])->name('shuttle-4-formD');
                Route::get('/admin/shuttle-4-formE', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formE'])->name('shuttle-4-formE');


                Route::get('/admin/shuttle-5-formA', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formA'])->name('shuttle-5-formA');
                Route::get('/admin/shuttle-5-formB', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formB'])->name('shuttle-5-formB');
                Route::get('/admin/shuttle-5-formC', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formC'])->name('shuttle-5-formC');
                Route::get('/admin/shuttle-5-formD', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formD'])->name('shuttle-5-formD');
                Route::get('/admin/shuttle-5-formE', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formE'])->name('shuttle-5-formE');

                // Route::get('/admin/pengesahan-permohonan', [App\Http\Controllers\PengesahanPermohonan\PengesahanController::class, 'pengesahan_permohonan'])->name('pengesahan-permohonan');

                //Pengurusan Data Asas
                Route::get('/admin/hak-milik-syarikat', [App\Http\Controllers\HakMilikSyarikat\MainController::class, 'hak_milik_syarikat'])->name('hak-milik-syarikat');
                Route::get('/admin/jenis-kayu-kumai', [App\Http\Controllers\JenisKayuKumai\MainController::class, 'jenis_kayu_kumai'])->name('jenis-kayu-kumai');
                Route::get('/admin/jenis-pembeli-shuttle3', [App\Http\Controllers\JenisPembeliShuttle3\MainController::class, 'jenis_pembeli_shuttle3'])->name('jenis-pembeli-shuttle3');
                Route::get('/admin/jenis-pembeli-shuttle4', [App\Http\Controllers\JenisPembeliShuttle4\MainController::class, 'jenis_pembeli_shuttle4'])->name('jenis-pembeli-shuttle4');
                Route::get('/admin/kategori-pekerja', [App\Http\Controllers\KategoriPekerja\MainController::class, 'kategori_pekerja'])->name('kategori-pekerja');
                Route::get('/admin/kewarganegaraan', [App\Http\Controllers\Kewarganegaraan\MainController::class, 'kewarganegaraan'])->name('kewarganegaraan');
                Route::get('/admin/kumpulan-kayu', [App\Http\Controllers\KumpulanKayu\MainController::class, 'kumpulan_kayu'])->name('kumpulan-kayu');
                Route::get('/admin/spesis', [App\Http\Controllers\Spesis\MainController::class, 'spesis'])->name('spesis');
                Route::get('/admin/spesis-aktif', [App\Http\Controllers\SpesisAktif\MainController::class, 'spesis_aktif'])->name('spesis-aktif');
                Route::get('/admin/status-operasi', [App\Http\Controllers\StatusOperasi\MainController::class, 'status_operasi'])->name('status-operasi');
                Route::get('/admin/taraf-syarikat', [App\Http\Controllers\TarafSyarikat\MainController::class, 'taraf_syarikat'])->name('taraf-syarikat');

                Route::get('/admin/recovery-rate', [App\Http\Controllers\RecoveryRateController::class, 'index'])->name('recovery-rate');
                Route::get('/admin/recovery-rate/edit/{id}', [App\Http\Controllers\RecoveryRateController::class, 'edit'])->name('recovery-rate.edit');
                Route::post('/admin/recovery-rate/update/{id}', [App\Http\Controllers\RecoveryRateController::class, 'update'])->name('recovery-rate.update');

                //daerah data asas
                Route::get('/admin/daerah', [App\Http\Controllers\DaerahController::class, 'daerah'])->name('daerah');
                Route::get('/admin/daerah-tambah', [App\Http\Controllers\DaerahController::class, 'daerah_tambah'])->name('daerah-tambah');
                Route::post('/admin/daerah-add', [App\Http\Controllers\DaerahController::class, 'daerah_add'])->name('daerah-add');
                Route::get('/admin/daerah-padam/{id}', [App\Http\Controllers\DaerahController::class, 'delete'])->name('delete_daerah');
                Route::get('/admin/daerah-kemaskini/{id}', [App\Http\Controllers\DaerahController::class, 'daerah_kemaskini'])->name('daerah-kemaskini');
                Route::post('/admin/daerah-edit/{id}', [App\Http\Controllers\DaerahController::class, 'daerah_edit'])->name('daerah-edit');

                //pengumuman IPJPSM-JPN
                Route::get('/admin/pengumuman-ipjpsm', [App\Http\Controllers\PengumumanController::class, 'pengumuman_ipjpsm'])->name('pengumuman-ipjpsm');
                Route::get('/admin/pengumuman-tambah-ipjpsm', [App\Http\Controllers\PengumumanController::class, 'pengumuman_tambah_ipjpsm'])->name('pengumuman-tambah-ipjpsm');
                Route::post('/admin/pengumuman-add-ipjpsm', [App\Http\Controllers\PengumumanController::class, 'pengumuman_add_ipjpsm'])->name('pengumuman-add-ipjpsm');
                Route::get('/admin/pengumuman-kemaskini-ipjpsm/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_kemaskini_ipjpsm'])->name('pengumuman-kemaskini-ipjpsm');
                Route::post('/admin/pengumuman-edit-ipjpsm/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_edit_ipjpsm'])->name('pengumuman-edit-ipjpsm');
                Route::post('/admin/pengumuman-delete-ipjpsm/{id}', [App\Http\Controllers\PengumumanController::class, 'pengumuman_delete_ipjpsm'])->name('pengumuman-delete-ipjpsm');




                //Senarai tugasan ipjpsm
                // Route::get('/admin/senarai-tugasan-ipjpsm', [App\Http\Controllers\SenaraiTugasanIpjpsm\SenaraiBorangController::class, 'borang_belum_lengkap'])->name('senarai-tugasan-ipjpsm');

                // //Senarai Status Permohonan Pengguna
                // Route::get('/admin/status-permohonan', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_pengguna'])->name('status-permohonan-pengguna');
                // Route::get('/admin/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan'])->name('lampiran-permohonan-pengguna');
                // Route::get('/ipjpsm/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_ipjpsm'])->name('ipjpsm.lampiran-pengurusan-pengguna');
                // Route::post('/ipjpsm/sahkan-permohonan-ipjpsm/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_ipjpsm'])->name('sahkan-permohonan-ipjpsm');

                //buffer
                Route::get('/admin/tetapan/senarai-buffer', [App\Http\Controllers\BufferController::class, 'papar_buffer'])->name('tetapan.buffer.papar');

                Route::get('/admin/tetapan/senarai-buffer/update', [App\Http\Controllers\BufferController::class, 'update_buffer'])->name('tetapan.buffer.update');
            });

            Route::middleware('bpm')->group(function () {
                Route::get('/bpm/home', [App\Http\Controllers\HomeController::class, 'index_bpm'])->name('home-bpm');
                Route::get('/bpm/laporan', [App\Http\Controllers\ExcelController::class, 'importExportView'])->name('bpm.laporan');
                Route::get('bpm/exportExcel/{type}', [App\Http\Controllers\ExcelController::class, 'ShuttleExcel'])->name('bpm.ShuttleExcel');
                Route::get('bpm/laporan', [App\Http\Controllers\LaporanController::class, 'laporanView'])->name('bpm.laporanpopup');
                // Route::get('report/{request}', [App\Http\Controllers\ReportController::class,'displayReport'])->name('Report');

                //audit
                Route::get('/audit-trails', [App\Http\Controllers\AdminController::class, 'viewAuditList'])->name('audit');
                Route::get('/itadmin/audit/datatable', [App\Http\Controllers\AdminController::class, 'audit_datatable'])->name('user.it.audit.datatable');
                Route::get('/itadmin/audit/user', [App\Http\Controllers\AdminController::class, 'auditTrailLogUser'])->name('user.it.auditUser');
                Route::get('/bpm/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');

                //shuttle 3
                Route::get('/bpm/shuttle-3-listA', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_listA_bpm'])->name('bpm.shuttle-3-listA');
                Route::get('/bpm/shuttle-3-listB', [App\Http\Controllers\ShuttleThree\ListBController::class, 'shuttle_3_listB_bpm'])->name('bpm.shuttle-3-listB');
                Route::get('/bpm/shuttle-3-listC', [App\Http\Controllers\ShuttleThree\ListCController::class, 'shuttle_3_listC_bpm'])->name('bpm.shuttle-3-listC');
                Route::get('/bpm/shuttle-3-listD', [App\Http\Controllers\ShuttleThree\ListDController::class, 'shuttle_3_listD_bpm'])->name('bpm.shuttle-3-listD');
                Route::get('/bpm/shuttle-3-formA', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formA'])->name('bpm.shuttle-3-formA');
                Route::get('/bpm/shuttle-3-formB', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formB_bpe'])->name('bpm.shuttle-3-formB');
                Route::get('/bpm/shuttle-3-formC', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formC'])->name('bpm.shuttle-3-formC');
                Route::get('/bpm/shuttle-3-formD', [App\Http\Controllers\ShuttleThree\MainController::class, 'shuttle_3_formD'])->name('bpm.shuttle-3-formD');

                Route::get('/bpm/shuttle-3-view-formB-bpm/{id}', [App\Http\Controllers\ShuttleThree\ViewFormBController::class, 'shuttle_3_form_view_bpm'])->name('bpm.shuttle-3-view-formB');
                Route::get('/bpm/senarai-tugasan', [App\Http\Controllers\ShuttleThree\MainController::class, 'senarai_tugasan_ipjpsm'])->name('bpm.senarai-tugasan');

                Route::post('/bpm/shuttle-3-update-status-formB/{id}', [App\Http\Controllers\ShuttleThree\MainController::class, 'update_status_ipjpsm'])->name('bpm.update_status_formB');

                //senarai kilang aktif
                Route::get('/bpm/senarai_kilang_papan_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_aktif_bpm'])->name('bpm.senarai_kilang_papan_aktif');
                Route::get('/bpm/senarai_kilang_papan_lapis_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_papan_lapis_aktif_bpm'])->name('bpm.senarai_kilang_papan_lapis_aktif');
                Route::get('/bpm/senarai_kilang_kumai_aktif', [App\Http\Controllers\UserController::class, 'list_kilang_kumai_aktif_bpm'])->name('bpm.senarai_kilang_kumai_aktif');


                // Route::get('/admin/shuttle-3', [App\Http\Controllers\AdminController::class, 'getShuttle3'])->name('shuttle-3-table');

                //shuttle 4
                // Route::get('/admin/shuttle-4', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4'])->name('shuttle-4');
                Route::get('/bpm/shuttle-4-listA', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_listA'])->name('bpm.shuttle-4-listA');
                Route::get('/bpm/shuttle-4-listB', [App\Http\Controllers\ShuttleFour\ListBController::class, 'w'])->name('bpm.shuttle-4-listB');
                Route::get('/bpm/shuttle-4-listC', [App\Http\Controllers\ShuttleFour\ListCController::class, 'shuttle_4_listC'])->name('bpm.shuttle-4-listC');
                Route::get('/bpm/shuttle-4-listD', [App\Http\Controllers\ShuttleFour\ListDController::class, 'shuttle_4_listD'])->name('bpm.shuttle-4-listD');
                Route::get('/bpm/shuttle-4-listE', [App\Http\Controllers\ShuttleFour\ListEController::class, 'shuttle_4_listE'])->name('bpm.shuttle-4-listE');
                Route::get('/bpm/shuttle-4-formA', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formA'])->name('bpm.shuttle-4-formA');
                Route::get('/bpm/shuttle-4-formB', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formB'])->name('bpm.shuttle-4-formB');
                Route::get('/bpm/shuttle-4-formC', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formC'])->name('bpm.shuttle-4-formC');
                Route::get('/bpm/shuttle-4-formD', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formD'])->name('bpm.shuttle-4-formD');
                Route::get('/bpm/shuttle-4-formE', [App\Http\Controllers\ShuttleFour\MainController::class, 'shuttle_4_formE'])->name('bpm.shuttle-4-formE');

                //shuttle 5
                Route::get('/bpm/shuttle-5-listA', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_listA'])->name('bpm.shuttle-5-listA');
                Route::get('/bpm/shuttle-5-listB', [App\Http\Controllers\ShuttleFive\ListBController::class, 'shuttle_5_listB'])->name('bpm.shuttle-5-listB');
                Route::get('/bpm/shuttle-5-listC', [App\Http\Controllers\ShuttleFive\ListCController::class, 'shuttle_5_listC'])->name('bpm.shuttle-5-listC');
                Route::get('/bpm/shuttle-5-listD', [App\Http\Controllers\ShuttleFive\ListDController::class, 'shuttle_5_listD'])->name('bpm.shuttle-5-listD');
                Route::get('/bpm/shuttle-5-listE', [App\Http\Controllers\ShuttleFive\ListEController::class, 'shuttle_5_listE'])->name('bpm.shuttle-5-listE');
                Route::get('/bpm/shuttle-5-formA', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formA'])->name('bpm.shuttle-5-formA');
                Route::get('/bpm/shuttle-5-formB', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formB'])->name('bpm.shuttle-5-formB');
                Route::get('/bpm/shuttle-5-formC', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formC'])->name('bpm.shuttle-5-formC');
                Route::get('/bpm/shuttle-5-formD', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formD'])->name('bpm.shuttle-5-formD');
                Route::get('/bpm/shuttle-5-formE', [App\Http\Controllers\ShuttleFive\MainController::class, 'shuttle_5_formE'])->name('bpm.shuttle-5-formE');

                //pengurusan pengguna
                Route::get('/bpm/pengurusan-pengguna', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'pengurusan_pengguna_bpm'])->name('bpm.pengurusan-pengguna');
                Route::get('/bpm/pengurusan-pengguna-tambah', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengurusan_pengguna_bpm'])->name('bpm.tambah-pengurusan-pengguna-bpm');
                Route::post('/bpm/tambah_pengguna_ipjpsm', [App\Http\Controllers\PengurusanPengguna\MainController::class, 'tambah_pengguna_bpm'])->name('bpm.tambah-pengurusan-pengguna.store');
                Route::get('/bpm/pengesahan-permohonan', [App\Http\Controllers\PengesahanPermohonan\PengesahanController::class, 'pengesahan_permohonan'])->name('bpm.pengesahan-permohonan');

                //Pengurusan Data Asas
                Route::get('/bpm/hak-milik-syarikat', [App\Http\Controllers\HakMilikSyarikat\MainController::class, 'hak_milik_syarikat'])->name('bpm.hak-milik-syarikat');
                Route::get('/bpm/jenis-kayu-kumai', [App\Http\Controllers\JenisKayuKumai\MainController::class, 'jenis_kayu_kumai'])->name('bpm.jenis-kayu-kumai');
                Route::get('/bpm/jenis-pembeli-shuttle3', [App\Http\Controllers\JenisPembeliShuttle3\MainController::class, 'jenis_pembeli_shuttle3'])->name('bpm.jenis-pembeli-shuttle3');
                Route::get('/bpm/jenis-pembeli-shuttle4', [App\Http\Controllers\JenisPembeliShuttle4\MainController::class, 'jenis_pembeli_shuttle4'])->name('bpm.jenis-pembeli-shuttle4');
                Route::get('/bpm/kategori-pekerja', [App\Http\Controllers\KategoriPekerja\MainController::class, 'kategori_pekerja'])->name('bpm.kategori-pekerja');
                Route::get('/bpm/kewarganegaraan', [App\Http\Controllers\Kewarganegaraan\MainController::class, 'kewarganegaraan'])->name('bpm.kewarganegaraan');
                Route::get('/bpm/kumpulan-kayu', [App\Http\Controllers\KumpulanKayu\MainController::class, 'kumpulan_kayu'])->name('bpm.kumpulan-kayu');
                Route::get('/bpm/spesis', [App\Http\Controllers\spesis\MainController::class, 'spesis'])->name('bpm.spesis');
                Route::get('/bpm/spesis-aktif', [App\Http\Controllers\SpesisAktif\MainController::class, 'spesis_aktif'])->name('bpm.spesis-aktif');
                Route::get('/bpm/status-operasi', [App\Http\Controllers\StatusOperasi\MainController::class, 'status_operasi'])->name('bpm.status-operasi');
                Route::get('/bpm/taraf-syarikat', [App\Http\Controllers\TarafSyarikat\MainController::class, 'taraf_syarikat'])->name('bpm.taraf-syarikat');

                //Senarai tugasan ipjpsm
                // Route::get('/admin/senarai-tugasan-ipjpsm', [App\Http\Controllers\SenaraiTugasanIpjpsm\SenaraiBorangController::class, 'borang_belum_lengkap'])->name('senarai-tugasan-ipjpsm');

                //Senarai Status Permohonan Pengguna
                Route::get('/bpm/status-permohonan', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'status_permohonan_pengguna'])->name('bpm.status-permohonan-pengguna');
                Route::get('/bpm/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan'])->name('bpm.lampiran-permohonan-pengguna');
                Route::get('/bpm/lampiran-permohonan/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'lampiran_permohonan_bpm'])->name('bpm.lampiran-pengurusan-pengguna');
                Route::post('/bpm/sahkan-permohonan-bpm/{id}', [App\Http\Controllers\StatusPermohonanPengguna\PermohonanPenggunaController::class, 'sahkan_permohonan_bpm'])->name('bpm.sahkan-permohonan-ipjpsm');
            });
        });
    }
);



// Route::get('/pengguna/shuttle-3-form', [App\Http\Controllers\HomeController::class, 'shuttle_3_form'])->name('shuttle-3-form');
