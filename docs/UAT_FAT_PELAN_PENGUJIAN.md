# Pelan Ujian Penerimaan Pengguna (UAT) & Ujian Penerimaan Muktamad (FAT)
## Sistem eShuttle — EKBK (Artanis-ekbk)

| | |
|---|---|
| **Sistem** | Sistem Pelaporan Industri Perkilangan Kayu (eShuttle) — EKBK |
| **Jenis Dokumen** | Pelan & Panduan Pelaksanaan UAT/FAT |
| **Disediakan oleh** | Muhammad Faiz Abdullah (Pembangun/Kontraktor) |
| **Tarikh** | 19 Ogos 2026 |
| **Versi** | 2.0 |
| **Rujukan Skop Kerja** | `SKOP_KERJA_ESHUTTLE.md` (Mei–Julai 2026) |

> **Nota tentang istilah**: Dalam dokumen ini, **UAT (User Acceptance Test)** merujuk kepada pengujian oleh pengguna akhir/pihak EKBK (IBK, PHD, JPN, IPJPSM) untuk mengesahkan sistem memenuhi keperluan bisnes. **FAT (Final Acceptance Test)** merujuk kepada pengujian penerimaan muktamad sebelum penyerahan rasmi sistem, biasanya dijalankan bersama pihak pembangun/kontraktor untuk mengesahkan aspek teknikal (persekitaran, konfigurasi, integrasi, keselamatan asas) sebelum UAT rasmi oleh pengguna. Kedua-dua peringkat berkongsi set kes ujian yang sama dalam dokumen ini — bezanya hanya siapa yang menjalankan dan bila (FAT dahulu di persekitaran staging, UAT kemudian selepas FAT lulus).

> **Nota versi 2.0**: Bahagian Kes Ujian disusun semula mengikut **jenis Shuttle (3, 4, 5)** sebagai paksi utama, dan **peranan (IBK → PHD → JPN → IPJPSM)** sebagai paksi kedua di dalam setiap Shuttle — atas permintaan EKBK, supaya setiap pihak boleh terus ke bahagian yang relevan kepada kilang/peranan mereka tanpa perlu menyemak keseluruhan dokumen. Kes ujian yang **tidak berbeza** mengikut jenis Shuttle (log masuk, kata laluan, data rujukan, dsb.) kekal di Bahagian 7 (Kes Ujian Am). Tiada kes ujian dibuang berbanding v1.2 — hanya disusun semula dan diberi ID baharu berformat `S{3,4,5}-{Peranan}-{No}`.

---

## 1. Objektif & Skop

### 1.1 Objektif
1. Mengesahkan semua modul dan proses bisnes sistem eShuttle berfungsi mengikut keperluan sebenar pengguna (IBK, PHD, JPN, IPJPSM/BPE, BPM).
2. Mengesahkan aliran kerja hujung-ke-hujung (end-to-end): log masuk → pendaftaran → kelulusan → pengisian borang → semakan → kelulusan → pelaporan.
3. Mengesahkan integrasi sistem (e-mel, storan fail, eksport PDF/Excel, pangkalan data legasi) berfungsi dengan betul.
4. Mengesahkan pengendalian ralat (error handling) dan kes sempadan (edge cases) tidak menyebabkan kegagalan sistem atau kehilangan data.
5. Mendokumentasikan semua kunci, kredensial dan nilai konfigurasi yang diperlukan supaya pasukan pengujian boleh menyediakan persekitaran ujian tanpa bergantung kepada pembangun asal.

### 1.2 Skop Termasuk
- Log masuk, log keluar, pendaftaran (semua peranan), lupa/tukar kata laluan.
- Aliran penuh Borang A–E untuk Shuttle 3 (Kilang Papan), Shuttle 4 (Kilang Papan Lapis/Venir), Shuttle 5 (Kilang Kayu Kumai).
- Aliran kelulusan merentasi peranan: IBK → PHD → IPJPSM, dengan JPN sebagai peranan lihat-sahaja (read-only).
- Semua modul data rujukan/pentadbiran (30+ modul CRUD).
- Modul Laporan (Excel/PDF) — kedua-dua data semasa (≥2021) dan data lama (mysql2, sebelum 2021).
- Modul Pengumuman, Notifikasi Kilang, Mod Penyelenggaraan, Kunci Sistem/Panel Kawalan.
- Pengendalian ralat, kes sempadan, dan pengujian keselamatan asas (bukan pentest penuh).
- Dokumentasi konfigurasi/kredensial persekitaran ujian.

### 1.3 Skop Tidak Termasuk
- Ujian penembusan (penetration testing) formal — hanya semakan keselamatan asas disertakan (Bahagian 12).
- Ujian beban/prestasi berskala penuh (load testing dengan alat automasi) — hanya panduan asas disertakan (Bahagian 13), memandangkan pelayan pengeluaran adalah spesifikasi rendah/perkongsian.
- Ciri masa nyata (real-time)/Pusher — disahkan **tidak dilaksanakan** dalam kod (konfigurasi wujud tetapi `resources/js/bootstrap.js` dikomen sepenuhnya), jadi digugurkan daripada skop.
- Integrasi S3/AWS — konfigurasi wujud dalam `.env.example` tetapi **tiada kod** memanggil `Storage::disk('s3')`; semua muat naik fail menggunakan storan tempatan (`public/uploads`). Sahkan dengan pihak EKBK sama ada ini dirancang untuk masa depan sebelum dimasukkan ke skop.

---

## 2. Peranan & Tanggungjawab

| Peranan | Tanggungjawab |
|---|---|
| **Pembangun/Kontraktor** (Muhammad Faiz Abdullah) | Menyediakan persekitaran ujian, mendokumentasikan konfigurasi (Bahagian 4), membekalkan akaun ujian awal (Bahagian 5), menyokong semasa UAT |
| **Pasukan Pengujian FAT** (dicadangkan: pembangun + wakil teknikal EKBK) | Menjalankan ujian teknikal/integrasi/keselamatan asas di persekitaran staging sebelum UAT rasmi |
| **Pasukan Pengujian UAT** (wakil sebenar setiap peranan: IBK, PHD, JPN, IPJPSM, BPM) | Menjalankan kes ujian bisnes mengikut peranan sebenar mereka, mengesahkan aliran kerja memenuhi keperluan sebenar |
| **Pemilik Sistem/Pentadbir IPJPSM** | Memberi kelulusan akhir (sign-off), menentukan sama ada isu yang ditemui adalah penghalang (blocker) atau boleh diterima |

---

## 3. Prasyarat Persekitaran Pengujian

> **Nota konteks**: Sistem eShuttle sudah dihoskan secara langsung (live) di pelayan yang diuruskan sepenuhnya oleh pembangun/kontraktor. Kod sumber (repositori Git projek ini) **tidak diserahkan** kepada EKBK dan bukan sebahagian daripada skop penyerahan UAT/FAT — ia kekal di pelayan/mesin pembangun sahaja. Pasukan pengujian EKBK **tidak perlu memasang atau mengkonfigurasi pelayan sendiri**; bahagian ini menerangkan komponen teknikal sistem (untuk makluman) dan pengesahan kesediaan yang perlu dibuat oleh pembangun sebelum UAT bermula.

### 3.1 Keperluan Perisian (Rujukan — Diuruskan oleh Pembangun)
| Komponen | Versi/Keperluan |
|---|---|
| PHP | 7.3 atau 8.0 (mengikut `composer.json`) |
| MySQL/MariaDB | **Dua (2) pangkalan data/sambungan** diperlukan — lihat 3.2 |
| Composer | Versi terkini serasi PHP 7.3/8.0 |
| Node.js + NPM | Untuk `npm install && npm run production` (aset front-end) — hanya diperlukan jika kod front-end diubah; tidak wajib untuk UAT fungsian sahaja |
| wkhtmltopdf | Tidak lagi diperlukan secara lalai — enjin PDF laporan kini `dompdf` (pustaka PHP tulen). Hanya perlu dipasang jika enjin ditukar semula kepada `snappy` |
| Symlink storan awam | `php artisan storage:link` — wajib dijalankan, jika tidak, gambar muat naik pendaftaran (IC, sijil SSM, dll.) tidak akan dipaparkan |

### 3.2 Pangkalan Data — Dua Sambungan Diperlukan
Sistem ini menggunakan **dua sambungan MySQL berasingan**:
1. **`mysql` (utama)** — semua data semasa: pengguna, borang, kilang, dsb.
2. **`mysql2` (legasi)** — data laporan sejarah **sebelum 2021** (`Laporan Data Lama`). Digunakan khusus oleh modul Laporan (rujuk Bahagian 8.4/9.4/10.4) untuk laporan bernombor 101–146/208/234/235/333.

Kedua-dua sambungan **mesti disediakan dan boleh dicapai** sebelum UAT modul Laporan bermula, jika tidak laporan bagi tahun sebelum 2021 akan gagal/kosong. Terdapat pautan pangkalan data contoh (dummy) dalam `.env.example` (rujuk komen baris 24) — sahkan dengan pembangun sama ada ini sesuai untuk persekitaran ujian atau salinan data sebenar (dianonimkan) diperlukan.

### 3.3 Pengesahan Kesediaan Pelayan Sebelum UAT

Memandangkan sistem sudah live di pelayan sedia ada (bukan persekitaran baharu yang perlu dipasang dari kosong), langkah-langkah berikut adalah **pengesahan kesediaan** yang perlu dibuat oleh pembangun sebelum UAT/FAT bermula — bukan arahan yang perlu dijalankan oleh EKBK:

| # | Pengesahan | Tanggungjawab |
|---|---|---|
| 1 | Kod terkini (termasuk semua pembaikan yang didokumenkan dalam pelan ini) telah digunakan (deployed) ke pelayan | Pembangun |
| 2 | `php artisan migrate` dijalankan — tiada migrasi pangkalan data tertunggak | Pembangun |
| 3 | Nilai `.env` diisi lengkap mengikut Bahagian 4 (terutama `MAIL_FROM_ADDRESS`, `LICENSE_SECRET`, `CONTROL_PANEL_TOKEN`) | Pembangun |
| 4 | `php artisan storage:link` wujud — muat naik/gambar boleh dipaparkan | Pembangun |
| 5 | Cache lama dikosongkan selepas deploy terkini (`config:clear`, `route:clear`, `view:clear`, `cache:clear`) — rujuk `DEPLOY_ARTISAN_STEPS.md` untuk susunan penuh | Pembangun |
| 6 | URL akses sistem dan kredensial akaun ujian (Bahagian 5) disediakan kepada pasukan pengujian EKBK | Pembangun |

> **Pertimbangan penting — data ujian bercampur data sebenar**: Jika UAT/FAT dijalankan terus di atas pelayan pengeluaran (live) yang sama dengan data sebenar EKBK, tindakan ujian (pendaftaran kilang ujian, penghantaran borang ujian, dll.) akan mencipta rekod ujian bercampur dengan data sebenar. Disyorkan supaya UAT/FAT dijalankan di **salinan staging** berasingan jika praktikal untuk disediakan; jika tidak, pastikan semua data ujian (nama kilang, nama pengguna) dikenal pasti dengan jelas (cth prefix "UJIAN-") supaya mudah disemak dan dibersihkan selepas UAT selesai.

> ⚠️ **Amaran**: JANGAN jalankan skrip pembetulan data (`formc:*`, `daerah:fix-*`, seeder `Fix*Seeder`) pada pelayan live tanpa membuat sandaran (backup) pangkalan data terlebih dahulu — skrip ini menulis terus ke data pengeluaran sebenar. Lihat Lampiran A untuk penjelasan penuh setiap arahan.

---

## 4. Senarai Konfigurasi & Kunci (.env) Diperlukan

> ⚠️ **Nota keselamatan penting**: Dokumen ini **sengaja tidak mengandungi sebarang nilai kredensial sebenar** (kata laluan, kunci API, token). Ruangan "Nilai" dalam jadual di bawah menerangkan *cara memperoleh/menjana* nilai tersebut, bukan nilai sebenar. Nilai kredensial sebenar mesti disalurkan kepada pasukan pengujian melalui saluran selamat (contoh: pengurus kata laluan berkongsi, bukan e-mel/mesej biasa), berasingan daripada dokumen ini.

> **Nota pemilikan pelayan**: Sistem dihoskan dan diuruskan sepenuhnya oleh pembangun/kontraktor (bukan di infrastruktur EKBK). Oleh itu, hampir semua kredensial peringkat pelayan/pangkalan data di bawah disediakan dan diuruskan oleh **Pembangun** sahaja — EKBK tidak perlu (dan tidak akan diberi) akses langsung kepada pelayan atau pangkalan data.

| Kunci `.env` | Tujuan | Cara Memperoleh Nilai | Disediakan Oleh | Sensitiviti |
|---|---|---|---|---|
| `APP_NAME` | Nama paparan aplikasi | Tetapkan terus, cth. `"eShuttle EKBK"` | Pembangun | Rendah |
| `APP_ENV` | Persekitaran (`local`/`staging`/`production`) | Tetapkan mengikut persekitaran | Pembangun | Rendah |
| `APP_KEY` | Kunci penyulitan Laravel (sesi, kata laluan, dsb.) | Jana dengan `php artisan key:generate` — **jangan kongsi/guna semula merentasi persekitaran** | Pembangun | **Tinggi** |
| `APP_DEBUG` | Papar surih ralat terperinci | **Mesti `false` di staging/pengeluaran** — amalan keselamatan standard | Pembangun | Tinggi (risiko jika `true`) |
| `APP_URL` | URL asas aplikasi | URL pelayan live/staging sebenar (disediakan oleh pembangun) | Pembangun | Rendah |
| `DB_HOST/PORT/DATABASE/USERNAME/PASSWORD` | Sambungan DB utama | Diuruskan terus oleh pembangun (hosting sendiri) | Pembangun | **Tinggi** |
| `DB_HOST2/PORT2/DATABASE2/USERNAME2/PASSWORD2` | Sambungan DB legasi (`mysql2`, data sebelum 2021) | Diuruskan terus oleh pembangun — **wajib untuk UAT modul Laporan** | Pembangun | **Tinggi** |
| `LICENSE_SECRET` | Rahsia HMAC untuk sistem kunci/buka kunci sistem (`SystemLicenseController`) | Jana nilai rawak panjang: `php artisan key:generate --show` (pinjam penjana sedia ada) — **berasingan daripada `APP_KEY`, jangan kongsi nilai sama** | Pembangun | **Sangat Tinggi** |
| `CONTROL_PANEL_TOKEN` | Token akses panel kawalan kunci sistem tanpa log masuk (`/system-control/{token}`) — wajib ditambah secara manual ke `.env` | Jana nilai rawak panjang serupa `LICENSE_SECRET`; simpan hanya dengan pembangun | Pembangun | **Sangat Tinggi** |
| `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION` | Persediaan SMTP untuk semua e-mel sistem (kelulusan, reset kata laluan, notifikasi) | Guna penyedia SMTP rasmi EKBK jika alamat e-mel EKBK mahu digunakan sebagai penghantar, atau penyedia SMTP pembangun — sahkan dengan EKBK pilihan yang dikehendaki | EKBK/Pembangun | **Tinggi** |
| `MAIL_AUTH_MODE` | Kaedah pengesahan SMTP paksa (`login`/`plain`) — hanya perlu jika pelayan SMTP guna NTLM dan gagal secara lalai | Tinggalkan kosong melainkan ralat "Undefined offset: 3" berlaku | Pembangun | Rendah |
| `MAIL_FROM_ADDRESS` | Alamat penghantar e-mel — **wajib diisi, bukan `null`** (jika tidak, e-mel senyap gagal dihantar tanpa sebarang ralat dipaparkan) | Alamat e-mel rasmi EKBK (untuk kredibiliti penghantar kepada IBK/PHD/JPN) | EKBK | Sederhana |
| `MAIL_FROM_NAME` | Nama penghantar e-mel | Tetapkan terus | Pembangun | Rendah |
| `AWS_ACCESS_KEY_ID` / `AWS_SECRET_ACCESS_KEY` / `AWS_DEFAULT_REGION` / `AWS_BUCKET` | Konfigurasi S3 — **disahkan tidak digunakan oleh sebarang kod semasa** | Boleh dibiarkan kosong buat masa ini; sahkan dengan EKBK sebelum diaktifkan | — | Rendah (tidak aktif) |
| `PUSHER_APP_*` | Konfigurasi masa nyata — **disahkan tidak dilaksanakan** (Echo/Pusher dikomen dalam `resources/js/bootstrap.js`) | Boleh dibiarkan kosong | — | Rendah (tidak aktif) |
| `SESSION_LIFETIME` | Tempoh sesi log masuk (minit) | Nilai lalai 120 minit; sahkan sesuai dengan polisi keselamatan EKBK | Pembangun/EKBK | Rendah |
| `LOG_CHANNEL`, `LOG_LEVEL` | Konfigurasi log ralat aplikasi | Lalai `stack`/`debug`; cadangan tukar `LOG_LEVEL=error` di pengeluaran | Pembangun | Rendah |

### 4.1 Kredensial/Akses Tambahan Bukan-`.env`
| Item | Tujuan | Disediakan Oleh |
|---|---|---|
| Akses SSH/panel hosting ke pelayan | Menjalankan arahan `artisan`, memuat naik kod (rujuk `DEPLOY_ARTISAN_STEPS.md`) | **Pembangun sahaja** — hosting diuruskan sendiri oleh pembangun, EKBK tidak memerlukan/diberi akses ini |
| Akses phpMyAdmin/klien MySQL ke kedua-dua DB | Menyemak/membetulkan data semasa UAT, mengesahkan hasil ujian di peringkat data | Pembangun — boleh disediakan sementara kepada wakil teknikal EKBK untuk tujuan FAT jika diperlukan |
| Akaun kotak masuk e-mel ujian (boleh berkongsi satu peti sahaja, atau guna Mailtrap) | Mengesahkan e-mel sistem benar-benar diterima (bukan hanya "tiada ralat dihantar") | Pasukan Pengujian |

---

## 5. Akaun Pengguna Ujian Diperlukan

### 5.1 Akaun Terbenih (Seeded) — Sedia Selepas `php artisan db:seed`
Seeder `database/seeders/UserSeeder.php` mencipta akaun berikut secara automatik pada persekitaran ujian baharu. **Kata laluan lalai untuk semua akaun terbenih ialah `1234567890`** — wajib ditukar/dilumpuhkan sebelum sistem live, dan hanya sesuai untuk persekitaran ujian tertutup:

| Peranan | `login_id` | E-mel | Nota |
|---|---|---|---|
| IPJPSM (BPE) | `1` | ipjpsm@ekbk.com | Peranan pentadbir tertinggi — kelulusan akhir semua permohonan |
| BPM | `10` | bpm@ekbk.com | Peranan BPM belum aktif digunakan buat masa ini — uji AUTH-10 dahulu untuk sahkan status semasa sebelum bergantung pada akaun ini |
| JPN | `3` | jpn@ekbk.com | Ditetapkan pada Johor/Johor Selatan — tukar jika perlu uji negeri lain |
| PHD | `4` | phd@ekbk.com | Ditetapkan pada Johor/Johor Selatan — tukar jika perlu uji daerah lain |

> Tiada akaun IBK terbenih — akaun IBK **mesti dicipta melalui aliran pendaftaran sebenar** (Bahagian 8.1/9.1/10.1) supaya aliran kelulusan penuh turut diuji.

### 5.2 Akaun Tambahan Yang Perlu Dicipta Semasa UAT
> **Penting** (rujuk Bahagian 7.6): setiap pendaftaran IBK mencipta **dua** akaun serentak — akaun **pemilik kilang** (log masuk No. SSM) dan akaun **peribadi** (log masuk No. Kad Pengenalan). Sejak ciri "Sekatan Akaun Pemilik Kilang" ditambah, hanya akaun **peribadi (No. KP)** boleh mengisi/melihat borang — pasukan pengujian wajib ada akses kepada **kedua-dua** set kredensial bagi setiap kilang ujian untuk menguji had sekatan ini dengan betul.

| Akaun Diperlukan | Cara Mencipta | Bilangan Dicadangkan |
|---|---|---|
| IBK — Shuttle 3 (Kilang Papan) | Daftar melalui `/pendaftaran` → lulus kelulusan IPJPSM/PHD | Sekurang-kurangnya 1 kilang (2 set kredensial: pemilik kilang No. SSM + peribadi No. KP) |
| IBK — Shuttle 4 (Kilang Papan Lapis/Venir) | Sama seperti atas, pilih jenis shuttle 4 | Sekurang-kurangnya 1 kilang (2 set kredensial) |
| IBK — Shuttle 5 (Kilang Kayu Kumai) | Sama seperti atas, pilih jenis shuttle 5 | Sekurang-kurangnya 1 kilang (2 set kredensial) |
| PHD tambahan (daerah lain) | `PengurusanPengguna\MainController::tambah_pengguna_ipjpsm()` — maksimum 2 pengguna aktif setiap daerah | 1–2, untuk uji had 2-per-daerah |
| JPN tambahan (negeri lain) | Sama seperti atas — maksimum 2 pengguna aktif setiap negeri | 1–2, untuk uji had 2-per-negeri |

### 5.3 Data Ujian Berkaitan Identiti
- **Nombor Kad Pengenalan Malaysia ujian**: guna nombor format sah (12 digit, tarikh lahir sah, kod negeri lahir 01-16/21-59/82-83) — boleh jana nombor fiksyen untuk data ujian. Jangan guna IC sebenar sesiapa.
- **Nombor pendaftaran SSM ujian**: format bebas, unik bagi setiap `shuttle_type` (boleh guna nombor SSM sama untuk shuttle_type berbeza — ini dibenarkan sengaja mengikut peraturan pengesahan).

---

## 6. Data Rujukan (Master Data) Diperlukan Sebelum Ujian

`php artisan db:seed` (menggunakan `DatabaseSeeder.php`) akan mengisi data rujukan asas berikut secara automatik — sahkan semuanya berjaya sebelum memulakan UAT modul borang:

| Data Rujukan | Seeder | Digunakan Oleh |
|---|---|---|
| Pengguna asas | `UserSeeder` | Log masuk awal |
| Hak Milik Syarikat | `HakMilikSyarikat` | Borang pendaftaran kilang |
| Kewarganegaraan | `Kewarganegaraan` | Pendaftaran, laporan tenaga kerja |
| Taraf Sah Syarikat | `TarafSahSyarikat` | Pendaftaran kilang |
| Jenis Kayu Kumai | `JenisKayuKumai` | Borang C Shuttle 5 |
| Jenis Pembeli Shuttle 3/4 | `JenisPembeliShuttle3`, `JenisPembeliShuttle4` | Rekod jualan |
| Kategori Pekerja | `KategoriPekerja` | Laporan guna tenaga |
| Kumpulan Kayu & Spesies | `KumpulanKayuKayan`, `Spesies` | **Kritikal** — struktur Borang C (KKB/KKS/KKR/Kayu Lembut/Lain-Lain) bergantung sepenuhnya kepada data ini |
| Status Operasi | `StatusOperasi` | Status kilang |
| Tetapan Buffer | `BufferSeeder` | Kawalan tempoh tangguh pengisian borang |
| Negeri & Daerah | `NegeriSeeder`, `Daerah` | Pendaftaran, penetapan PHD/JPN, semua laporan ikut negeri/daerah |
| Kadar Pemulihan (Recovery Rate) | `RecoveryRateSeeder` | Pengesahan hasil Borang C |

> **Perhatian**: `ShuttleSeeder` **dikomen keluar** dalam `DatabaseSeeder.php` — tiada data kilang contoh terbenih. Ini bermakna semua rekod kilang ujian mesti dicipta melalui aliran pendaftaran sebenar (Bahagian 5.2), yang sebenarnya baik untuk UAT kerana turut menguji aliran pendaftaran.

---

## 7. Kes Ujian Am (Merentasi Semua Shuttle)

> **Format**: Setiap kes ujian mempunyai ID, Peranan, Langkah, dan Hasil Dijangka. Tandakan **Lulus/Gagal** dan catat nombor rujukan jika ada isu (rujuk templat log isu di Bahagian 17). Kes ujian di bahagian ini **tidak bergantung kepada jenis Shuttle** — jalankan sekali sahaja (guna mana-mana kilang ujian). Kes ujian yang bergantung kepada jenis Shuttle disusun berasingan di Bahagian 8 (Shuttle 3), 9 (Shuttle 4), dan 10 (Shuttle 5).

### 7.1 Log Masuk & Log Keluar

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| AUTH-01 | Semua | Log masuk dengan `login_id` dan kata laluan sah | Berjaya, dialihkan ke papan pemuka mengikut peranan |  |  |
| AUTH-02 | Semua | Log masuk dengan `login_id` tidak wujud | Mesej: "ID Kilang atau Kad pengenalan tidak berdaftar" |  |  |
| AUTH-03 | Semua | Log masuk dengan kata laluan salah | Mesej: "Kata laluan tidak sah" |  |  |
| AUTH-04 | Semua | Log masuk dengan akaun `status=0` (dinyahaktifkan) | Mesej: "Akaun anda telah dinyahaktifkan..." |  |  |
| AUTH-05 | Semua | Log masuk berulang kali dengan kata laluan salah (≥5–6 kali) | Sistem menyekat sementara (throttle) mengikut had lalai Laravel |  |  |
| AUTH-06 | IBK (kilang) | Log masuk guna `login_id` format `SSM/3` (satu garis miring) | Berjaya |  |  |
| AUTH-07 | IBK (kilang) | Log masuk guna `login_id` format tidak sah (>1 garis miring, cth `SSM/3/extra`) | Ditolak sebelum cuba log masuk |  |  |
| AUTH-08 | Semua | Log keluar | Sesi ditamatkan, dialihkan ke halaman log masuk, cubaan akses semula halaman dalaman ditolak |  |  |
| AUTH-09 | Semua (kecuali BPE) | Log masuk semasa Mod Penyelenggaraan aktif | Dihalang (halaman 503 penyelenggaraan), kecuali BPE |  |  |
| AUTH-10 | BPM | Log masuk sebagai BPM | Sahkan tingkah laku sebenar — peranan BPM belum aktif digunakan buat masa ini; laporkan sebarang ralat yang berlaku |  |  |

### 7.2 Pendaftaran PHD/JPN & Tambah Pengguna oleh IPJPSM

> Pendaftaran **IBK** (yang bergantung kepada jenis Shuttle) telah dipindahkan ke Bahagian 8.1/9.1/10.1. Bahagian ini hanya meliputi pendaftaran PHD/JPN (berasaskan daerah/negeri, bukan Shuttle) dan tambahan pengguna terus oleh IPJPSM.

**7.2.1 Pendaftaran PHD/JPN — `/pendaftaran`**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| REG-PHD-01 | Daftar akaun PHD baharu untuk daerah yang belum ada 2 pengguna aktif | Berjaya, `is_approved_ipjpsm=0`, kata laluan awal `1234567890`, notifikasi ke semua IPJPSM |  |  |
| REG-PHD-02 | Daftar akaun PHD ke-3 untuk daerah yang **sudah** ada 2 pengguna aktif | Ditolak — mesej "Setiap Pejabat Hutan Daerah hanya boleh mendaftar terhad kepada dua pengguna aktif sahaja." |  |  |
| REG-JPN-01 | Ulang REG-PHD-01/02 untuk peranan JPN mengikut negeri | Had 2-per-negeri berkuat kuasa sama seperti PHD |  |  |

**7.2.2 Tambah Pengguna Terus oleh IPJPSM**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| REG-ADM-01 | IPJPSM tambah pengguna PHD/JPN/BPE/BPM baharu terus melalui `/admin/pengurusan-pengguna-tambah` | Pengguna dicipta dengan `is_approved_ipjpsm=1` (terus diluluskan), kata laluan rawak 8-aksara dijana dan **dihantar melalui e-mel** (`SendRegistrationMail`) |  |  |
| REG-ADM-02 | Sahkan had 2-per-daerah/negeri turut berkuat kuasa di laluan ini | Ditolak jika melebihi had |  |  |

### 7.3 Lupa Kata Laluan / Tukar Kata Laluan / Jana Kata Laluan oleh Admin

> Sistem kini menawarkan **dua** laluan untuk pengguna yang lupa kata laluan: (a) laluan layan-diri "Terlupa Kata Laluan" (PWD-01–06), dan (b) laluan **disyorkan**, iaitu admin (IPJPSM/BPE) menjana kata laluan baharu terus untuk pengguna (PWD-07). Kedua-dua laluan wajib diuji.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| PWD-01 | Guna "Terlupa Kata Laluan" dengan e-mel berdaftar | E-mel reset kata laluan diterima (`ResetPasswordMail`) |  |  |
| PWD-02 | Guna "Terlupa Kata Laluan" dengan e-mel tidak berdaftar | Mesej sesuai tanpa mendedahkan e-mel wujud/tidak (semak amalan keselamatan semasa) |  |  |
| PWD-03 | Ikuti pautan reset, tetapkan kata laluan baharu (≥8 aksara, sahkan padanan) | Kata laluan dikemas kini untuk semua akaun yang berkongsi e-mel tersebut |  |  |
| PWD-04 | **Kes sempadan penting**: jika satu e-mel dikongsi oleh lebih daripada satu akaun (cth akaun kilang & peribadi IBK berkongsi `email_kilang`), sahkan reset **tidak** tersasar mengemas kini akaun lain yang tidak dijangka | Hanya akaun yang sepatutnya terjejas dikemas kini |  |  |
| PWD-05 | Guna semula pautan reset yang sama selepas selesai digunakan sekali | Ditolak (token sudah dipadam selepas guna) |  |  |
| PWD-06 | Pengguna log masuk tukar kata laluan sendiri (`/profil/tukar-kata-laluan`) | Kata laluan lama diperlukan, kata laluan baharu berjaya disimpan |  |  |
| PWD-07 | IPJPSM/BPE klik butang **"Jana Kata Laluan Baharu"** (ikon kunci) pada senarai PHD, JPN, BPM (ikon kunci sama turut wujud pada setiap senarai IBK/Kilang Shuttle 3/4/5 — rujuk PWD-Sx-01 di Bahagian 8.4/9.4/10.4), sahkan pada tetingkap pengesahan | Kata laluan pengguna/akaun berkenaan digantikan dengan kata laluan rawak baharu; e-mel `PasswordRegeneratedMail` diterima dengan kata laluan baharu; boleh log masuk dengan kata laluan baharu itu serta-merta |  |  |
| PWD-08 | Sahkan pengguna bukan-admin (PHD/JPN/IBK) **tidak** boleh mencapai laluan `ipjpsm.jana-kata-laluan` secara terus | Ditolak/dialihkan (laluan dilindungi middleware `auth`+`admin`) |  |  |

### 7.4 Papan Pemuka (Dashboard) Mengikut Peranan

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| DASH-01 | IBK | Log masuk, semak papan pemuka | Senarai tugasan borang tahun semasa dipaparkan dengan status betul |  |  |
| DASH-02 | PHD | Log masuk, semak papan pemuka | Kiraan tugasan (permohonan tertunggak, borang menunggu semakan) untuk daerah yang ditetapkan sahaja |  |  |
| DASH-03 | JPN | Log masuk, semak papan pemuka | Paparan ikut negeri yang ditetapkan, akses baca sahaja |  |  |
| DASH-04 | IPJPSM | Log masuk, semak papan pemuka + graf keseluruhan (`borangKeseluruhan`) | Data keseluruhan merentasi semua negeri/kilang dipaparkan dan graf dijana betul |  |  |
| DASH-05 | Semua | Sahkan kiraan pada papan pemuka (cth "X permohonan tertunggak") sepadan dengan bilangan sebenar rekod dalam pangkalan data | Tiada percanggahan angka |  |  |

### 7.5 Cetak PDF Borang (Mekanisme Am)

> Mekanisme cetak PDF adalah **sama** merentasi semua jenis borang dan Shuttle — kes ujian di bawah menguji mekanisme itu sendiri sekali sahaja secara mendalam. Senarai borang khusus untuk diulang bagi setiap Shuttle disenaraikan dalam sub-bahagian "Cetak PDF" di bawah setiap Shuttle (8.1/9.1/10.1 dan seterusnya).

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| PDF-01 | Cetak Borang A yang berstatus `Dihantar ke IPJPSM`/`Lulus` | PDF dijana dengan data lengkap dan format betul |  |  |
| PDF-02 | Cuba cetak Borang A/B/C/D berstatus `Tidak Diisi` atau `Tidak Lengkap` | **Ditolak** — mesej "Borang [X] belum selesai untuk dicetak" |  |  |
| PDF-03 | Sahkan fon/aksara Bahasa Malaysia (nama berhuruf besar, tanda baca) dipaparkan betul dalam PDF | Tiada aksara rosak/kotak kosong |  |  |

### 7.6 Modul Data Rujukan/Pentadbiran (CRUD)

Semua modul berikut mengikut corak **sama** (kebanyakannya Livewire dalam-halaman, beberapa CRUD kawalan klasik) — guna templat kes ujian generik di bawah untuk **setiap** modul dalam senarai. Modul ini digunakan **bersama** oleh Shuttle 3, 4, dan 5 (bukan khusus satu Shuttle), maka kekal di sini.

**Templat Kes Ujian CRUD Generik** (ganti `[Entiti]` dengan nama modul):
1. Lihat senarai `[Entiti]` sedia ada — paparan/carian/penyusunan berfungsi.
2. Tambah rekod `[Entiti]` baharu dengan data sah — berjaya, muncul dalam senarai.
3. Tambah rekod dengan medan wajib kosong — ditolak dengan mesej pengesahan.
4. Edit rekod sedia ada — perubahan disimpan dan dipaparkan semula dengan betul.
5. Padam rekod — sahkan kesan pada data yang **bergantung** kepadanya (cth padam `KumpulanKayu` yang sudah digunakan dalam `KemasukanBahan` sedia ada — adakah rekod sejarah masih boleh dipaparkan?).
6. Sahkan akses **hanya** IPJPSM/BPM (mengikut laluan `/admin/*` vs `/bpm/*`) — cuba akses sebagai IBK/PHD/JPN, sahkan ditolak. Turut sahkan laluan tidak boleh dicapai secara terus tanpa log masuk (log keluar dahulu, cuba akses URL terus).

**Senarai Modul Untuk Diuji (guna templat di atas):**

| Modul | Kesan Jika Rosak |
|---|---|
| Daerah (`DaerahController`) | Salah pemetaan negeri/daerah pada semua borang dan laporan |
| Tetapan Buffer (`BufferController`) | Kawalan tempoh borang tidak berfungsi |
| Kadar Pemulihan (`RecoveryRateController`) | Pengesahan hasil Borang C salah/tiada |
| Hak Milik Syarikat | Senarai pilihan salah semasa pendaftaran kilang |
| Jenis Pembeli Shuttle 3/4 | Rekod jualan tidak boleh dikategorikan |
| Jenis Kayu Kumai | Borang C Shuttle 5 tidak lengkap |
| Kategori Pekerja | Laporan guna tenaga tidak tepat |
| Kewarganegaraan | Pendaftaran & laporan tenaga kerja terjejas |
| **Kumpulan Kayu** | ⚠️ **Kesan tertinggi** — struktur keseluruhan Borang C (KKB/KKS/KKR/Kayu Lembut/Lain-Lain) bergantung terus kepada jadual ini |
| Spesies / Spesies Aktif | Senarai pilihan spesies semasa Borang C salah/hilang |
| Taraf Syarikat | Pendaftaran kilang terjejas |
| Pengurusan Pengguna (senarai & status aktif/nyahaktif ikut peranan) | Kawalan akses pengguna keseluruhan sistem |

### 7.7 Kawalan Buffer (Tempoh Tangguh)

> Tetapan buffer adalah mekanisme **am** (satu modul tetapan digunakan merentasi semua Shuttle) — walaupun kesannya dilihat semasa mengisi borang bagi Shuttle tertentu.

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| BUF-01 | IPJPSM | Semak tetapan buffer lalai (`/admin/tetapan-buffer`) — sahkan togol `aktif` OFF secara lalai | Borang tidak ditutup automatik walaupun melepasi tarikh tutup |  |  |
| BUF-02 | IPJPSM | Aktifkan buffer untuk satu jenis borang/shuttle, cuba isi borang melepasi tempoh dibenarkan (ulang untuk Shuttle 3/4/5) | Borang ditutup mengikut tetapan buffer |  |  |
| BUF-03 | IPJPSM | Kemas kini buffer secara pukal (`buffer_id=0` — semua rekod) | Semua rekod buffer dikemas kini serentak |  |  |

### 7.8 Pengumuman (Papan Pengumuman Berperingkat)

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| ANN-01 | IPJPSM | Cipta pengumuman baharu | Kelihatan kepada semua JPN |  |  |
| ANN-02 | JPN | Cipta pengumuman (ditapis mengikut negeri) | Kelihatan kepada PHD dalam negeri berkenaan sahaja |  |  |
| ANN-03 | PHD | Cipta pengumuman (ditapis mengikut daerah) | Kelihatan kepada IBK dalam daerah berkenaan sahaja |  |  |
| ANN-04 | Semua peringkat | Edit/padam pengumuman sendiri | Berfungsi; sahkan tidak boleh edit/padam pengumuman peringkat lain |  |  |

### 7.9 Notifikasi Kilang & Peringatan (Mekanisme Am)

> NOTIF-01/02/05 (senarai kilang belum isi borang & notifikasi IBK→PHD) bergantung kepada jenis Shuttle dan telah dipindahkan ke setiap Shuttle di bawah PHD (8.2/9.2/10.2). Bahagian ini hanya meliputi mekanisme klik-notifikasi am.

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| NOTIF-03 | Semua | Klik notifikasi dalam-aplikasi (loceng) | Ditanda dibaca, dialihkan ke laluan berkaitan |  |  |
| NOTIF-04 | Semua | Klik notifikasi yang data `route`-nya rosak/kosong (kes sempadan — mungkin perlu dicipta manual dalam DB untuk uji) | Mesej ralat mesra dipaparkan, **bukan** ralat sistem (500) |  |  |

### 7.10 Mod Penyelenggaraan

| ID | Peranan | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| MAINT-01 | IPJPSM | Aktifkan mod penyelenggaraan dengan mesej dan tempoh (`start_date`/`end_date`) | Semua peranan lain (kecuali BPE) melihat halaman 503 penyelenggaraan dengan mesej ditetapkan |  |  |
| MAINT-02 | IPJPSM (BPE) | Semasa mod penyelenggaraan aktif, sahkan BPE masih boleh log masuk & guna sistem | Tidak terjejas |  |  |
| MAINT-03 | Semua | Sahkan laluan `login`/`logout`/`password/*` masih boleh dicapai semasa penyelenggaraan | Tidak disekat (dikecualikan sengaja) |  |  |
| MAINT-04 | Sistem | Biarkan `end_date` berlalu (atau tetapkan tarikh lampau) tanpa tindakan manual | `is_active` bertukar `false` secara automatik pada permintaan seterusnya (cache 60 saat) |  |  |
| MAINT-05 | IPJPSM | Nyahaktifkan mod penyelenggaraan secara manual sebelum `end_date` | Sistem kembali normal serta-merta untuk semua peranan |  |  |

### 7.11 Kunci Sistem / Panel Kawalan (Sensitif — Uji di Staging Sahaja)

> ⚠️ Ciri ini adalah **suis kunci mati (kill switch)** peringkat sistem — **jangan sekali-kali** uji langkah kunci pada persekitaran pengeluaran tanpa kelulusan eksplisit dan pelan pemulihan sedia. Uji hanya di persekitaran staging/ujian berasingan.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| LIC-01 | Jalankan `php artisan license:status` | Memaparkan status semasa (kunci kod vs kunci DB) dengan tepat |  |  |
| LIC-02 | Jalankan `php artisan license:lock --reason="Ujian FAT"` | Sistem terkunci — **semua** pengguna (termasuk BPE) melihat halaman `system-locked`, tiada pengecualian |  |  |
| LIC-03 | Cuba log masuk sebagai BPE semasa terkunci | **Mesti ditolak** — sahkan ini berbeza daripada Mod Penyelenggaraan (yang mengecualikan BPE) |  |  |
| LIC-04 | Buka `/system-locked`, masukkan kunci buka kunci yang sah (dijana melalui `php artisan license:key`) | Sistem terbuka semula |  |  |
| LIC-05 | Masukkan kunci buka kunci **salah** berulang kali | Disekat mengikut had kadar (`throttle:5,15`); tidak terbuka |  |  |
| LIC-06 | Akses `/system-control/{token}` dengan token **salah** | **404** dipaparkan (bukan 403) — sengaja tidak mendedahkan kewujudan laluan |  |  |
| LIC-07 | Akses `/system-control/{token}` dengan token **sah** (`CONTROL_PANEL_TOKEN`) | Panel kawalan dipaparkan tanpa perlu log masuk |  |  |
| LIC-08 | Dari panel kawalan sah, kunci dan buka kunci sistem | Berfungsi tanpa perlu kunci HMAC berasingan (token panel sudah mencukupi sebagai pengesahan) |  |  |
| LIC-09 | Sahkan fail `app/license-lock.php` (kunci berasaskan kod) — tukar `'locked' => true` secara manual dan muat naik semula | Sistem terkunci serta-merta walaupun `php artisan config:cache` telah dijalankan sebelumnya (fail dibaca terus, bukan melalui cache config) |  |  |
| LIC-10 | Jalankan `php artisan license:unlock --force` semasa kunci berasaskan **kod** aktif (LIC-09) | **Sahkan tingkah laku sebenar** — kunci kod mungkin tidak boleh dibuka melalui DB/CLI, hanya melalui edit fail semula |  |  |

### 7.12 Log Audit

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| AUDIT-01 | Buat sebarang perubahan pada `User`/`FormA`/`FormB`/`FormC`/`FormD` (cth kemas kini status) | Rekod audit dicipta dalam jadual audit (`owen-it/laravel-auditing`) — sahkan melalui pertanyaan DB terus, kerana **tiada UI** untuk melihatnya |  |  |
| AUDIT-02 | Sahkan dengan EKBK sama ada UI log audit dijangka wujud dalam skop penyerahan semasa | Dokumenkan keputusan — jika ya, ini adalah kerja belum siap yang perlu ditambah sebelum sign-off |  |  |

---

## 8. Kes Ujian — Shuttle 3 (Kilang Papan)

> Shuttle 3 mempunyai Borang **A, B, C, D sahaja** (tiada Borang E). Kelulusan pendaftaran mencipta 1 `FormA`, 4 `FormB` (suku tahunan), 12 `FormC` + 12 `FormD` (bulanan) menggunakan model generik `FormD` (bukan `Form4D`/`Form5D`).

### 8.1 IBK — Shuttle 3

**Pendaftaran (`/register`)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-REG01 | Isi borang pendaftaran penuh dan sah untuk Shuttle 3, hantar | Rekod `Shuttle`, `PenggunaKilang`, 2× `User` (kilang + peribadi) dicipta dengan `is_approved=0`; notifikasi dihantar kepada semua pengguna IPJPSM |  |  |
| S3-IBK-REG02 | Guna nombor SSM yang sama untuk shuttle **jenis sama** (Shuttle 3) dua kali | Ditolak — mesej ralat keunikan |  |  |
| S3-IBK-REG03 | Guna e-mel yang sudah wujud dalam mana-mana jadual (`users`/`pengguna_kilangs`/`shuttles`/`password_resets`) | Ditolak |  |  |
| S3-IBK-REG04 | Isi e-mel peribadi sama dengan e-mel kilang (`email_kilang`) | Ditolak — mesej mengenai medan e-mel mesti berbeza |  |  |
| S3-IBK-REG05 | Isi nombor IC format tidak sah (bukan 12 digit, atau tarikh lahir mustahil cth 30 Februari) | Ditolak |  |  |
| S3-IBK-REG06 | Isi nombor IC dengan digit semakan (check-digit) salah tetapi format/tarikh sah | Sahkan diterima — reka bentuk semasa tidak menyemak digit semakan IC, ini adalah keputusan reka bentuk yang telah disahkan |  |  |
| S3-IBK-REG07 | Tandakan "alamat surat-menyurat sama dengan alamat kilang" — sahkan cabang validasi kedua berfungsi | Borang diterima tanpa perlu isi alamat kedua |  |  |
| S3-IBK-REG08 | Muat naik gambar IC depan/belakang, pasport, kad pekerja, sijil SSM, lesen kilang | Semua fail disimpan, boleh dilihat semula oleh IPJPSM/PHD semasa semakan permohonan (8.4) |  |  |
| S3-IBK-REG09 | Semak simpanan e-mel — pastikan `MAIL_FROM_ADDRESS` diisi dengan betul sebelum uji | Notifikasi diterima oleh semua akaun IPJPSM (dalam-aplikasi **dan** e-mel) |  |  |
| S3-IBK-REG10 | Guna nombor SSM yang **sama** dengan kilang Shuttle 4/5 sedia ada | **Dibenarkan** — pengesahan keunikan SSM adalah per jenis shuttle |  |  |

**Sekatan Akaun Pemilik Kilang** — ciri baharu ditambah semasa persediaan UAT (disahkan dalam kod pada 2 Ogos 2026). Setiap kilang IBK mempunyai **dua akaun**: akaun **pemilik kilang** (log masuk No. SSM, `pengguna_kilang_id` kosong) dan satu atau lebih akaun **pengguna peribadi** (log masuk No. Kad Pengenalan, `pengguna_kilang_id` diisi). Peraturan bisnes: **akaun pemilik kilang (SSM) hanya boleh menguruskan pengguna** — tidak lagi boleh mengisi/melihat borang secara terus. Dikuatkuasakan pada dua peringkat: (a) middleware `App\Http\Middleware\RestrictKilangOwner`, (b) papan pemuka memaparkan kad/ikon dilumpuhkan.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-OWN01 | Akaun pemilik kilang (No. SSM) log masuk, semak papan pemuka | Kad navigasi Senarai A–D Shuttle 3 dipaparkan **kelabu/pudar dan tidak boleh diklik** |  |  |
| S3-IBK-OWN02 | Akaun pemilik kilang cuba akses terus URL Senarai/List/isi borang/lihat borang Shuttle 3 secara manual (taip URL) | **Dialihkan** ke `home-user.user-management` dengan mesej: "Akaun pemilik kilang (No. SSM) hanya boleh menguruskan pengguna..." |  |  |
| S3-IBK-OWN03 | Akaun pemilik kilang sahkan **masih boleh** akses Pengurusan Pengguna untuk tambah/urus akaun peribadi (No. KP) | Berjaya — laluan ini tidak disekat |  |  |
| S3-IBK-OWN04 | Akaun pemilik kilang sahkan eksport PDF Senarai Shuttle 3 turut disekat | Dialihkan sama seperti S3-IBK-OWN02 |  |  |
| S3-IBK-OWN05 | Akaun **peribadi** (No. KP) ulang OWN01–02 | Semua kad/pautan/laluan berfungsi **normal sepenuhnya** — tiada sekatan |  |  |

**Pengisian Borang A (Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-A01 | Isi Borang A (maklumat kilang, alamat, dll.) dan hantar — **guna akaun peribadi (No. KP)**, bukan akaun pemilik kilang | Status bertukar `Tidak Diisi` → `Sedang Diproses`; `batches.borang_a` bertukar `"0"` → `"1"` |  |  |
| S3-IBK-A02 | Selepas PHD tolak (rujuk 8.2), betulkan dan hantar semula Borang A | Status kembali ke `Sedang Diproses`, aliran berulang |  |  |
| S3-IBK-A03 | Cuba akses/isi Borang B/C/D sebelum Borang A dihantar | **Dihalang** — `FormFlowService` menguatkuasakan A mesti diisi dahulu |  |  |

**Pengisian Borang B (Suku Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-B01 | Isi Borang B suku 1 selepas Borang A lulus | Berjaya |  |  |
| S3-IBK-B02 | Cuba isi Borang B suku 2 sebelum suku 1 dihantar | Dihalang mengikut urutan |  |  |
| S3-IBK-B03 | Sahkan tarikh buka/tutup suku (Q1: Mac–Apr, Q2: Jun–Jul, Q3: Sep–Okt, Q4: Dis) berfungsi mengikut jangkaan — **sahkan dengan EKBK sama ada logik "buka pada penghujung suku" ini betul mengikut keperluan sebenar** | Dokumen tingkah laku sebenar untuk pengesahan bisnes |  |  |
| S3-IBK-B04 | PHD tolak Borang B (`Tidak Lengkap`); buka semula borang yang dipulangkan | Jumlah/purata terkira (jantina, gaji, kumpulan bumiputera/bukan-bumiputera/asing) **dipaparkan semula** seperti dihantar asal, bukan kosong (dibaiki 18 Ogos 2026 — medan jumlah terkira sebelum ini sentiasa kosong apabila borang dibuka semula) |  |  |

**Pengisian Borang C (Bulanan — Kemasukan Bahan Kayu)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-C01 | Isi Borang C bulan 1, kategori KKB (Kumpulan Kayu Balak) — masukkan data spesies, kuantiti | Data disimpan dalam `KemasukanBahan`, jumlah dikira betul |  |  |
| S3-IBK-C02 | Ulang C01 untuk kategori KKS, KKR, Kayu Lembut, Lain-Lain | Semua 5 kategori berfungsi bebas |  |  |
| S3-IBK-C03 | Isi kadar pemulihan (recovery rate) di luar julat min/max yang ditetapkan | Ditolak/amaran pengesahan |  |  |
| S3-IBK-C04 | Tandakan "Tiada Pengeluaran" untuk bulan tertentu | Borang C bulan tersebut ditanda tiada pengeluaran, baki stok dibawa ke bulan depan dengan betul |  |  |
| S3-IBK-C05 | Cuba isi Borang C bulan 3 sebelum bulan 2 dihantar | Dihalang — pengisian mesti berurutan bulan-ke-bulan |  |  |
| S3-IBK-C06 | Cuba isi Borang C untuk bulan akan datang (belum sampai) | Dihalang |  |  |
| S3-IBK-C07 | Isi Borang C untuk suku yang Borang B-nya belum dihantar (suku **sebelumnya**, bukan suku semasa) | Dihalang mengikut peraturan `FormFlowService` |  |  |

**Pengisian Borang D (Bulanan)** — Shuttle 3 tiada Borang E

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IBK-D01 | Isi Borang D bulan tertentu selepas Borang C bulan sama dihantar | Berjaya |  |  |
| S3-IBK-D02 | Cuba isi Borang D sebelum Borang C bulan sama dihantar/tanpa rekod `KemasukanBahan`/tanpa tanda tiada pengeluaran | Dihalang |  |  |
| S3-IBK-D03 | Sahkan Borang E **tidak wujud/tidak boleh diakses** untuk Shuttle 3 | Laluan/menu Borang E tiada untuk Shuttle 3 |  |  |

**Cetak PDF** — ulang PDF-01–03 (Bahagian 7.5) untuk Borang A, B, C, D Shuttle 3.

### 8.2 PHD — Shuttle 3

**Pengesahan Borang A–D**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-PHD-A01 | Semak Borang A, sahkan (Sahkan) | Status → `Dihantar ke IPJPSM`; `batches.borang_a` → `"2"` |  |  |
| S3-PHD-A02 | Semak Borang A, tolak dengan ulasan (Tolak, `ulasan_phd` wajib) | Status → `Tidak Lengkap`; `batches.borang_a` → `"0"`; IBK menerima `BorangTidakLengkapNotification`/e-mel dengan ulasan PHD |  |  |
| S3-PHD-B01 | Ulang aliran Sahkan/Tolak (A01/A02) untuk Borang B setiap suku | Sama seperti atas |  |  |
| S3-PHD-C01 | Sahkan/Tolak Borang C dengan ulasan | Sama corak seperti Borang A |  |  |
| S3-PHD-C02 | **Kes regresi penting**: betulkan/tolak Borang C bulan lampau (cth bulan 3) selepas bulan-bulan kemudian (4, 5, 6) sudah diisi | Bulan 4, 5, 6 **kekal boleh diakses** — pembetulan bulan lampau tidak mengunci bulan yang sudah diisi kemudian |  |  |

**Senarai Tugasan (Status/Ikon Tindakan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-PHD-TASK01 | Lihat senarai tugasan Borang 3B dan 3C merangkumi borang berstatus `Sedang Diisi` (IBK sedang isi, belum hantar — hanya berlaku untuk Borang C) dan borang bulan/suku yang telah `Ditutup` | Borang `Sedang Diisi` (3C) memaparkan lencana/ikon "Sedang Diisi oleh IBK"; borang `Ditutup` **tidak** disenaraikan langsung pada 3B/3C (dibaiki 18 Ogos 2026 — sebelum ini kedua-dua kes memaparkan lajur status/ikon tindakan kosong) |  |  |
| S3-PHD-TASK02 | Lihat senarai tugasan Borang 3D merangkumi borang `Ditutup` | ⚠️ **Belum disahkan/dibaiki setakat 18 Ogos 2026** — pembetulan yang sama pada 3B/3C hanya disahkan untuk lajur yang ditandakan oleh EKBK; laporkan jika lajur status/ikon kosong turut berlaku pada 3D |  |  |

**Pakej Bulanan & "Hantar" Borong**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-PHD-BATCH01 | Lihat senarai pakej bulanan berstatus `Sedang Diproses` untuk daerah ditetapkan | Senarai tepat mengikut `daerah_ids` PHD |  |  |
| S3-PHD-BATCH02 | Klik "Hantar" untuk pakej yang **kelima-lima** borang (A–D berkenaan) sudah disahkan (`borang_x = "2"`) | Status pakej → `Dihantar ke IPJPSM` |  |  |
| S3-PHD-BATCH03 | Klik "Hantar" untuk pakej yang **belum lengkap** | **Ditolak** — mesej menyatakan borang mana yang belum disahkan; status pakej kekal `Sedang Diproses` |  |  |
| S3-PHD-BATCH04 | Cuba akses URL "Hantar" secara terus tanpa klik butang (cth taip URL/guna sejarah pelayar) | Laluan hanya menerima kaedah `POST` — percubaan `GET` terus akan mengembalikan 405 Method Not Allowed |  |  |
| S3-PHD-BATCH05 | Klik "Hantar" untuk pakej bulan **bukan** penghujung suku (bulan selain 3/6/9/12) apabila Borang A/C/D sudah disahkan | Berjaya dihantar — Borang B **tidak** disyaratkan di luar bulan penghujung suku (dibaiki 18 Ogos 2026 — sebelum ini sentiasa ditolak) |  |  |

**Notifikasi Kilang & Peringatan**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-PHD-NOTIF01 | Lihat senarai kilang Shuttle 3 yang belum mengisi borang (`notifikasi-kilang`) | Senarai tepat berdasarkan status `Tidak Diisi`/`Tidak Lengkap`/`Sedang Diisi` dan tarikh buffer |  |  |
| S3-PHD-NOTIF02 | Hantar peringatan kepada satu kilang Shuttle 3 khusus | `BorangTidakDiisiNotification` diterima (dalam-aplikasi + e-mel jika `MAIL_FROM_ADDRESS` diisi) oleh semua pengguna kilang berkenaan |  |  |
| S3-PHD-NOTIF03 | IBK hantar Borang B, C, atau D — sahkan PHD daerah berkenaan terima notifikasi loceng dalam-aplikasi (dan e-mel) | Notifikasi diterima (dibaiki 18 Ogos 2026 — pepijat sistemik: kod perbandingan daerah kilang membandingkan nama daerah dengan ID daerah berangka, jadi PHD tidak pernah menerima notifikasi. Disahkan dibaiki untuk Borang 3B, 3C, dan 3D) |  |  |

**Kelulusan Pendaftaran (laluan alternatif PHD)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-PHD-APP01 | Luluskan permohonan pengguna IBK Shuttle 3 melalui laluan PHD (`sahkan_permohonan_phd_ipjpsm`) | Sama seperti kelulusan IPJPSM (rujuk 8.4) tetapi dari peringkat PHD; **12 rekod `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `FormD` dicipta serentak** |  |  |

### 8.3 JPN — Shuttle 3 (Baca Sahaja)

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-JPN01 | Lihat senarai status Borang A–D Shuttle 3 merentasi kilang dalam negeri ditetapkan | Paparan tepat, **tiada butang Sahkan/Tolak/Kemas kini** (peranan baca sahaja) |  |  |
| S3-JPN02 | Cuba akses URL kemas kini status borang secara terus (jika tahu URL) | Ditolak/tiada laluan wujud untuk JPN |  |  |
| S3-JPN03 | Hantar peringatan e-mel kepada kilang Shuttle 3 yang belum mengambil tindakan (`jpn.shuttle-list-jpn.email`) | E-mel `BorangTidakDiambilTindakanMail` diterima oleh kilang berkenaan |  |  |
| S3-JPN04 | Lihat notifikasi (`jpn.notifikasi.list`) berkaitan Shuttle 3 | Senarai notifikasi berkaitan negeri ditetapkan dipaparkan |  |  |
| S3-JPN05 | Semak jumlah/kiraan pada kad papan pemuka "Senarai Borang Yang Belum Disahkan Pegawai Hutan Daerah" — Shuttle 3 (butiran A/B/C/D) untuk negeri dengan borang berstatus `Sedang Diproses` sedia ada | Kiraan **bukan sifar**, sepadan dengan bilangan sebenar borang belum disahkan (dibaiki 18 Ogos 2026 — kiraan sebelum ini sentiasa 0 kerana carian `shuttle_type` tersalah tapis pada jadual Borang A) |  |  |

### 8.4 IPJPSM (JPSM) — Shuttle 3

**Kelulusan/Penolakan Permohonan Pendaftaran**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IPJPSM-APP01 | Lihat senarai permohonan tertunggak (`/admin/status-permohonan-bpe`), termasuk kilang Shuttle 3 | Senarai memaparkan semua permohonan IBK/PHD/JPN baharu |  |  |
| S3-IPJPSM-APP02 | Buka lampiran permohonan kilang Shuttle 3 (gambar IC, sijil SSM, dll.) | Semua fail yang dimuat naik semasa pendaftaran dipaparkan dengan betul |  |  |
| S3-IPJPSM-APP03 | Luluskan permohonan pengguna IBK Shuttle 3 | `is_approved=true`; kata laluan rawak 8-aksara dijana dan dihantar melalui e-mel; **12 rekod `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `FormD` dicipta serentak untuk tahun semasa** |  |  |
| S3-IPJPSM-APP04 | Selepas APP03, sahkan pengguna baharu boleh log masuk dengan kata laluan yang diterima melalui e-mel | Log masuk berjaya |  |  |
| S3-IPJPSM-APP05 | Selepas APP03, semak papan pemuka pengguna baharu — sahkan Borang A–D kosong (`Tidak Diisi`) untuk bulan semasa dan seterusnya wujud, dan bulan **sebelum** pendaftaran turut wujud | Rekod Januari–Disember tahun semasa kesemuanya wujud |  |  |
| S3-IPJPSM-APP06 | Luluskan permohonan **kilang** (`Shuttle`) Shuttle 3 secara berasingan daripada permohonan pengguna | Status kilang bertukar aktif berasingan daripada status pengguna |  |  |
| S3-IPJPSM-APP07 | Tolak/padam permohonan pengguna Shuttle 3 (`delete_user_application`) | Rekod `User` dan `Shuttle` **dipadam terus (hard delete)** — sahkan tiada ralat/rekod anak yatim (orphan) tertinggal pada `FormA/B/C/D` |  |  |
| S3-IPJPSM-APP08 | **Fokus regresi** (18 Ogos 2026): ulang APP03/APP06/S3-PHD-APP01 beberapa kali dengan kombinasi data berbeza (cth kilang tanpa `daerah_id` sah, pengguna dengan `login_id` tidak sepadan rekod sedia ada) | Pengesahan berjaya **tanpa ralat 500 selepas klik sahkan**; jika e-mel gagal dihantar, pengesahan tetap disimpan dan ralat dicatat dalam log sahaja (dibaiki — **keyakinan sederhana**, perlu pengesahan langsung semasa UAT) |  |  |
| S3-IPJPSM-APP09 | Buka borang pengesahan Borang A Shuttle 3 (`ipjpsm.shuttle-3-view-formA`) | Negeri kilang **dipaparkan** (bukan kosong) pada borang pengesahan |  |  |

**Pengurusan Pengguna (Senarai Kilang)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-IPJPSM-PP01 | Buka senarai kilang Shuttle 3 (`ipjpsm.senaraikilang3`) | Lajur **Daerah Hutan** dipaparkan dengan betul (rujukan asas — Shuttle 4/5 dibaiki untuk sepadan, rujuk 9.4/10.4) |  |  |
| S3-IPJPSM-PW01 | Klik butang "Jana Kata Laluan Baharu" pada senarai IBK/Kilang Shuttle 3 (akaun peribadi No. KP **dan** akaun pemilik kilang No. SSM) | Kata laluan digantikan dengan kata laluan rawak baharu; e-mel `PasswordRegeneratedMail` diterima; boleh log masuk serta-merta |  |  |

**Modul Laporan — Shuttle 3 (Nombor 1xx)**

> Terdapat >100 kombinasi laluan laporan Shuttle 3 (nombor laporan × format eksport). **Tidak praktikal diuji satu-persatu** — guna strategi persampelan berikut, ditambah kes ujian khusus bagi laporan yang telah dibaiki.

| Kumpulan Laporan | Contoh Nombor | Apa Diuji |
|---|---|---|
| Senarai kilang | 101 | Data kilang & carian ikut kategori pemilikan |
| Guna tenaga & pendapatan | 111 | Parameter julat suku tahun (`suku_tahun`–`suku_tahun_akhir`) |
| Penggunaan kayu | 121 | Parameter bulan/tahun/kumpulan kayu |
| Pengeluaran | 131 | Parameter negeri/bulan/tahun/kumpulan kayu/spesies |
| Jualan domestik | 141 | Parameter bulan/negeri/pembeli/tahun |

Untuk **setiap** laporan sampel di atas: (1) jana Excel, sahkan data/subtotal betul; (2) jana PDF jika tersedia; (3) jana dengan tahun **sebelum 2021**, sahkan capaian DB legasi (`mysql2`); (4) jana dengan parameter kosong/tiada data, sahkan paparan "tiada data" sesuai; (5) sahkan hanya IPJPSM/BPE boleh akses laluan eksport.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S3-RPT01 | IPJPSM buka halaman pemilihan laporan (`/admin/laporan`) | Senarai tahun & spesies dipaparkan (gabungan data semasa + legasi) |  |  |
| S3-RPT02 | Jana 5 laporan sampel (jadual atas) Shuttle 3 | Rujuk langkah 1–5 di atas untuk setiap satu |  |  |
| S3-RPT03 | Uji laporan dengan nama spesies yang mengandungi aksara khas (cth tanda petik, "/") | Tiada ralat SQL/parameter |  |  |

---

## 9. Kes Ujian — Shuttle 4 (Kilang Papan Lapis/Venir)

> Shuttle 4 mempunyai Borang **A, B, C, D, E**. Kelulusan pendaftaran mencipta 1 `FormA`, 4 `FormB`, 12 `FormC` + 12 `Form4D` + 12 `Form4E` (model khusus Shuttle 4, bukan `FormD`/`FormE` generik).

### 9.1 IBK — Shuttle 4

**Pendaftaran (`/register`)** — sama seperti S3-IBK-REG01–10 (Bahagian 8.1), pilih jenis shuttle 4 semasa pendaftaran.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-REG01 | Isi borang pendaftaran penuh dan sah untuk Shuttle 4, hantar | Rekod `Shuttle`, `PenggunaKilang`, 2× `User` dicipta dengan `is_approved=0`; notifikasi ke semua IPJPSM |  |  |
| S4-IBK-REG02 | Guna nombor SSM yang sama untuk Shuttle 4 dua kali | Ditolak — mesej ralat keunikan |  |  |

*(Kes ujian pengesahan e-mel/IC/lampiran REG03–09 di Bahagian 8.1 terpakai sama rata — tidak diulang di sini.)*

**Sekatan Akaun Pemilik Kilang** — ulang S3-IBK-OWN01–05 (Bahagian 8.1) khusus untuk kilang Shuttle 4.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-OWN01 | Akaun pemilik kilang (No. SSM) log masuk, semak papan pemuka | Kad navigasi Senarai A–E Shuttle 4 dipaparkan **kelabu/pudar dan tidak boleh diklik** |  |  |
| S4-IBK-OWN02 | Akaun peribadi (No. KP) ulang OWN01 | Semua kad/pautan berfungsi normal — tiada sekatan |  |  |

**Pengisian Borang A (Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-A01 | Isi Borang A dan hantar — guna akaun peribadi (No. KP) | Status `Tidak Diisi` → `Sedang Diproses`; `batches.borang_a` → `"1"` |  |  |
| S4-IBK-A02 | Selepas PHD tolak, betulkan dan hantar semula | Status kembali ke `Sedang Diproses` |  |  |
| S4-IBK-A03 | Cuba akses/isi Borang B/C/D/E sebelum Borang A dihantar | **Dihalang** |  |  |

**Pengisian Borang B (Suku Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-B01 | Isi Borang B suku 1 selepas Borang A lulus | Berjaya |  |  |
| S4-IBK-B02 | Cuba isi suku 2 sebelum suku 1 dihantar | Dihalang mengikut urutan |  |  |
| S4-IBK-B03 | PHD tolak Borang B (`Tidak Lengkap`); buka semula borang yang dipulangkan | Jumlah/purata terkira **dipaparkan semula** seperti dihantar asal, bukan kosong (dibaiki 18 Ogos 2026) |  |  |

**Pengisian Borang C (Bulanan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-C01 | Isi Borang C bulan 1, kategori KKB — masukkan data spesies, kuantiti | Data disimpan, jumlah dikira betul |  |  |
| S4-IBK-C02 | Ulang C01 untuk KKS, KKR, Kayu Lembut, Lain-Lain | Semua 5 kategori berfungsi bebas |  |  |
| S4-IBK-C03 | Tandakan "Tiada Pengeluaran" untuk bulan tertentu | Baki stok dibawa ke bulan depan dengan betul |  |  |
| S4-IBK-C04 | Cuba isi bulan 3 sebelum bulan 2 dihantar | Dihalang — mesti berurutan |  |  |
| S4-IBK-C05 | Isi Borang C untuk suku yang Borang B-nya belum dihantar | Dihalang mengikut `FormFlowService` |  |  |

**Pengisian Borang D & E (Bulanan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IBK-D01 | Isi Borang D (`Form4D`) bulan tertentu selepas Borang C bulan sama dihantar | Berjaya |  |  |
| S4-IBK-D02 | Cuba isi Borang D sebelum Borang C bulan sama dihantar | Dihalang |  |  |
| S4-IBK-E01 | Isi Borang E (`Form4E`) selepas Borang D bulan sama diisi | Berjaya |  |  |

**Cetak PDF** — ulang PDF-01–03 (Bahagian 7.5) untuk Borang A, B, C, D, E Shuttle 4.

### 9.2 PHD — Shuttle 4

**Pengesahan Borang A–E**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-PHD-A01 | Semak Borang A, sahkan | Status → `Dihantar ke IPJPSM`; `batches.borang_a` → `"2"` |  |  |
| S4-PHD-A02 | Semak Borang A, tolak dengan ulasan | Status → `Tidak Lengkap`; IBK menerima notifikasi/e-mel dengan ulasan PHD |  |  |
| S4-PHD-B01 | Ulang aliran Sahkan/Tolak untuk Borang B setiap suku | Sama seperti atas |  |  |
| S4-PHD-C01 | Sahkan/Tolak Borang C dengan ulasan | Sama corak seperti Borang A |  |  |
| S4-PHD-C02 | **Kes regresi penting**: betulkan/tolak Borang C bulan lampau selepas bulan kemudian sudah diisi | Bulan kemudian **kekal boleh diakses** |  |  |
| S4-PHD-D01 | Sahkan/Tolak Borang D dan E | Sama corak seperti Borang A |  |  |

**Senarai Tugasan (Status/Ikon Tindakan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-PHD-TASK01 | Lihat senarai tugasan Borang 4B, 4C, 4D, 4E merangkumi borang berstatus `Sedang Diisi` (4C sahaja) dan borang bulan/suku yang telah `Ditutup` | Borang `Sedang Diisi` (4C) memaparkan lencana "Sedang Diisi oleh IBK"; borang `Ditutup` **tidak** disenaraikan pada 4B/4C/4D/4E (dibaiki 18 Ogos 2026) |  |  |

**Pakej Bulanan & "Hantar" Borong**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-PHD-BATCH01 | Lihat senarai pakej bulanan berstatus `Sedang Diproses` untuk daerah ditetapkan | Senarai tepat mengikut `daerah_ids` PHD |  |  |
| S4-PHD-BATCH02 | Klik "Hantar" untuk pakej yang kelima-lima borang (A–E) sudah disahkan | Status pakej → `Dihantar ke IPJPSM` |  |  |
| S4-PHD-BATCH03 | Klik "Hantar" untuk pakej yang belum lengkap | **Ditolak** — mesej menyatakan borang mana yang belum disahkan |  |  |
| S4-PHD-BATCH04 | Cuba akses URL "Hantar" secara terus tanpa klik butang | 405 Method Not Allowed — hanya `POST` diterima |  |  |
| S4-PHD-BATCH05 | Klik "Hantar" untuk pakej bulan **bukan** penghujung suku apabila Borang A/C/D/E sudah disahkan | Berjaya dihantar — Borang B tidak disyaratkan di luar bulan penghujung suku (dibaiki 18 Ogos 2026) |  |  |

**Notifikasi Kilang & Peringatan**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-PHD-NOTIF01 | Lihat senarai kilang Shuttle 4 yang belum mengisi borang | Senarai tepat berdasarkan status dan tarikh buffer |  |  |
| S4-PHD-NOTIF02 | Hantar peringatan kepada satu kilang Shuttle 4 khusus | `BorangTidakDiisiNotification` diterima oleh semua pengguna kilang berkenaan |  |  |
| S4-PHD-NOTIF03 | IBK hantar Borang B, C, atau E — sahkan PHD terima notifikasi loceng dalam-aplikasi (dan e-mel) | Notifikasi diterima (dibaiki 18 Ogos 2026, disahkan untuk Borang 4B, 4C, 4E) |  |  |
| S4-PHD-NOTIF04 | IBK hantar Borang **D** (`Form4D`) — sahkan PHD terima notifikasi | ⚠️ **Belum disahkan/dibaiki setakat 18 Ogos 2026** — pembetulan notifikasi tidak merangkumi laluan Borang 4D secara khusus; laporkan jika notifikasi tidak diterima supaya boleh disemak dan dibaiki |  |  |

**Kelulusan Pendaftaran (laluan alternatif PHD)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-PHD-APP01 | Luluskan permohonan pengguna IBK Shuttle 4 melalui laluan PHD | Sama seperti kelulusan IPJPSM (9.4); **12 `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `Form4D`, 12 `Form4E` dicipta serentak** |  |  |

### 9.3 JPN — Shuttle 4 (Baca Sahaja)

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-JPN01 | Lihat senarai status Borang A–E Shuttle 4 merentasi kilang dalam negeri ditetapkan | Paparan tepat, tiada butang Sahkan/Tolak (baca sahaja) |  |  |
| S4-JPN02 | Cuba akses URL kemas kini status borang secara terus | Ditolak/tiada laluan wujud untuk JPN |  |  |
| S4-JPN03 | Hantar peringatan e-mel kepada kilang Shuttle 4 yang belum mengambil tindakan | E-mel `BorangTidakDiambilTindakanMail` diterima |  |  |
| S4-JPN04 | Lihat notifikasi berkaitan Shuttle 4 | Senarai notifikasi berkaitan negeri ditetapkan dipaparkan |  |  |
| S4-JPN05 | Semak jumlah/kiraan pada kad papan pemuka — Shuttle 4 (butiran A/B/C/D) untuk negeri dengan borang `Sedang Diproses` sedia ada | Kiraan **bukan sifar**, sepadan dengan bilangan sebenar (dibaiki 18 Ogos 2026) |  |  |

### 9.4 IPJPSM (JPSM) — Shuttle 4

**Kelulusan/Penolakan Permohonan Pendaftaran**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IPJPSM-APP01 | Lihat senarai permohonan tertunggak termasuk kilang Shuttle 4 | Senarai memaparkan semua permohonan baharu |  |  |
| S4-IPJPSM-APP02 | Buka lampiran permohonan kilang Shuttle 4 | Semua fail dipaparkan dengan betul |  |  |
| S4-IPJPSM-APP03 | Luluskan permohonan pengguna IBK Shuttle 4 | `is_approved=true`; kata laluan dijana & dihantar; **12 `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `Form4D`, 12 `Form4E` dicipta serentak** |  |  |
| S4-IPJPSM-APP04 | Selepas APP03, sahkan pengguna baharu boleh log masuk | Log masuk berjaya |  |  |
| S4-IPJPSM-APP05 | Selepas APP03, semak Borang A–E kosong (`Tidak Diisi`) wujud untuk Jan–Dis tahun semasa | Rekod lengkap wujud tanpa mengira tarikh pendaftaran |  |  |
| S4-IPJPSM-APP06 | Luluskan permohonan kilang Shuttle 4 secara berasingan daripada permohonan pengguna | Status kilang bertukar aktif berasingan |  |  |
| S4-IPJPSM-APP07 | Tolak/padam permohonan pengguna Shuttle 4 | `User`/`Shuttle` dipadam terus — tiada rekod anak yatim |  |  |
| S4-IPJPSM-APP08 | **Fokus regresi** (18 Ogos 2026): ulang APP03/APP06/S4-PHD-APP01 dengan kombinasi data berbeza | Pengesahan berjaya tanpa ralat 500; ralat e-mel (jika ada) dicatat dalam log sahaja (dibaiki — **keyakinan sederhana**) |  |  |
| S4-IPJPSM-APP09 | Buka borang pengesahan Borang A Shuttle 4 (`ipjpsm.shuttle-3-view-formA`, laluan dikongsi) | Negeri kilang **dipaparkan** (bukan kosong) — ini isu asal yang dilaporkan khusus untuk 4A |  |  |

**Pengurusan Pengguna (Senarai Kilang)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-IPJPSM-PP01 | Buka senarai kilang Shuttle 4 (`ipjpsm.senaraikilang4`) | Lajur **Daerah Hutan** kini dipaparkan (dibaiki 18 Ogos 2026 — sebelum ini lajur ini wujud untuk Shuttle 3 sahaja, tiada langsung pada Shuttle 4) |  |  |
| S4-IPJPSM-PW01 | Klik "Jana Kata Laluan Baharu" pada senarai IBK/Kilang Shuttle 4 (No. KP dan No. SSM) | Kata laluan digantikan; e-mel `PasswordRegeneratedMail` diterima; log masuk berjaya serta-merta |  |  |

**Modul Laporan — Shuttle 4 (Nombor 2xx)**

| Kumpulan Laporan | Contoh Nombor | Apa Diuji |
|---|---|---|
| Senarai kilang | 201 | Data kilang & carian ikut kategori pemilikan |
| Guna tenaga & pendapatan | 211 | Parameter julat suku tahun |
| Penggunaan kayu | 221 | Parameter bulan/tahun/kumpulan kayu |
| Pengeluaran | 231 | Parameter negeri/bulan/tahun/kumpulan kayu/spesies, **termasuk pecahan ketebalan khusus Shuttle 4 (234/235)** |
| Jualan domestik | 241 | Parameter bulan/negeri/pembeli/tahun |

Ikuti langkah persampelan (1)–(5) yang sama seperti Bahagian 8.4.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S4-RPT01 | Jana 5 laporan sampel (jadual atas) Shuttle 4, termasuk 234/235 | Rujuk langkah persampelan |  |  |
| S4-RPT02 | Jana laporan No. 15 — "Jumlah dan purata pendapatan guna tenaga mengikut kategori dan kewarganegeraan di kilang papan" | Setiap baris memaparkan purata pendapatannya **sendiri**, bukan purata terkumpul separa (dibaiki 18 Ogos 2026) |  |  |
| S4-RPT03 | Jana laporan No. 1, bandingkan "Bil. Kilang" dengan bilangan baris dijana | Kedua-duanya sepadan untuk tahun dipilih (dibaiki — pertanyaan sebelum ini tidak ditapis ikut tahun) |  |  |
| S4-RPT04 | Jana laporan No. 2 untuk Borang A berstatus `Dihantar ke IPJPSM` (bukan `Lulus`) | Berjaya dijana, **tiada** mesej ralat "sila sahkan Borang A" (dibaiki — pertanyaan sebelum ini hanya menerima status `Lulus`) |  |  |
| S4-RPT05 | Jana laporan No. 5 dan No. 6 untuk kilang dengan dan tanpa rekod pengeluaran nipis/tebal (No.5) dan muka/teras (No.6) | Kedua-dua laporan dijana tanpa ralat (dibaiki dua pepijat berasingan: penggandaan nilai ~1293× akibat cantuman tanpa syarat, dan ralat "Undefined variable" untuk kilang tanpa rekod tertentu) |  |  |
| S4-RPT06 | Uji laporan dengan nama spesies yang mengandungi aksara khas | Tiada ralat SQL/parameter |  |  |

---

## 10. Kes Ujian — Shuttle 5 (Kilang Kayu Kumai)

> Shuttle 5 mempunyai Borang **A, B, C, D, E**. Kelulusan pendaftaran mencipta 1 `FormA`, 4 `FormB`, 12 `FormC` + 12 `Form5D` + 12 `Form5E` (model khusus Shuttle 5). Borang C Shuttle 5 turut mempunyai lajur "Pengeluaran Kayu Kumai" tambahan berbanding Shuttle 3/4.

### 10.1 IBK — Shuttle 5

**Pendaftaran (`/register`)** — sama seperti S3-IBK-REG01–10 (Bahagian 8.1), pilih jenis shuttle 5.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-REG01 | Isi borang pendaftaran penuh dan sah untuk Shuttle 5, hantar | Rekod `Shuttle`, `PenggunaKilang`, 2× `User` dicipta dengan `is_approved=0`; notifikasi ke semua IPJPSM |  |  |
| S5-IBK-REG02 | Guna nombor SSM yang sama untuk Shuttle 5 dua kali | Ditolak — mesej ralat keunikan |  |  |

**Sekatan Akaun Pemilik Kilang** — ulang S3-IBK-OWN01–05 (Bahagian 8.1) khusus untuk kilang Shuttle 5.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-OWN01 | Akaun pemilik kilang (No. SSM) log masuk, semak papan pemuka | Kad navigasi Senarai A–E Shuttle 5 dipaparkan **kelabu/pudar dan tidak boleh diklik** |  |  |
| S5-IBK-OWN02 | Akaun peribadi (No. KP) ulang OWN01 | Semua kad/pautan berfungsi normal — tiada sekatan |  |  |

**Pengisian Borang A (Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-A01 | Isi Borang A dan hantar — guna akaun peribadi (No. KP) | Status `Tidak Diisi` → `Sedang Diproses` |  |  |
| S5-IBK-A02 | Selepas PHD tolak, betulkan dan hantar semula | Status kembali ke `Sedang Diproses` |  |  |
| S5-IBK-A03 | Cuba akses/isi Borang B/C/D/E sebelum Borang A dihantar | **Dihalang** |  |  |

**Pengisian Borang B (Suku Tahunan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-B01 | Isi Borang B suku 1 selepas Borang A lulus | Berjaya |  |  |
| S5-IBK-B02 | Cuba isi suku 2 sebelum suku 1 dihantar | Dihalang mengikut urutan |  |  |
| S5-IBK-B03 | PHD tolak Borang B; buka semula borang yang dipulangkan | Jumlah/purata terkira **dipaparkan semula** seperti dihantar asal (dibaiki 18 Ogos 2026) |  |  |

**Pengisian Borang C (Bulanan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-C01 | Isi Borang C bulan 1, kategori KKB — masukkan data spesies, kuantiti, **dan Pengeluaran Kayu Kumai** | Data disimpan, jumlah dikira betul termasuk lajur Kayu Kumai |  |  |
| S5-IBK-C02 | Ulang C01 untuk KKS, KKR, Kayu Lembut, Lain-Lain | Semua 5 kategori berfungsi bebas |  |  |
| S5-IBK-C03 | Tandakan "Tiada Pengeluaran" untuk bulan tertentu | Baki stok dibawa ke bulan depan dengan betul |  |  |
| S5-IBK-C04 | Cuba isi bulan 3 sebelum bulan 2 dihantar | Dihalang — mesti berurutan |  |  |

**Pengisian Borang D & E (Bulanan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IBK-D01 | Isi Borang D (`Form5D`) bulan tertentu selepas Borang C bulan sama dihantar — sahkan validasi terhadap medan Borang C yang **betul** | Berjaya (dibaiki sebelum ini — Borang D Shuttle 5 pernah mengesahkan terhadap medan Borang C yang salah) |  |  |
| S5-IBK-E01 | Isi Borang E (`Form5E`) selepas Borang D bulan sama diisi | Berjaya |  |  |

**Cetak PDF** — ulang PDF-01–03 (Bahagian 7.5) untuk Borang A, B, C, D, E Shuttle 5.

### 10.2 PHD — Shuttle 5

**Pengesahan Borang A–E**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-PHD-A01 | Semak Borang A, sahkan | Status → `Dihantar ke IPJPSM` |  |  |
| S5-PHD-A02 | Semak Borang A, tolak dengan ulasan | Status → `Tidak Lengkap`; IBK menerima notifikasi/e-mel |  |  |
| S5-PHD-B01 | Ulang aliran Sahkan/Tolak untuk Borang B setiap suku | Sama seperti atas |  |  |
| S5-PHD-C01 | Sahkan/Tolak Borang C dengan ulasan | Sama corak seperti Borang A |  |  |
| S5-PHD-D01 | Sahkan/Tolak Borang D dan E | Sama corak seperti Borang A |  |  |

**Senarai Tugasan (Status/Ikon Tindakan)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-PHD-TASK01 | Lihat senarai tugasan Borang 5B dan 5C merangkumi borang berstatus `Sedang Diisi` (5C sahaja) dan borang yang telah `Ditutup` | Borang `Sedang Diisi` memaparkan lencana "Sedang Diisi oleh IBK"; borang `Ditutup` **tidak** disenaraikan pada 5B/5C (dibaiki 18 Ogos 2026) |  |  |
| S5-PHD-TASK02 | Lihat senarai tugasan Borang 5D dan 5E merangkumi borang `Ditutup` | ⚠️ **Belum disahkan/dibaiki setakat 18 Ogos 2026** — laporkan jika lajur status/ikon kosong turut berlaku pada 5D/5E |  |  |

**Pakej Bulanan & "Hantar" Borong**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-PHD-BATCH01 | Lihat senarai pakej bulanan berstatus `Sedang Diproses` untuk daerah ditetapkan | Senarai tepat mengikut `daerah_ids` PHD |  |  |
| S5-PHD-BATCH02 | Klik "Hantar" untuk pakej yang kelima-lima borang (A–E) sudah disahkan | Status pakej → `Dihantar ke IPJPSM` |  |  |
| S5-PHD-BATCH03 | Klik "Hantar" untuk pakej yang belum lengkap | **Ditolak** — mesej menyatakan borang mana yang belum disahkan |  |  |
| S5-PHD-BATCH04 | Cuba akses URL "Hantar" secara terus tanpa klik butang | 405 Method Not Allowed |  |  |
| S5-PHD-BATCH05 | Klik "Hantar" untuk pakej bulan **bukan** penghujung suku apabila Borang A/C/D/E sudah disahkan | Berjaya dihantar — Borang B tidak disyaratkan di luar bulan penghujung suku (dibaiki 18 Ogos 2026) |  |  |

**Notifikasi Kilang & Peringatan**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-PHD-NOTIF01 | Lihat senarai kilang Shuttle 5 yang belum mengisi borang | Senarai tepat berdasarkan status dan tarikh buffer |  |  |
| S5-PHD-NOTIF02 | Hantar peringatan kepada satu kilang Shuttle 5 khusus | `BorangTidakDiisiNotification` diterima oleh semua pengguna kilang berkenaan |  |  |
| S5-PHD-NOTIF03 | IBK hantar Borang B, C, D, atau E — sahkan PHD terima notifikasi loceng dalam-aplikasi (dan e-mel) | Notifikasi diterima untuk **setiap** borang (dibaiki 18 Ogos 2026 — Shuttle 5 mempunyai liputan pembaikan paling lengkap: B, C, D, dan E kesemuanya disahkan) |  |  |

**Kelulusan Pendaftaran (laluan alternatif PHD)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-PHD-APP01 | Luluskan permohonan pengguna IBK Shuttle 5 melalui laluan PHD | Sama seperti kelulusan IPJPSM (10.4); **12 `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `Form5D`, 12 `Form5E` dicipta serentak** |  |  |

### 10.3 JPN — Shuttle 5 (Baca Sahaja)

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-JPN01 | Lihat senarai status Borang A–E Shuttle 5 merentasi kilang dalam negeri ditetapkan | Paparan tepat, tiada butang Sahkan/Tolak (baca sahaja) |  |  |
| S5-JPN02 | Cuba akses URL kemas kini status borang secara terus | Ditolak/tiada laluan wujud untuk JPN |  |  |
| S5-JPN03 | Hantar peringatan e-mel kepada kilang Shuttle 5 yang belum mengambil tindakan | E-mel `BorangTidakDiambilTindakanMail` diterima |  |  |
| S5-JPN04 | Lihat notifikasi berkaitan Shuttle 5 | Senarai notifikasi berkaitan negeri ditetapkan dipaparkan |  |  |
| S5-JPN05 | Semak jumlah/kiraan pada kad papan pemuka — Shuttle 5 (butiran A/B/C/D) untuk negeri dengan borang `Sedang Diproses` sedia ada | Kiraan **bukan sifar**, sepadan dengan bilangan sebenar (dibaiki 18 Ogos 2026) |  |  |

### 10.4 IPJPSM (JPSM) — Shuttle 5

**Kelulusan/Penolakan Permohonan Pendaftaran**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IPJPSM-APP01 | Lihat senarai permohonan tertunggak termasuk kilang Shuttle 5 | Senarai memaparkan semua permohonan baharu |  |  |
| S5-IPJPSM-APP02 | Buka lampiran permohonan kilang Shuttle 5 | Semua fail dipaparkan dengan betul |  |  |
| S5-IPJPSM-APP03 | Luluskan permohonan pengguna IBK Shuttle 5 | `is_approved=true`; kata laluan dijana & dihantar; **12 `Batch`, 1 `FormA`, 4 `FormB`, 12 `FormC`, 12 `Form5D`, 12 `Form5E` dicipta serentak** |  |  |
| S5-IPJPSM-APP04 | Selepas APP03, sahkan pengguna baharu boleh log masuk | Log masuk berjaya |  |  |
| S5-IPJPSM-APP05 | Selepas APP03, semak Borang A–E kosong (`Tidak Diisi`) wujud untuk Jan–Dis tahun semasa | Rekod lengkap wujud tanpa mengira tarikh pendaftaran |  |  |
| S5-IPJPSM-APP06 | Luluskan permohonan kilang Shuttle 5 secara berasingan daripada permohonan pengguna | Status kilang bertukar aktif berasingan |  |  |
| S5-IPJPSM-APP07 | Tolak/padam permohonan pengguna Shuttle 5 | `User`/`Shuttle` dipadam terus — tiada rekod anak yatim |  |  |
| S5-IPJPSM-APP08 | **Fokus regresi** (18 Ogos 2026): ulang APP03/APP06/S5-PHD-APP01 dengan kombinasi data berbeza | Pengesahan berjaya tanpa ralat 500; ralat e-mel (jika ada) dicatat dalam log sahaja (dibaiki — **keyakinan sederhana**) |  |  |
| S5-IPJPSM-APP09 | Buka borang pengesahan Borang A Shuttle 5 (`ipjpsm.shuttle-3-view-formA`, laluan dikongsi) | Negeri kilang **dipaparkan** (bukan kosong) — ini isu asal yang dilaporkan khusus untuk 5A |  |  |

**Pengurusan Pengguna (Senarai Kilang)**

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-IPJPSM-PP01 | Buka senarai kilang Shuttle 5 (`ipjpsm.senaraikilang5`) | Lajur **Daerah Hutan** kini dipaparkan (dibaiki 18 Ogos 2026) |  |  |
| S5-IPJPSM-PW01 | Klik "Jana Kata Laluan Baharu" pada senarai IBK/Kilang Shuttle 5 (No. KP dan No. SSM) | Kata laluan digantikan; e-mel `PasswordRegeneratedMail` diterima; log masuk berjaya serta-merta |  |  |

**Modul Laporan — Shuttle 5 (Nombor 3xx)**

| Kumpulan Laporan | Contoh Nombor | Apa Diuji |
|---|---|---|
| Senarai kilang | 301 | Data kilang & carian ikut kategori pemilikan |
| Guna tenaga & pendapatan | 311 | Parameter julat suku tahun |
| Penggunaan kayu | 321 | Parameter bulan/tahun/kumpulan kayu |
| Pengeluaran | 331 | Parameter negeri/bulan/tahun/kumpulan kayu/spesies |
| Jualan domestik | 341 | Parameter bulan/negeri/pembeli/tahun |

Ikuti langkah persampelan (1)–(5) yang sama seperti Bahagian 8.4.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| S5-RPT01 | Jana 5 laporan sampel (jadual atas) Shuttle 5 | Rujuk langkah persampelan |  |  |
| S5-RPT02 | Jana laporan No. 15 — "Jumlah dan purata pendapatan guna tenaga..." | Setiap baris memaparkan purata pendapatannya **sendiri** (dibaiki 18 Ogos 2026) |  |  |
| S5-RPT03 | Jana laporan No. 1, bandingkan "Bil. Kilang" dengan bilangan baris dijana | Kedua-duanya sepadan untuk tahun dipilih (dibaiki) |  |  |
| S5-RPT04 | Jana laporan No. 2 untuk Borang A berstatus `Dihantar ke IPJPSM` (bukan `Lulus`) | Berjaya dijana, tiada mesej ralat palsu (dibaiki) |  |  |
| S5-RPT05 | Jana laporan No. 3 (Kilang Kayu Kumai) untuk kilang dengan Borang A diluluskan pada **lebih daripada satu tahun** | Poskod dan daerah **tidak berganda** — setiap kilang muncul sekali sahaja (dibaiki 18 Ogos 2026 — pertanyaan sebelum ini tiada tapisan tahun/warganegara, mengembalikan satu baris bagi setiap tahun Borang A diluluskan) |  |  |
| S5-RPT06 | No. 22: Penggunaan kayu balak mengikut negeri bagi siri masa 2023–2024 | Jadual lengkap dengan jumlah besar dipaparkan |  |  |
| S5-RPT07 | Uji laporan dengan nama spesies yang mengandungi aksara khas | Tiada ralat SQL/parameter |  |  |

---

## 11. Ujian Integrasi

| ID | Integrasi | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| INT-01 | E-mel (SMTP) | Cetuskan setiap jenis e-mel sistem (kelulusan, tolak borang, reset kata laluan, peringatan JPN/PHD, pendaftaran) dan sahkan **diterima sebenar** dalam peti masuk ujian | Semua e-mel diterima dengan kandungan/pautan betul (bukan hanya "tiada ralat dihantar") |  |  |
| INT-02 | E-mel — kes gagal senyap | Kosongkan `MAIL_FROM_ADDRESS`, cuba cetuskan e-mel kelulusan pengguna | **Sahkan** e-mel tidak dihantar tetapi tiada ralat dipaparkan kepada pengguna; pulihkan nilai selepas ujian |  |  |
| INT-03 | Storan Fail | Muat naik dokumen semasa pendaftaran, sahkan boleh dipaparkan semula selepas `php artisan storage:link` dijalankan | Fail boleh diakses melalui `public/storage/...` |  |  |
| INT-04 | Eksport Excel | Jana pelbagai laporan (rujuk Bahagian 8.4/9.4/10.4), buka fail dalam Excel/LibreOffice | Fail tidak rosak, format nombor/tarikh betul, tiada sel terpotong |  |  |
| INT-05 | Eksport PDF (Borang) | Cetak Borang A–E yang lulus | PDF dijana, boleh dibuka, kandungan lengkap |  |  |
| INT-06 | Eksport PDF (Laporan) | Jana laporan format PDF | Sahkan eksport berfungsi |  |  |
| INT-07 | DB Legasi (`mysql2`) | Jana laporan bagi tahun sebelum 2021 | Data legasi dipaparkan betul, sambungan `mysql2` stabil (rujuk 3.2) |  |  |
| INT-08 | AWS S3 | Sahkan **tiada** fungsi bergantung kepada S3 (semua muat naik guna storan tempatan) | Konfigurasi S3 boleh dibiar kosong tanpa kesan fungsi semasa |  |  |
| INT-09 | Pusher/Masa Nyata | Sahkan **tiada** ciri masa nyata aktif dalam antara muka pengguna | Tiada isu jika `PUSHER_APP_*` dibiar kosong |  |  |

---

## 12. Pengendalian Ralat & Kes Sempadan

| ID | Kategori | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|
| ERR-01 | Ralat umum | Cetuskan ralat tanpa dijangka (cth hantar data borang rosak melalui alat pembangun pelayar) pada persekitaran dengan `APP_DEBUG=false` | Halaman ralat generik dipaparkan — **bukan** surih kod/laluan pelayan |  |  |
| ERR-02 | Ralat umum | Ulang ERR-01 dengan `APP_DEBUG=true` (hanya di persekitaran ujian tertutup) | Sahkan surih terperinci dipaparkan — mengesahkan `APP_DEBUG` mesti sentiasa `false` di pengeluaran |  |  |
| ERR-03 | Laluan tidak wujud | Akses URL rawak yang tidak wujud | Halaman 404 lalai Laravel (tiada halaman ralat tersuai — ini normal, bukan pepijat) |  |  |
| ERR-04 | Kebenaran | Pengguna log masuk cuba akses laluan peranan lain secara terus (cth IBK taip URL laluan IPJPSM) | Dialihkan semula ke halaman utama peranan sendiri |  |  |
| ERR-05 | Sesi tamat | Biarkan sesi tamat (>120 minit tanpa aktiviti), cuba hantar borang | Dialihkan ke log masuk, data borang tidak hilang secara senyap (amaran/simpan draf jika ada) |  |  |
| ERR-06 | Input tidak sah | Masukkan aksara HTML/skrip (cth tag `<script>`) dalam medan teks bebas (cth ulasan PHD, nama syarikat) | Data disimpan sebagai teks biasa, **tidak dilaksanakan** apabila dipaparkan semula (semak XSS) |  |  |
| ERR-07 | Muat naik fail | Muat naik fail bukan-imej (cth `.exe`, `.php`) pada medan gambar IC/sijil | Ditolak dengan mesej jenis fail tidak sah |  |  |
| ERR-08 | Muat naik fail | Muat naik fail bersaiz melebihi had `upload_max_filesize`/`post_max_size` PHP | Ditolak dengan mesej sesuai, bukan ralat pelayan 500 |  |  |
| ERR-09 | Konkurensi | Dua pengguna PHD cuba "Sahkan" borang yang sama serentak (buka 2 tab) | Tiada duplikasi/kerosakan data — status akhir konsisten |  |  |
| ERR-10 | Nilai angka | Masukkan nilai negatif/perpuluhan melampau pada medan kuantiti kayu (Borang C) | Ditolak/disekat pengesahan input |  |  |

---

## 13. Ujian Keselamatan Asas (Sebahagian FAT — Bukan Pentest Penuh)

> Item berikut adalah pengesahan keselamatan asas am bagi sistem. Untuk penilaian keselamatan menyeluruh (contoh sebelum sistem didedahkan kepada awam/production sebenar), cadangkan ujian penembusan formal berasingan daripada skop UAT/FAT ini.

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| SEC-01 | Log keluar sepenuhnya, cuba akses terus setiap URL pentadbiran berikut: `/admin/pengurusan-pengguna`, `/admin/senarai-phd`, `/admin/hak-milik-syarikat`, `/admin/daerah`, `/admin/status-permohonan-bpe`, `/admin/lampiran-permohonan/{id}`, dsb. | **Wajib dilaporkan sebagai isu kritikal jika boleh dicapai** tanpa log masuk |  |  |
| SEC-02 | Log masuk sebagai IBK, ulang SEC-01 | Sahkan sekatan peranan (jika laluan boleh dicapai tanpa `auth`, ia mungkin juga tidak menyekat mengikut peranan) |  |  |
| SEC-03 | Cuba akses fail permohonan pengguna lain dengan menukar `{id}` pada URL lampiran secara manual (cth `/admin/lampiran-permohonan/5` → `/6`) | Sahkan sama ada kawalan akses berasaskan peranan mencukupi (IDOR check) |  |  |
| SEC-04 | Sahkan `APP_DEBUG=false` pada `.env` persekitaran staging/pengeluaran sebelum FAT selesai | Wajib — amalan keselamatan standard |  |  |
| SEC-05 | Sahkan `LICENSE_SECRET` dan `CONTROL_PANEL_TOKEN` ditetapkan kepada nilai rawak unik (bukan kosong, bukan nilai contoh) | Wajib |  |  |
| SEC-06 | Cuba CSRF pada tindakan "Hantar" PHD — hantar permintaan `GET` terus tanpa melalui butang dalam aplikasi | Mesti **gagal** (405) — laluan hanya menerima `POST` dan dilindungi CSRF standard Laravel |  |  |
| SEC-07 | Sahkan kata laluan lalai akaun terbenih (`1234567890`, rujuk 5.1) **ditukar atau akaun tersebut dilumpuhkan** sebelum sistem dianggap sedia untuk pengeluaran sebenar | Wajib sebelum go-live |  |  |

---

## 14. Ujian Prestasi Asas

> Pelayan pengeluaran sistem ini adalah spesifikasi rendah/perkongsian. Ujian prestasi penuh (load testing) di luar skop, tetapi sahkan asas berikut:

| ID | Langkah | Hasil Dijangka | Keputusan (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|
| PERF-01 | Muatkan papan pemuka IPJPSM (`borangKeseluruhan`) dengan bilangan kilang/rekod sebenar (bukan data ujian minimum) | Masa muat munasabah (<5 saat pada rangkaian normal), tiada ralat kehabisan memori (OOM) |  |  |
| PERF-02 | Jana laporan Excel dengan julat data besar (cth seluruh tahun, semua negeri) | Selesai tanpa ralat had masa (timeout)/memori |  |  |
| PERF-03 | Log masuk serentak beberapa pengguna (simulasi 5–10 pengguna) semasa waktu puncak dijangka | Tiada kelambatan/ralat kunci pangkalan data (deadlock) |  |  |

---

## 15. Kriteria Penerimaan

### 15.1 Definisi Keterukan (Severity)
| Tahap | Definisi | Contoh |
|---|---|---|
| **Kritikal** | Menghalang penggunaan sistem/kehilangan data/pendedahan data sensitif | Capaian tanpa log masuk kepada fungsi pentadbir, kehilangan data borang |
| **Major** | Fungsi teras tidak berfungsi mengikut keperluan tetapi ada jalan pintas | Pakej borang tidak lengkap masih diterima, laporan salah kira |
| **Minor** | Kesan terhad, tidak menghalang kerja | Isu paparan/UI kecil, mesej ralat kurang jelas |
| **Cadangan** | Penambahbaikan, bukan pepijat | Penambahbaikan pengesahan input, ciri UI tambahan |

### 15.2 Kriteria Lulus UAT/FAT
- **Sifar** isu Kritikal terbuka.
- Semua isu Major mempunyai pelan pembetulan bertarikh dipersetujui, atau diterima secara rasmi oleh pemilik sistem sebagai risiko yang boleh diterima.
- Semua kes ujian dalam Bahagian 7–14 telah dijalankan dan keputusan direkodkan (Lulus/Gagal/Tidak Berkenaan).
- Semua item dalam Senarai Semak Pra-UAT (Bahagian 18) disahkan selesai.
- Pemilik sistem (IPJPSM/EKBK) memberi tandatangan/kelulusan bertulis.

---

## 16. Kilas Balik Isu Terdahulu (Rujukan Sejarah)

> Bahagian ini merekodkan isu-isu yang telah dilaporkan oleh EKBK (senarai "Isu Sistem eShuttle Mengikut Paparan") dan sudah dibaiki, disusun mengikut Shuttle/peranan untuk rujukan silang pantas ke ID kes ujian yang berkaitan. Guna ID di lajur kanan untuk terus ke kes ujian penuh.

| Peranan/Paparan | Isu Asal | ID Kes Ujian Berkaitan |
|---|---|---|
| IBK | Borang yang return tidak dapat dikemaskini oleh IBK (Shuttle 5, Borang B) | S3/S4/S5-IBK-B04/B03 |
| PHD | Pakej tidak dapat dihantar ke JPN & IPJPSM (bulan bukan penghujung suku) | S3/S4/S5-PHD-BATCH05 |
| PHD | Tiada naik notification bagi Borang 3C untuk tindakan PHD dan perubahan ikon | S3-PHD-NOTIF03 |
| PHD | Tiada icon tindakan/status tindakan pada senarai tugasan (3B/3C/4B/4C/4D/4E/5B/5C) | S3/S4/S5-PHD-TASK01 |
| JPN | Tiada jumlah pada senarai borang yang belum disahkan PHD | S3/S4/S5-JPN05 |
| IPJPSM | Tiada daerah pada S4 & S5 pada paparan pengurusan pengguna | S4-IPJPSM-PP01, S5-IPJPSM-PP01 |
| IPJPSM | Tiada tertera negeri dalam Borang A semasa buat pengesahan (4A/5A) | S4-IPJPSM-APP09, S5-IPJPSM-APP09 |
| IPJPSM | Error setelah buat pengesahan pendaftaran | S3/S4/S5-IPJPSM-APP08 |
| Laporan | No.15 — Jumlah/purata pendapatan guna tenaga di kilang papan | S4-RPT02, S5-RPT02 |
| Laporan | No.1 — Bil. kilang tidak sama dengan janaan laporan | S4-RPT03, S5-RPT03 |
| Laporan | No.2 — Ralat minta sahkan Borang A sedangkan sudah sahkan | S4-RPT04, S5-RPT04 |
| Laporan | No.5 & 6 — Error ketika janaan laporan (Shuttle 4) | S4-RPT05 |
| Laporan | Shuttle 5 No.3 — Gandaan poskod dan daerah (Kilang Kayu Kumai) | S5-RPT05 |

---

## 17. Templat Log Isu (Bug Report)

| Medan | Penerangan |
|---|---|
| ID Isu | Nombor rujukan unik (cth `BUG-001`) |
| Rujukan Kes Ujian | ID daripada Bahagian 7–14 (cth `S3-PHD-C02`) |
| Peranan Diuji | IBK/PHD/JPN/IPJPSM/BPM |
| Shuttle Berkaitan | 3/4/5/Tidak Berkenaan |
| Langkah Ulang Semula (Steps to Reproduce) | Senarai langkah tepat |
| Hasil Dijangka | — |
| Hasil Sebenar | — |
| Keterukan | Kritikal/Major/Minor/Cadangan (rujuk 15.1) |
| Tangkapan Skrin/Log | Lampirkan jika ada |
| Status | Baharu/Sedang Dibaiki/Selesai/Ditutup/Diterima Sebagai Risiko |
| Tarikh Dilaporkan / Oleh | — |
| Tarikh Diselesaikan / Oleh | — |

---

## 18. Senarai Semak Sebelum UAT Bermula

- [ ] Kesediaan pelayan live disahkan mengikut Bahagian 3.3 (kod terkini digunakan, migrasi dijalankan, `storage:link` wujud)
- [ ] Semua nilai `.env` dalam Bahagian 4 diisi (terutama `MAIL_FROM_ADDRESS`, `LICENSE_SECRET`, `CONTROL_PANEL_TOKEN`)
- [ ] `APP_DEBUG=false` disahkan pada persekitaran yang akan digunakan untuk FAT rasmi
- [ ] `php artisan db:seed` dijalankan, data rujukan (Bahagian 6) disahkan lengkap
- [ ] Akaun ujian (Bahagian 5) sedia — sekurang-kurangnya 1 IBK bagi setiap jenis shuttle telah melalui aliran pendaftaran + kelulusan penuh
- [ ] Ciri baharu "Sekatan Akaun Pemilik Kilang" disahkan berfungsi untuk Shuttle 3, 4, **dan** 5 (rujuk 8.1/9.1/10.1); pastikan pasukan pengujian ada akses kepada **kedua-dua** akaun (pemilik kilang No. SSM dan peribadi No. KP) bagi sekurang-kurangnya satu kilang ujian setiap Shuttle
- [ ] Peti masuk e-mel ujian disediakan untuk mengesahkan penghantaran e-mel sebenar
- [ ] Pasukan pengujian dilantik bagi setiap peranan (IBK, PHD, JPN, IPJPSM, BPM) — idealnya pengguna sebenar/wakil sebenar setiap peranan
- [ ] Salinan dokumen ini (atau versi Artifact yang boleh dikongsi) diedarkan kepada semua pasukan pengujian

---

## Lampiran A: Arahan Artisan Sokongan — Amaran Sebelum Digunakan

Semua arahan berikut **dijalankan secara manual** (tiada penjadualan automatik — `app/Console/Kernel.php::schedule()` kosong). Arahan `formc:*` dan `daerah:*` mengikut konvensyen **dry-run lalai, `--apply` untuk tulis** — sentiasa jalankan tanpa `--apply` dahulu dan semak output sebelum menulis ke pangkalan data.

| Arahan | Tujuan | Amaran |
|---|---|---|
| `email:check-duplicates` | Diagnostik — imbas e-mel pendua merentasi jadual | Selamat, hanya baca |
| `formc:fix-group-totals [--apply] [--shuttle-id=] [--formc-id=] [--year=]` | Baiki jumlah kumpulan kayu Borang C yang tersilap kira akibat pepijat lama | **Jangan** jalankan `--apply` pada data ujian yang sengaja dicipta untuk uji pepijat ini — ia akan "membetulkan" data ujian anda |
| `daerah:fix-pulau-pinang [--apply]` | Betulkan ejaan "Seberang Prai" → "Seberang Perai" | Khusus data pengeluaran sedia ada; tidak relevan pada data ujian baharu |
| `license:key` / `license:lock` / `license:unlock` / `license:status` | Rujuk Bahagian 11 | Uji di staging sahaja |
| `formc:reopen-shuttle5 [--year=] [--apply]` | Buka semula Borang C Shuttle 5 yang sudah diisi untuk pembetulan lajur "Pengeluaran Kayu Kumai" yang hilang akibat pepijat lama | Khusus data pengeluaran sedia ada — mencetuskan notifikasi/mesej sebenar kepada kilang seolah-olah PHD menolak borang |
| `formc:repair-tiada-pengeluaran [--apply]` | Betulkan baki stok "Tiada Pengeluaran" yang tersilap ditetapkan 0 | Sama seperti atas — khusus data sedia ada |

---

## Lampiran B: Rujukan Silang dengan Skop Kerja Kontrak

Jadual berikut memetakan kategori kerja dalam `SKOP_KERJA_ESHUTTLE.md` (Mei–Julai 2026) kepada bahagian pelan UAT/FAT ini, bagi memudahkan EKBK mengesahkan setiap item kerja yang dilaporkan "Selesai" benar-benar berfungsi semasa UAT:

| Kategori Skop Kerja | Bahagian UAT/FAT Berkaitan |
|---|---|
| (a) Pembaikan Ralat Sistem | Bahagian 8–10 (aliran borang mengikut Shuttle), 12 (ralat & kes sempadan) |
| (b) Notifikasi Sistem | Bahagian 8.2/9.2/10.2 (notifikasi kilang mengikut Shuttle), 11 (integrasi e-mel — INT-01/02) |
| (c) Dokumentasi Sistem | Dokumen ini + `DEPLOY_ARTISAN_STEPS.md` sedia ada |
| (d) Database Tuning | Bahagian 14 (prestasi asas) |
| (e) Penambahbaikan Dashboard | Bahagian 7.4 (papan pemuka) |
| (f) Loading Performance / FormFlowService | Bahagian 8–10 (peraturan urutan borang mengikut Shuttle), khususnya kes regresi PHD-C02 setiap Shuttle |

---

## Kelulusan

| Peranan | Nama | Tandatangan | Tarikh |
|---|---|---|---|
| Disediakan oleh (Pembangun) | Muhammad Faiz Abdullah | | |
| Disemak oleh (Wakil Teknikal EKBK) | | | |
| Diluluskan oleh (Pemilik Sistem/IPJPSM) | | | |
