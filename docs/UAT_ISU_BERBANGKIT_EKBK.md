# Pelan Pengesahan Isu Yang Dilaporkan (UAT Isu Berbangkit)
## Sistem eShuttle — EKBK (Artanis-ekbk)

| | |
|---|---|
| **Sistem** | Sistem Pelaporan Industri Perkilangan Kayu (eShuttle) — EKBK |
| **Jenis Dokumen** | Pengesahan Pembaikan bagi Isu Yang Telah Dilaporkan oleh EKBK |
| **Disediakan oleh** | Muhammad Faiz Abdullah (Pembangun/Kontraktor) |
| **Tarikh** | 28 Ogos 2026 |
| **Versi** | 1.0 |
| **Sumber Rujukan** | "Senarai Isu Berbangkit Berkenaan Sistem eShuttle Yang Masih Dalam Tindakan" (19 isu) dan "Isu Sistem eShuttle Mengikut Paparan" (isu dikategorikan ikut IBK/PHD/JPN/IPJPSM) — kedua-dua senarai yang dikongsi oleh EKBK |

> **Tujuan dokumen ini**: Dokumen ini **bukan** UAT/FAT penuh sistem (rujuk `UAT_FAT_PELAN_PENGUJIAN.md` untuk pelan pengujian menyeluruh). Skopnya **terhad** kepada isu-isu spesifik yang telah dilaporkan oleh pihak EKBK melalui dua senarai isu di atas — bertujuan membolehkan pihak EKBK mengesahkan **satu persatu** sama ada setiap isu yang dilaporkan telah benar-benar diselesaikan, tanpa perlu menjalankan pengujian menyeluruh ke atas keseluruhan sistem.
>
> **Cara guna**: Dua senarai asal EKBK mengandungi beberapa isu yang sama/bertindih (dilaporkan lebih daripada sekali dalam bentuk berbeza). Isu tersebut telah **digabungkan menjadi satu** kes pengesahan sahaja di bawah, dengan lajur **"Rujukan Asal"** menunjukkan nombor Bil. dalam senarai asal EKBK bagi tujuan rujukan silang. Lajur **"Status Pembaikan"** adalah anggaran awal pembangun berdasarkan kerja yang telah dilaksanakan setakat tarikh dokumen ini — ia **bukan** pengesahan muktamad; lajur **"Keputusan UAT"** perlu diisi oleh pihak EKBK selepas menjalankan langkah pengesahan sendiri.

---

## Legenda Status Pembaikan

| Status | Maksud |
|---|---|
| ✅ Telah dibaiki | Pembetulan kod telah dilaksanakan; menunggu pengesahan EKBK |
| 🟡 Pembetulan data/pentadbiran | Bukan isu kod — melibatkan pembetulan rekod/tindakan pentadbiran sahaja |
| 🆕 Ciri baharu | Permintaan penambahan ciri, bukan pembaikan pepijat |
| ⚪ Belum disahkan | Status pembaikan belum disahkan sepenuhnya setakat tarikh dokumen ini — perlu disemak semasa UAT |

---

## A. Paparan IBK

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-IBK-01 | Borang yang dipulangkan (return) semula kepada IBK tidak berubah status/icon dan tidak dapat dikemaskini — dilaporkan khusus pada Borang 5B | Senarai Isu Berbangkit #2; Isu by Paparan (IBK) #1 | Log masuk sebagai IBK, hantar Borang B (mana-mana Shuttle), minta PHD tolak (Tidak Lengkap) dengan ulasan, semak semula sebagai IBK | Icon/status borang bertukar menandakan borang perlu dikemaskini; IBK boleh buka dan kemas kini semula borang tersebut; nilai/jumlah asal masih dipaparkan (bukan kosong) | ✅ Telah dibaiki | | |
| ISU-IBK-02 | Jumlah bagi setiap Jenis Kumpulan Kayu (cth: KKB) tidak tepat | Isu by Paparan (IBK) #2 | Isi Borang C, kategori KKB, dengan beberapa spesies; semak jumlah kumpulan dipaparkan/dijana | Jumlah kumpulan kayu tepat mengikut data spesies yang dimasukkan | ✅ Telah dibaiki | | |
| ISU-IBK-03 | Paparan No. SSM tersalah pada peranan tertentu — Shuttle 3 | Isu by Paparan (IBK) #3 | Log masuk sebagai IBK Shuttle 3, semak paparan No. SSM pada borang/senarai berkaitan | No. SSM yang dipaparkan tepat mengikut rekod pendaftaran kilang | ⚪ Belum disahkan | | |
| ISU-IBK-04 | Buang pilihan tahun 1989 (tidak relevan); betulkan paparan/format e-mel | Isu by Paparan (IBK/PHD/JPN/IPJPSM) #4 (dilaporkan berulang di semua paparan) | Semak dropdown tahun kelahiran/tahun berkaitan pada borang pendaftaran/profil; semak paparan medan e-mel pada semua peranan | Tahun 1989 tidak lagi tersenarai (jika tidak relevan mengikut had umur); medan e-mel dipaparkan/disahkan dengan format betul | ⚪ Belum disahkan | | |
| ISU-IBK-05 | Jumlah Besar kosong walaupun ada data pada KKB & KKS; icon bertukar "Tiada Pengeluaran" secara tidak tepat (lajur 03, 04, 05, 06, 07) | Isu by Paparan (IBK) #5 (30/7) | Isi Borang C dengan data pada kumpulan KKB dan KKS sahaja (kumpulan lain kosong), hantar, semak Jumlah Besar dan icon status | Jumlah Besar terisi betul mengikut data sebenar; icon status mencerminkan keadaan sebenar (bukan "Tiada Pengeluaran" jika ada pemprosesan) | ✅ Telah dibaiki | | |
| ISU-IBK-06 | Tiada data dibawa masuk ke Borang 4D sedangkan ada jumlah pada Borang 4C | Isu by Paparan (IBK) #6 (28/7) | Isi dan hantar Borang 4C dengan jumlah pengeluaran, buka Borang 4D bulan sama | Data/jumlah daripada Borang 4C dipaparkan dengan betul dalam Borang 4D | ⚪ Belum disahkan | | |
| ISU-IBK-07 | Wujud data bagi spesies yang tidak dikunci masuk oleh IBK | Isu by Paparan (IBK) #7 (28/7) | Isi Borang C tanpa mengunci masuk data bagi sesetengah spesies, hantar, semak rekod tersimpan | Tiada data/rekod dicipta bagi spesies yang tidak dikunci masuk oleh pengguna | ⚪ Belum disahkan | | |
| ISU-IBK-08 | Data spesies yang telah dikunci masuk berganjak naik ke baris spesies sebelumnya selepas borang dihantar | Isu by Paparan (IBK) #8 (28/7) | Isi Borang C bagi beberapa spesies berturutan dalam satu kumpulan kayu, hantar, semak semula paparan borang | Data setiap spesies kekal pada baris/spesies yang betul selepas penghantaran | ⚪ Belum disahkan | | |
| ISU-IBK-09 | Icon/status borang tidak berubah (kekal "borang belum diisi") walaupun sudah klik "Tiada Pengeluaran"/"Hantar" | Isu by Paparan (IBK) #9 (28/7) | Tandakan "Tiada Pengeluaran" atau hantar Borang C, semak status/icon pada senarai borang IBK | Status/icon bertukar mengikut tindakan yang diambil (bukan kekal "belum diisi") | ✅ Telah dibaiki | | |
| ISU-IBK-10 | Kesilapan nama daerah Pulau Pinang — sepatutnya "Seberang Perai Selatan" | Isu by Paparan (IBK/PHD/JPN/IPJPSM) #10 (28/7, dilaporkan berulang di semua paparan) | Semak senarai/dropdown daerah bagi negeri Pulau Pinang pada borang pendaftaran dan semua paparan peranan | Nama daerah dipaparkan sebagai "Seberang Perai Selatan" (bukan "Seberang Prai") di semua paparan | ✅ Telah dibaiki | | |
| ISU-IBK-11 | Paparan Borang 5C tertukar dengan Borang 4C — kandungan borang yang telah dikunci masuk kekal sama | Isu by Paparan (IBK) #11 (28/7) | Log masuk sebagai IBK Shuttle 5, buka Borang 5C, bandingkan dengan Borang 4C Shuttle 4 | Borang 5C memaparkan templat/medan khusus Shuttle 5 (Kilang Kayu Kumai), bukan templat Shuttle 4 | ✅ Telah dibaiki | | |
| ISU-IBK-12 | Laporan A–E (pada paparan IBK) tidak dapat dijana/dicetak | Isu by Paparan (IBK) #12 (28/7) | Selepas Borang A–E lengkap disahkan, cuba cetak/jana PDF setiap borang sebagai IBK | PDF borang berjaya dijana dengan data lengkap | ⚪ Belum disahkan | | |

---

## B. Paparan PHD

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-PHD-01 | Pakej bulanan tidak dapat dihantar ke JPN & IPJPSM — ralat menyatakan ada borang belum disahkan sedangkan borang tersebut telah disahkan pada bulan sebelumnya | Senarai Isu Berbangkit #8; Isu by Paparan (PHD) #1 | Sebagai PHD, sahkan semua borang bulan berkenaan (bukan bulan penghujung suku) dan hantar pakej | Pakej berjaya dihantar tanpa ralat, selagi Borang A/C/D bulan berkenaan telah disahkan (Borang B tidak disyaratkan di luar bulan penghujung suku) | ✅ Telah dibaiki | | |
| ISU-PHD-02 | Tiada notifikasi dan tiada perubahan icon bagi Borang 3C untuk tindakan PHD selepas borang dihantar oleh IBK — dilaporkan khusus di Pulau Pinang, Pahang, Selangor | Senarai Isu Berbangkit #1; Isu by Paparan (PHD) #2 | Sebagai IBK Shuttle 3 di daerah dalam negeri Pulau Pinang/Pahang/Selangor, hantar Borang 3C; sahkan sebagai PHD daerah berkenaan menerima notifikasi loceng/e-mel | Notifikasi diterima oleh PHD berkenaan sebaik borang dihantar; icon status turut berubah pada senarai tugasan PHD | ✅ Telah dibaiki | | |
| ISU-PHD-03 | Buang pilihan tahun 1989; betulkan e-mel (rujuk ISU-IBK-04) | Isu by Paparan (PHD) #3 | Sama seperti ISU-IBK-04, diuji khusus pada paparan PHD | Sama seperti ISU-IBK-04 | ⚪ Belum disahkan | | |
| ISU-PHD-04 | Tiada icon tindakan/status tindakan pada senarai tugasan Borang 3B, 3C, 4B, 4C, 4D, 4E, 5B & 5C — semakan 30 Jun 2026 mendapati isu ini masih berlaku pada kesemua 31 PHD | Senarai Isu Berbangkit #12; Isu by Paparan (PHD) #4 (28/7) | Sebagai PHD (ulangi bagi beberapa daerah berbeza), semak senarai tugasan bagi setiap jenis borang yang disenaraikan | Icon/status tindakan dipaparkan dengan betul bagi semua jenis borang di atas, merentasi **semua** PHD (bukan sampel sahaja) | ✅ Telah dibaiki | | Sila sahkan merentasi beberapa daerah berbeza memandangkan laporan asal menyatakan isu berlaku pada semua 31 PHD |
| ISU-PHD-05 | Notifikasi kilang (cth: VC Venture Papan Lapis/Venir) — klik notifikasi memaparkan ralat, sepatutnya membuka borang berkenaan | Isu by Paparan (PHD) #5 (28/7) | Sebagai PHD, klik notifikasi berkaitan penghantaran borang oleh kilang tersebut/kilang lain | Notifikasi membuka borang/halaman berkaitan tanpa ralat | ⚪ Belum disahkan | | |
| ISU-PHD-06 | Tiada dropdown tahun pada paparan/senarai tertentu | Isu by Paparan (PHD) #6 (28/7) | Semak paparan senarai borang/laporan PHD yang sepatutnya mempunyai pilihan tahun | Dropdown/pilihan tahun dipaparkan dan berfungsi | ⚪ Belum disahkan | | |
| ISU-PHD-07 | Borang bulan April ditutup, tetapi borang bulan seterusnya dan sebelumnya masih boleh dikunci masuk; icon sistem tidak membenarkan klik butang Borang D | Isu by Paparan (PHD) #7 (28/7) | Sebagai IBK, cuba isi Borang C/D bagi bulan April dan bulan-bulan bersebelahan; semak butang Borang D boleh diklik mengikut urutan borang yang betul | Borang ditutup/dibuka mengikut urutan dan tempoh yang betul; butang Borang D boleh diklik apabila syarat dipenuhi | ⚪ Belum disahkan | | |
| ISU-PHD-08 | Kesilapan nama daerah Pulau Pinang (rujuk ISU-IBK-10) | Isu by Paparan (PHD) #8 (28/7) | Sama seperti ISU-IBK-10, diuji khusus pada paparan PHD | Sama seperti ISU-IBK-10 | ✅ Telah dibaiki | | |
| ISU-PHD-09 | Icon baharu diperlukan pada paparan PHD dan IPJPSM | Senarai Isu Berbangkit #9 | Semak dengan pembangun skop/reka bentuk icon baharu yang dimaksudkan, sahkan ia telah ditambah pada paparan PHD dan IPJPSM | Icon baharu kelihatan pada paparan berkenaan mengikut spesifikasi yang dipersetujui | 🆕 Ciri baharu | | Sila sahkan skop tepat icon yang dimaksudkan bersama pembangun jika belum jelas |
| ISU-PHD-10 | No. lesen tersalah tertera pada Borang 5B, 5C, 5D & 5E bagi IBK Gunung Seraya — nombor lesen betul: **KLG3/94/KK** | Senarai Isu Berbangkit #10 | Buka Borang 5B/5C/5D/5E bagi kilang Gunung Seraya sebagai PHD/PK atau IBK, semak No. lesen yang tertera | No. lesen dipaparkan sebagai KLG3/94/KK pada kesemua borang berkenaan | 🟡 Pembetulan data/pentadbiran | | Ini adalah pembetulan rekod kilang, bukan pepijat kod — sahkan rekod telah dikemaskini |

---

## C. Paparan JPN

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-JPN-01 | Buang pilihan tahun 1989; betulkan e-mel (rujuk ISU-IBK-04) | Isu by Paparan (JPN) #1 | Sama seperti ISU-IBK-04, diuji khusus pada paparan JPN | Sama seperti ISU-IBK-04 | ⚪ Belum disahkan | | |
| ISU-JPN-02 | Isu "coding" pada senarai/pilihan daerah | Isu by Paparan (JPN) #2 (28/7) | Semak paparan/senarai daerah pada modul yang berkaitan sebagai JPN | Kod/paparan daerah berfungsi dan dipetakan dengan betul | ⚪ Belum disahkan | | |
| ISU-JPN-03 | Kesilapan nama daerah Pulau Pinang (rujuk ISU-IBK-10) | Isu by Paparan (JPN) #3 (28/7) | Sama seperti ISU-IBK-10, diuji khusus pada paparan JPN | Sama seperti ISU-IBK-10 | ✅ Telah dibaiki | | |
| ISU-JPN-04 | Tiada jumlah dipaparkan pada senarai borang yang belum disahkan PHD, sedangkan borang telah dihantar oleh daerah | Senarai Isu Berbangkit #11; Isu by Paparan (JPN) #4 (28/7) | Sebagai JPN, semak kad/kiraan papan pemuka "Senarai Borang Yang Belum Disahkan Pegawai Hutan Daerah" bagi negeri dengan borang berstatus belum disahkan sedia ada | Kiraan/jumlah dipaparkan tepat (bukan sifar), sepadan dengan bilangan sebenar borang belum disahkan | ✅ Telah dibaiki | | |

---

## D. Paparan IPJPSM

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-IPJPSM-01 | Tiada daerah dipaparkan pada Shuttle 4 & Shuttle 5 di paparan pengurusan pengguna (Shuttle 3 sudah betul) | Senarai Isu Berbangkit #3; Isu by Paparan (IPJPSM) #1 | Sebagai IPJPSM, buka senarai pengurusan pengguna/kilang bagi Shuttle 4 dan Shuttle 5 | Lajur Daerah Hutan dipaparkan dengan betul bagi Shuttle 4 dan Shuttle 5, selari dengan Shuttle 3 | ✅ Telah dibaiki | | |
| ISU-IPJPSM-02 | Tiada tertera negeri bagi kilang pada Borang 4A semasa pengesahan borang | Senarai Isu Berbangkit #6; Isu by Paparan (IPJPSM) #2 | Sebagai IPJPSM, buka Borang 4A untuk pengesahan bagi mana-mana kilang Shuttle 4 | Negeri kilang dipaparkan (bukan kosong) pada borang pengesahan | ✅ Telah dibaiki | | |
| ISU-IPJPSM-03 | Ralat (error) berlaku selepas membuat pengesahan pendaftaran | Senarai Isu Berbangkit #7; Isu by Paparan (IPJPSM) #3 | Sebagai IPJPSM, luluskan beberapa permohonan pendaftaran IBK (kombinasi data berbeza, termasuk kilang tanpa daerah lengkap) | Pengesahan berjaya tanpa ralat; jika penghantaran e-mel gagal, pengesahan tetap disimpan dan tidak menyebabkan kegagalan proses | ✅ Telah dibaiki | | |
| ISU-IPJPSM-04 | Buang pilihan tahun 1989; betulkan e-mel (rujuk ISU-IBK-04) | Isu by Paparan (IPJPSM) #4 | Sama seperti ISU-IBK-04, diuji khusus pada paparan IPJPSM | Sama seperti ISU-IBK-04 | ⚪ Belum disahkan | | |
| ISU-IPJPSM-05 | Kemas kini e-mel menyebabkan e-mel ID SSM kilang dan ID pengguna kilang (peribadi) menjadi sama | Isu by Paparan (IPJPSM) #5 (28/7) | Kemas kini e-mel bagi akaun kilang (SSM) atau akaun peribadi (KP) melalui profil/pengurusan pengguna, semak kedua-dua rekod e-mel selepas kemas kini | Kemas kini e-mel hanya terpakai pada akaun yang dikemaskini; akaun lain tidak terjejas secara tidak sengaja | ⚪ Belum disahkan | | |
| ISU-IPJPSM-06 | Penukaran pengguna dari JPN kepada PHD — Faridah Deraman (→ PHDTU), Muhammad Hakimi bin Azizan (→ PHDN9Timur) | Senarai Isu Berbangkit #13; Isu by Paparan (IPJPSM) #6 (28/7) | Semak rekod peranan bagi kedua-dua pengguna tersebut dalam pengurusan pengguna | Kedua-dua pengguna berdaftar sebagai PHD (PHDTU dan PHDN9Timur masing-masing), bukan lagi JPN | 🟡 Pembetulan data/pentadbiran | | Tindakan asal: En. Zulfadly — ini perubahan peranan pengguna, bukan pepijat kod |
| ISU-IPJPSM-07 | Kesilapan nama daerah Pulau Pinang (rujuk ISU-IBK-10) | Isu by Paparan (IPJPSM) #7 (28/7) | Sama seperti ISU-IBK-10, diuji khusus pada paparan IPJPSM | Sama seperti ISU-IBK-10 | ✅ Telah dibaiki | | |
| ISU-IPJPSM-08 | Icon baharu diperlukan pada paparan IPJPSM (rujuk ISU-PHD-09) | Senarai Isu Berbangkit #9 | Sama seperti ISU-PHD-09, diuji khusus pada paparan IPJPSM | Sama seperti ISU-PHD-09 | 🆕 Ciri baharu | | |
| ISU-IPJPSM-09 | Kemas kini maklumat kilang: DERET JAYA SDN BHD (no. 394) — no. lesen; Ehsana Maju Sdn Bhd; Perusahaan Seri Simpang Pertang | Senarai Isu Berbangkit #14 | Semak rekod ketiga-tiga kilang tersebut dalam sistem | Maklumat (terutama no. lesen) dikemaskini mengikut data betul yang diberikan | 🟡 Pembetulan data/pentadbiran | | Tindakan asal: En. Zulfadly |
| ISU-IPJPSM-10 | Gandaan nama kilang/nyahaktifkan ID pengguna: Kilang Papan Rimba Timor (Johor) Sdn Bhd (328 & 369); Meng Long Door Mill Sdn Bhd (25 & 44 — KKumai); Norita binti Ahmad @ Ismail; Loo Wen Hau | Senarai Isu Berbangkit #15 | Semak rekod kilang/pengguna berkenaan; sahkan rekod pendua (duplicate) telah dinyahaktifkan | Hanya satu rekod aktif bagi setiap kilang/pengguna di atas; rekod pendua berstatus tidak aktif | 🟡 Pembetulan data/pentadbiran | | Dikemaskini 19 Mei 2026 — sila sahkan nyahaktifan akaun telah dilaksanakan pada sistem |

---

## E. Laporan (Modul Laporan IPJPSM)

### E.1 Laporan Shuttle 3 (Kilang Papan)

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-RPT-S3-01 | Sistem tidak membenarkan penjanaan Laporan No. 2 & No. 4 (Kilang Papan) bagi tahun 2026 | Senarai Isu Berbangkit #16; Isu by Paparan (Laporan) #8 (28/7) | Jana Laporan No. 2 dan No. 4 bagi Shuttle 3, tahun 2026 | Laporan berjaya dijana tanpa sekatan tahun | ✅ Telah dibaiki | | Perubahan asal dibuat 25 Mei 2026 |
| ISU-RPT-S3-02 | Laporan No. 47 & No. 48 — data tidak tally; jumlah kedua-dua laporan sepatutnya sama | Isu by Paparan (Laporan) #9 (28/7) | Jana Laporan No. 47 dan No. 48 bagi tempoh/tahun yang sama, bandingkan jumlah | Jumlah kedua-dua laporan sepadan | ⚪ Belum disahkan | | |
| ISU-RPT-S3-03 | Laporan No. 25 — fail Excel tidak dapat dijana | Isu by Paparan (Laporan) #10 (28/7) | Jana Laporan No. 25 dalam format Excel | Fail Excel berjaya dijana dan dimuat turun | ⚪ Belum disahkan | | |
| ISU-RPT-S3-04 | Laporan No. 36 — data tidak sama seperti data Laporan No. 34 | Isu by Paparan (Laporan) #11 (28/7) | Jana Laporan No. 34 dan No. 36 bagi tempoh sama, bandingkan data yang bertindih | Data yang sepatutnya sama antara kedua-dua laporan adalah konsisten | ⚪ Belum disahkan | | |
| ISU-RPT-S3-05 | Laporan No. 15 — jumlah dan purata pendapatan guna tenaga mengikut kategori dan kewarganegaraan di kilang papan; hasil pengiraan purata salah | Senarai Isu Berbangkit #17; Isu by Paparan (Laporan) #12 (28/7) | Jana Laporan No. 15 bagi Shuttle 3, semak pengiraan purata pendapatan mengikut kategori pekerja dan kewarganegaraan | Purata dikira dengan betul (bukan purata berjalan/running-average yang salah) | ✅ Telah dibaiki | | Status pada tarikh laporan asal: "Belum Dikemaskini" — sila beri tumpuan khusus pengesahan semula item ini |
| ISU-RPT-S3-06 | Laporan No. 44 — data janaan PDF dan Excel tidak sama seperti dipaparkan dalam sistem | Isu by Paparan (Laporan) #13 (28/7) | Jana Laporan No. 44 dalam bentuk PDF dan Excel, bandingkan dengan paparan pada skrin | Data PDF, Excel, dan paparan skrin adalah konsisten | ⚪ Belum disahkan | | |

### E.2 Laporan Shuttle 4 (Kilang Papan Lapis/Venir)

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-RPT-S4-01 | Laporan No. 1 — bilangan kilang tidak sama dengan janaan laporan | Isu by Paparan (Laporan) #15 | Jana Laporan No. 1 Shuttle 4, bandingkan bilangan kilang dengan senarai kilang sebenar | Bilangan kilang dalam laporan sepadan dengan data sebenar | ✅ Telah dibaiki | | |
| ISU-RPT-S4-02 | Laporan No. 2 (Senarai pemilik kilang papan lapis/venir bumiputera), No. 5 (Top 10 pengeluar papan lapis), No. 6 (Top 10 pengeluar venir) — ralat mengarahkan sahkan Borang A walaupun tiada butang "diperakui" pada paparan borang | Senarai Isu Berbangkit #18; Isu by Paparan (Laporan) #16, #17 | Jana Laporan No. 2, No. 5, dan No. 6 Shuttle 4 bagi kilang yang Borang A-nya telah disahkan PHD (walaupun belum kelulusan akhir IPJPSM) | Laporan berjaya dijana tanpa ralat palsu meminta pengesahan Borang A | ✅ Telah dibaiki | | |
| ISU-RPT-S4-03 | Laporan No. 3 (Kilang Papan Lapis/Venir) — isu janaan laporan | Isu by Paparan (Laporan) #14 (28/7) | Jana Laporan No. 3 Shuttle 4 | Laporan berjaya dijana dengan data betul | ⚪ Belum disahkan | | |
| ISU-RPT-S4-04 | Laporan No. 22 — penggunaan kayu balak mengikut negeri bagi siri masa 2023–2024; jadual tidak lengkap dan tiada jumlah besar | Isu by Paparan (Laporan) #18 (28/7) | Jana Laporan No. 22 Shuttle 4 bagi tahun 2023–2024 | Jadual lengkap merentasi semua negeri berkaitan dan memaparkan jumlah besar | ⚪ Belum disahkan | | |

### E.3 Laporan Shuttle 5 (Kilang Kayu Kumai)

| ID | Isu Dilaporkan | Rujukan Asal | Langkah Pengesahan | Hasil Dijangka | Status Pembaikan | Keputusan UAT (Lulus/Gagal/NA) | Catatan |
|---|---|---|---|---|---|---|---|
| ISU-RPT-S5-01 | Laporan No. 3 — gandaan poskod dan daerah dalam laporan | Senarai Isu Berbangkit #4; Isu by Paparan (Laporan) #19 (28/7) | Jana Laporan No. 3 Shuttle 5 (Kilang Kayu Kumai) | Poskod dan daerah dipaparkan sekali sahaja bagi setiap rekod (tiada pendua) | ✅ Telah dibaiki | | |
| ISU-RPT-S5-02 | Laporan No. 2 — ralat keluar meminta sahkan Borang A sedangkan Borang A sudah disahkan (Shuttle 4 & Shuttle 5) | Senarai Isu Berbangkit #5 | Jana Laporan No. 2 Shuttle 5 bagi kilang yang Borang A-nya telah disahkan PHD | Laporan berjaya dijana tanpa ralat palsu | ✅ Telah dibaiki | | |
| ISU-RPT-S5-03 | Server error pada Laporan No. 2–3; hanya Laporan No. 1 boleh dijana; turut berlaku isu sama seperti Shuttle 4 — tiada tertera daerah dan negeri | Senarai Isu Berbangkit #19 | Jana Laporan No. 1, 2, dan 3 Shuttle 5; semak lajur daerah dan negeri pada semua laporan | Kesemua laporan (No. 1–3) berjaya dijana tanpa server error; lajur daerah dan negeri terisi dengan betul | ✅ Telah dibaiki | | |
| ISU-RPT-S5-04 | Laporan No. 46 — data tidak betul; laporan PDF dan Excel turut salah | Isu by Paparan (Laporan) #20 (28/7) | Jana Laporan No. 46 Shuttle 5 dalam format PDF dan Excel, sahkan ketepatan data | Data dalam laporan (skrin, PDF, Excel) adalah tepat dan konsisten | ⚪ Belum disahkan | | |

---

## F. Nota Penting Sebelum Menjalankan Pengesahan

1. **Data ujian vs data sebenar**: Sebahagian isu di atas (cth. Laporan No. 15, No. 47/48) melibatkan pengiraan merentasi rekod sebenar sepanjang tahun. Disyorkan pengesahan dijalankan menggunakan data sebenar sedia ada (bukan data ujian baharu) supaya perbandingan angka lebih bermakna — berhati-hati untuk **tidak mengubah** rekod sebenar semasa proses pengesahan (guna fungsi "lihat"/jana laporan sahaja, elak kemas kini/padam).
2. **Status "⚪ Belum disahkan"**: Item bertanda ini masih memerlukan siasatan/pembaikan lanjut oleh pembangun sebelum EKBK menjalankan pengesahan — sila maklumkan pembangun keutamaan item mana yang perlu diselesaikan dahulu.
3. **Item pembetulan data/pentadbiran (🟡)**: Ini bukan pepijat sistem — pengesahan hanya untuk mengesahkan rekod telah dikemaskini seperti diminta, bukan menguji tingkah laku kod.
4. **Rujukan silang dengan UAT penuh**: Jika EKBK ingin menjalankan UAT/FAT menyeluruh (bukan setakat isu ini sahaja) pada bila-bila masa akan datang, rujuk `UAT_FAT_PELAN_PENGUJIAN.md` yang meliputi semua modul sistem.

---

## Kelulusan

| Peranan | Nama | Tandatangan | Tarikh |
|---|---|---|---|
| Disediakan oleh (Pembangun) | Muhammad Faiz Abdullah | | |
| Disemak oleh (Wakil Teknikal EKBK) | | | |
| Diluluskan oleh (Pemilik Sistem/IPJPSM) | | | |
