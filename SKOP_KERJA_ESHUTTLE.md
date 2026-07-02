# Ringkasan Skop Kerja Sistem eShuttle
**Tempoh:** Mei 2026 – Julai 2026
**Nama:** Muhammad Faiz Abdullah

---

## MEI 2026

| Bulan | Skop Kerja | Butiran Kerja | Progress |
|-------|-----------|---------------|----------|
| Mei 2026 | **(a) Pembaikan Ralat Sistem** | Fix listing Borang C pada senarai IBK Shuttle 3/4/5 | Selesai |
| | | Fix year selection pada FormB Shuttle 4 & 5 | Selesai |
| | | Fix editable address pada Form A (Shuttle 3/IBK) | Selesai |
| | | Fix item listing merentas borangKeseluruhan (Shuttle 3/4/5) | Selesai |
| | | Fix papar senarai IBK (Shuttle 4/5 senarai B/C/D/E) | Selesai |
| | | Fix ralat Form C/D/E (MainController & ListController) | Selesai |
| | | Fix show item pada senarai B IBK Shuttle 3/4/5 | Selesai |
| | | Fix carryforward check pada Form C Shuttle 3/4 | Selesai |
| | | Fix paparan Form B/C/D (Livewire Shuttle 3/4/5) | Selesai |
| | | Fix version support sistem | Selesai |
| | | Fix ralat login/register controller | Selesai |
| Mei 2026 | **(b) Notifikasi Sistem** | Pembaikan penghantaran emel BorangDiHantar | Selesai |
| | | Pembaikan notifikasi SahPenggunaNotification (IPJPSM) | Selesai |
| | | Pembaikan notifikasi BorangTidakLengkapNotification (PHD) | Selesai |
| | | Pembaikan notifikasi BorangTidakDiisiNotification (PHD) | Selesai |
| Mei 2026 | **(d) Database Tuning** | Migration tambah performance indexes pada 12 jadual borang | Selesai |
| | | Seeder: NormalizeAllSeeder — normalisasi semua data | Selesai |
| | | Seeder: NormalizeDoubleSlashSeeder — buang double slash | Selesai |
| | | Seeder: NormalizeLoginIdSeeder — normalisasi login ID | Selesai |
| | | Seeder: NormalizeNegeriDaerahSeeder — normalisasi negeri/daerah | Selesai |
| | | Seeder: NormalizeShuttleTypeSeeder — normalisasi jenis shuttle | Selesai |
| Mei 2026 | **(e) Penambahbaikan Dashboard** | Tambah data aggregation dashboard PHD/JPN/IBK/User (HomeController) | Selesai |
| | | Tambah partial borang-nav untuk navigasi borang | Selesai |
| | | Kemaskini paparan home, home-jpn, home-phd | Selesai |
| | | Tambah kiraan ringkasan (count) pada AdminController | Selesai |
| | | Tambah halaman & middleware Maintenance Mode | Selesai |
| | | Tetapan Maintenance Mode (controller + model + UI tetapan penyelenggaraan) | Selesai |
| Mei 2026 | **(f) Loading Performance** | Refactor besar HomeController (kurangkan kerumitan query) | Selesai |
| | | Ekstrak partial cell-borang-monthly.blade.php | Selesai |
| | | Ekstrak partial cell-borang-quarterly.blade.php | Selesai |
| | | Kurangkan saiz shuttle-3/4/5-listC-ipjpsm.blade.php (>1,300 baris → partial) | Selesai |

---

## JUN 2026

| Bulan | Skop Kerja | Butiran Kerja | Progress |
|-------|-----------|---------------|----------|
| Jun 2026 | **(a) Pembaikan Ralat Sistem** | Kemaskini LaporanController & paparan Form 5D IPJPSM | Selesai |
| | | Fix double item pada ListDController / ListEController Shuttle 4/5 | Selesai |
| | | Fix ralat pada Form B Shuttle 3/4/5 (Livewire) | Selesai |
| | | Fix paparan Daerah View & pengiraan item merentas semua senarai Shuttle 3/4/5 | Selesai |
| | | Fix pengiraan Borang B Shuttle 3 (FormB Livewire + ViewFormB) | Selesai |
| | | Tambah paparan Jumlah pada Borang B Shuttle 3 | Selesai |
| | | Fix pengiraan Form D Shuttle 4/5 (FormB & FormD Livewire) | Selesai |
| | | Fix Form C/D/E Shuttle 3/4/5 (Livewire + paparan admin) | Selesai |
| | | Tambah Form C Shuttle 5 (KKB/KKR/KKS/Lembut/LainLain) | Selesai |
| | | Fix validasi Form C 'Tidak Lengkap' Shuttle 3/4 | Selesai |
| | | Fix listing & tambah seeder tutup Form C masa hadapan | Selesai |
| | | Ensure status 'Ditutup' betul pada semua borang | Selesai |
| | | Fix paparan icon pada borangKeseluruhan (Shuttle 3/4/5) | Selesai |
| | | Fix editable data pada Form A Shuttle 3 | Selesai |
| | | Fix Kadar Kemasukan pada Form D Shuttle 4 | Selesai |
| | | Fix data pada FormC controller, Permohonan Pengguna, view Form 4D/4E | Selesai |
| | | Implement peraturan baru aliran borang (FormFlowService) | Selesai |
| | | Fix data pendua — unique constraint + fix carry forward Januari | Selesai |
| Jun 2026 | **(b) Notifikasi Sistem** | Fix BorangTidakLengkapNotification & BorangTidakLengkapMail (PHD) | Selesai |
| Jun 2026 | **(c) Dokumentasi Sistem** | Tambah DEPLOY_ARTISAN_STEPS.md (panduan langkah deployment artisan) | Selesai |
| Jun 2026 | **(d) Database Tuning** | Migration: unique constraint pada jadual Form C | Selesai |
| | | Migration: fix sequential consistency Form C | Selesai |
| | | Migration: fix January zero kemasukan carry forward | Selesai |
| | | Seeder: FixWoodlandorAddressSeeder — pembetulan alamat | Selesai |
| | | Seeder: FixYeohKokEngDaerahSeeder — pembetulan daerah | Selesai |
| | | Seeder: ReportAffectedShuttles2025Seeder — senarai shuttle terjejas | Selesai |
| | | Seeder: SealFutureFormCSeeder & SealFutureFormBSeeder — tutup borang masa hadapan | Selesai |
| | | Seeder: ResetFutureFormCSeeder & RestoreFutureFormCDitutupSeeder | Selesai |
| Jun 2026 | **(e) Penambahbaikan Dashboard** | Fix nilai tidak terpapar pada dashboard (banyak controller) | Selesai |
| | | Tukar logo kepada Jata Negara rasmi Malaysia | Selesai |
| | | Kemaskini semua layout (IBK, IPJPSM, JPN, PHD, User) | Selesai |
| | | Kemaskini tooltips icon pada Borang A Shuttle 3/4/5 | Selesai |
| | | Tambah status 'Ditutup' (calendar icon) pada senarai IBK Shuttle 3/4/5 | Selesai |
| Jun 2026 | **(f) Loading Performance** | Implement FormFlowService — centralize business logic aliran borang | Selesai |
| | | Refactor MainController Shuttle 3/4/5 (pindah logic ke service layer) | Selesai |
| | | Ekstrak partial form-status-cell.blade.php | Selesai |
| | | Tambah Artisan command RepairTiadaPengeluaranTotals | Selesai |
| | | Refactor ViewFormBController & view-form3b views (kurangkan saiz fail) | Selesai |

---

## JULAI 2026

| Bulan | Skop Kerja | Butiran Kerja | Progress |
|-------|-----------|---------------|----------|
| Jul 2026 | **(a) Pembaikan Ralat Sistem** | Fix button pada lebih 65 fail laporan (Excel, PDF, popup Shuttle 3/4/5) | Selesai |
| | | Fix maklumat daerah pada laporan & permohonan pengguna | Selesai |
| | | Fix paparan Form D Shuttle 4/5 (button livewire) | Selesai |
| | | Fix paparan notifikasi kilang Shuttle 3/4/5 | Selesai |
| | | Fix logik buka/tutup borang dalam FormFlowService | Selesai |
| | | Fix ShuttleThree MainController — logik tutup borang | Selesai |

---

## Ringkasan Status Keseluruhan

| Skop | Status |
|------|--------|
| (a) Pembaikan Ralat Sistem | Selesai (berterusan) |
| (b) Semakan dan Penambahbaikan Notifikasi | Selesai |
| (c) Kemas Kini Dokumentasi Sistem | Selesai (asas — boleh diperluaskan) |
| (d) Tuning dan Pengoptimuman Pangkalan Data | Selesai |
| (e) Penambahbaikan Paparan Dashboard | Selesai |
| (f) Penambahbaikan Prestasi Capaian | Selesai |
