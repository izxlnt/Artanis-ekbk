-- =====================================================================================
-- eShuttle PRODUCTION - data corrections before go-live (25 Oct 2026). Database: eshuttle.
--
-- The same corrections UAT received on eshuttle_training (2026_10_10 .. 2026_10_18 files),
-- now for production. eshuttle_training was copied from production, so the frozen ids below
-- were checked one by one on 25 Oct 2026 and point to the same kilang and month here.
-- Ids that only exist on training (51010, 4924, 4069-4078, orphans 2008/2017/2167) are left out.
--
-- Run from the project root, check first (previews + syntax only, nothing changes):
--     php database\fixes\run_2026_10_10_uat_shuttle3_data_fix.php 2026_10_25_production_data_fix.sql --check
--     php database\fixes\run_2026_10_10_uat_shuttle3_data_fix.php 2026_10_25_production_data_fix.sql
-- Every step only touches rows that are still wrong, so running it again changes nothing.
-- Backup of every row it can touch: storage/app/backup/2026_10_25_before_production_data_fix.json
-- =====================================================================================


-- -------------------------------------------------------------------------------------
-- STEP 1  PHD user #514 MUHAMMAD HAKIMI (950920055231) has no district: registered in 2023 as
-- JPN, later changed to PHD outside the system. The testing list names him PHD N9 Timur.
-- -------------------------------------------------------------------------------------
SELECT id, name, kategori_pengguna, negeri, daerah, daerah_id FROM users WHERE id = 514;

UPDATE users SET daerah = 'Negeri Sembilan Timur', daerah_id = 96, updated_at = NOW()
WHERE id = 514 AND kategori_pengguna = 'PHD' AND daerah_id IS NULL;


-- -------------------------------------------------------------------------------------
-- STEP 2  (S5 checklist PHD 1)  Status Hak Milik shown as "1": one registration path stored the
-- hak_miliks id instead of its text (fixed in code). Replace the id with the text. 15 kilang.
-- -------------------------------------------------------------------------------------
SELECT s.id, s.nama_kilang, s.status_hak_milik, h.keterangan
FROM shuttles s JOIN hak_miliks h ON h.id = s.status_hak_milik
WHERE s.status_hak_milik REGEXP '^[0-9]+$';

UPDATE shuttles s
JOIN hak_miliks h ON h.id = s.status_hak_milik
SET s.status_hak_milik = h.keterangan
WHERE s.status_hak_milik REGEXP '^[0-9]+$';


-- -------------------------------------------------------------------------------------
-- STEP 3  (S5 checklist Kilang 3)  GUNUNG SERAYA WOOD PRODUCTS (shuttle 28): forms carry the
-- wrong licence number LL03163101810420192; the correct one is KLG3/94/KK (as on the kilang).
-- -------------------------------------------------------------------------------------
SELECT 'formbs' t, COUNT(*) n FROM formbs WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192'
UNION ALL SELECT 'form_c_s', COUNT(*) FROM form_c_s WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192'
UNION ALL SELECT 'form5_d_s', COUNT(*) FROM form5_d_s WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192'
UNION ALL SELECT 'form5_e_s', COUNT(*) FROM form5_e_s WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';

UPDATE formbs SET no_lesen = 'KLG3/94/KK' WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';
UPDATE form_c_s SET no_lesen = 'KLG3/94/KK' WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';
UPDATE form5_d_s SET no_lesen = 'KLG3/94/KK' WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';
UPDATE form5_e_s SET no_lesen = 'KLG3/94/KK' WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';


-- -------------------------------------------------------------------------------------
-- STEP 4  (Laporan 41-45)  Borang 5E certified by IPJPSM: the approval only changed the status
-- and never filled the report figures. Where IPJPSM made no correction, the report figure is
-- the kilang's figure. 5 forms.
-- -------------------------------------------------------------------------------------
SELECT id, shuttle_id, bulan, jumlah_jualan_pasaran_tempatan, jumlah_jualan_pasaran_tempatan_laporan,
       jumlah_jualan_eksport, jumlah_jualan_eksport_laporan
FROM form5_e_s
WHERE tahun >= 2026 AND status = 'Lulus';

UPDATE form5_e_s
SET jumlah_jualan_pasaran_tempatan_laporan = IF(IFNULL(jumlah_jualan_pasaran_tempatan_cleaning, 0) = 0,
        IFNULL(jumlah_jualan_pasaran_tempatan, 0), jumlah_jualan_pasaran_tempatan_cleaning),
    jumlah_jualan_eksport_laporan = IF(IFNULL(jumlah_jualan_eksport_cleaning, 0) = 0,
        IFNULL(jumlah_jualan_eksport, 0), jumlah_jualan_eksport_cleaning)
WHERE tahun >= 2026 AND status = 'Lulus'
  AND (IFNULL(jumlah_jualan_pasaran_tempatan_laporan, 0) <> IF(IFNULL(jumlah_jualan_pasaran_tempatan_cleaning, 0) = 0, IFNULL(jumlah_jualan_pasaran_tempatan, 0), jumlah_jualan_pasaran_tempatan_cleaning)
    OR IFNULL(jumlah_jualan_eksport_laporan, 0) <> IF(IFNULL(jumlah_jualan_eksport_cleaning, 0) = 0, IFNULL(jumlah_jualan_eksport, 0), jumlah_jualan_eksport_cleaning));


-- -------------------------------------------------------------------------------------
-- STEP 5  (Laporan 42-47, Shuttle 4)  Borang 4E certified by IPJPSM: approving without edits
-- saved 0 as the report figures. Where IPJPSM made no correction, use the kilang's figure. 5 forms.
-- -------------------------------------------------------------------------------------
SELECT e.id, e.shuttle_id, e.bulan,
       e.jumlah_pasaran_tempatan, e.jumlah_pasaran_tempatan_laporan,
       e.jumlah_venier_tempatan, e.jumlah_venier_tempatan_laporan,
       e.total_export, e.total_export_laporan
FROM form4_e_s e
WHERE e.tahun >= 2026 AND e.status = 'Lulus';

UPDATE form4_e_s e
SET e.total_export_laporan = IF(IFNULL(e.total_export_cleaning, 0) = 0, IFNULL(e.total_export, 0), e.total_export_laporan),
    e.jumlah_venier_eksport_laporan = IF(IFNULL(e.jumlah_venier_eksport_cleaning, 0) = 0, IFNULL(e.jumlah_venier_eksport, 0), e.jumlah_venier_eksport_laporan),
    e.jumlah_pasaran_tempatan_laporan = IF(IFNULL(e.jumlah_pasaran_tempatan_cleaning, 0) = 0, IFNULL(e.jumlah_pasaran_tempatan, 0), e.jumlah_pasaran_tempatan_laporan),
    e.jumlah_venier_tempatan_laporan = IF(IFNULL(e.jumlah_venier_tempatan_cleaning, 0) = 0, IFNULL(e.jumlah_venier_tempatan, 0), e.jumlah_venier_tempatan_laporan)
WHERE e.tahun >= 2026 AND e.status = 'Lulus';

UPDATE penjualan_pembelis pp
JOIN form4_e_s e ON e.id = pp.form4es_id AND e.tahun >= 2026 AND e.status = 'Lulus'
SET pp.jumlah_jualan_laporan = IFNULL(pp.jumlah_jualan, 0),
    pp.total_jumlah_jualan_laporan = IF(IFNULL(pp.total_jumlah_jualan_cleaning, 0) = 0, pp.total_jumlah_jualan, pp.total_jumlah_jualan_laporan)
WHERE IFNULL(pp.jumlah_jualan_cleaning, 0) = 0
  AND IFNULL(pp.jumlah_jualan_laporan, 0) <> IFNULL(pp.jumlah_jualan, 0);


-- -------------------------------------------------------------------------------------
-- STEP 6  (Laporan 41-46, Shuttle 3)  Form D 37060 TEOH CHONG SEY (Mac, Lulus): report total
-- was zeroed by the IPJPSM cleaning page while its buyer rows kept 574.86.
-- -------------------------------------------------------------------------------------
SELECT d.id, d.jumlah_pasaran_tempatan, d.jumlah_pasaran_tempatan_laporan,
       (SELECT SUM(jumlah_jualan_laporan) FROM penjualan_pembelis WHERE formds_id = d.id) AS buyers_laporan
FROM form_d_s d WHERE d.id = 37060;

UPDATE form_d_s d
JOIN (SELECT formds_id, ROUND(SUM(jumlah_jualan_laporan), 2) AS s
      FROM penjualan_pembelis WHERE formds_id = 37060 GROUP BY formds_id) p ON p.formds_id = d.id
SET d.jumlah_pasaran_tempatan_laporan = p.s,
    d.jumlah_pasaran_tempatan_cleaning = p.s
WHERE d.id = 37060 AND d.jumlah_pasaran_tempatan_laporan = 0;


-- -------------------------------------------------------------------------------------
-- STEP 7  (Shuttle 3)  Borang D 2026: duplicated buyer rows. The old correction page deleted and
-- re-inserted buyer rows without a transaction, so a double submit left 2-4 copies. Keep the
-- newest row per (form, buyer type). 80 (form, buyer) pairs on 25 Oct 2026.
-- -------------------------------------------------------------------------------------
SELECT pp.formds_id, pp.pembeli_id, COUNT(*) AS copies
FROM penjualan_pembelis pp
JOIN form_d_s d ON d.id = pp.formds_id AND d.tahun >= 2026
JOIN shuttles s ON s.id = d.shuttle_id AND s.shuttle_type = '3'
GROUP BY pp.formds_id, pp.pembeli_id HAVING COUNT(*) > 1;

DELETE pp FROM penjualan_pembelis pp
JOIN form_d_s d ON d.id = pp.formds_id AND d.tahun >= 2026
JOIN shuttles s ON s.id = d.shuttle_id AND s.shuttle_type = '3'
JOIN (SELECT formds_id, pembeli_id, MAX(id) AS keep_id
      FROM penjualan_pembelis WHERE formds_id IS NOT NULL GROUP BY formds_id, pembeli_id HAVING COUNT(*) > 1) k
  ON k.formds_id = pp.formds_id AND k.pembeli_id = pp.pembeli_id
WHERE pp.id <> k.keep_id;


-- -------------------------------------------------------------------------------------
-- STEP 8  (Shuttle 3)  Borang D 2026: domestic total out of step with its buyer rows (mostly
-- saved as 0 by the old correction page). The domestic total is the sum of the buyer rows.
-- Only forms not yet certified ('Lulus' rows carry IPJPSM's own report figures). Runs after
-- step 7 so the duplicates are gone first.
-- -------------------------------------------------------------------------------------
SELECT d.id, s.nama_kilang, d.bulan, d.status, d.jumlah_pasaran_tempatan, p.s AS buyers
FROM form_d_s d
JOIN shuttles s ON s.id = d.shuttle_id AND s.shuttle_type = '3'
JOIN (SELECT formds_id, ROUND(SUM(jumlah_jualan), 2) AS s FROM penjualan_pembelis GROUP BY formds_id) p ON p.formds_id = d.id
WHERE d.tahun >= 2026 AND d.status IN ('Sedang Diproses', 'Dihantar ke IPJPSM', 'Tidak Lengkap')
  AND ABS(IFNULL(d.jumlah_pasaran_tempatan, 0) - p.s) > 0.01;

UPDATE form_d_s d
JOIN shuttles s ON s.id = d.shuttle_id AND s.shuttle_type = '3'
JOIN (SELECT formds_id, ROUND(SUM(jumlah_jualan), 2) AS s FROM penjualan_pembelis GROUP BY formds_id) p ON p.formds_id = d.id
SET d.jumlah_pasaran_tempatan = p.s
WHERE d.tahun >= 2026 AND d.status IN ('Sedang Diproses', 'Dihantar ke IPJPSM', 'Tidak Lengkap')
  AND ABS(IFNULL(d.jumlah_pasaran_tempatan, 0) - p.s) > 0.01;

UPDATE penjualan_pembelis pp
JOIN form_d_s d ON d.id = pp.formds_id AND d.tahun >= 2026 AND d.status IN ('Sedang Diproses', 'Dihantar ke IPJPSM', 'Tidak Lengkap')
JOIN shuttles s ON s.id = d.shuttle_id AND s.shuttle_type = '3'
SET pp.total_jumlah_jualan = d.jumlah_pasaran_tempatan
WHERE ABS(IFNULL(pp.total_jumlah_jualan, 0) - d.jumlah_pasaran_tempatan) > 0.01;


-- -------------------------------------------------------------------------------------
-- STEP 9  (S5 checklist IPJPSM 5, Modul 2 #2)  Borang C 2026, all shuttles: group "Jumlah"
-- totals saved as (true total x number of species), compounding on every save. Recompute only
-- the groups whose stored totals are wrong, then the form's Jumlah Besar (stored on the
-- Lain-Lain rows, kumpulan 5). On 25 Oct 2026 only 2 forms were wrong (a full scan takes about
-- 45 minutes, so the step is limited to them): 34738 GUNUNG SERAYA (28) Borang 5C April, totals
-- saved up to 99,999,999.99; 44887 JOO KEE TIMBER (1918) Borang C Mac.
-- -------------------------------------------------------------------------------------
SELECT c.id, s.nama_kilang, c.bulan, c.status FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id WHERE c.id IN (44887, 34738);

UPDATE kemasukan_bahans k
JOIN spesis sp ON sp.id = k.spesis_id
JOIN (
    SELECT k2.formcs_id, sp2.kumpulan_kayu_id,
           ROUND(SUM(k2.baki_stok), 2)              AS jumlah_baki_stok,
           ROUND(SUM(k2.kayu_masuk), 2)             AS jumlah_kayu_masuk,
           ROUND(SUM(k2.jumlah_stok_kayu_balak), 2) AS total_stok_kayu_balak,
           ROUND(SUM(k2.proses_masuk), 2)           AS total_kayu_masuk_jentera,
           ROUND(SUM(k2.proses_keluar), 2)          AS total_kayu_keluar_jentera,
           ROUND(SUM(k2.baki_stok_kehadapan), 2)    AS total_kayu_dibawa_bulan_hadapan
    FROM kemasukan_bahans k2
    JOIN spesis sp2 ON sp2.id = k2.spesis_id
    JOIN form_c_s c ON c.id = k2.formcs_id AND c.id IN (44887, 34738)
    GROUP BY k2.formcs_id, sp2.kumpulan_kayu_id
    HAVING ABS(MAX(k2.jumlah_kayu_masuk) - SUM(k2.kayu_masuk)) > 0.05
        OR ABS(MAX(k2.total_stok_kayu_balak) - SUM(k2.jumlah_stok_kayu_balak)) > 0.05
        OR ABS(MAX(k2.total_kayu_masuk_jentera) - SUM(k2.proses_masuk)) > 0.05
        OR ABS(MAX(k2.total_kayu_keluar_jentera) - SUM(k2.proses_keluar)) > 0.05
        OR ABS(MAX(k2.total_kayu_dibawa_bulan_hadapan) - SUM(k2.baki_stok_kehadapan)) > 0.05
) g ON g.formcs_id = k.formcs_id AND g.kumpulan_kayu_id = sp.kumpulan_kayu_id
SET k.jumlah_baki_stok                = g.jumlah_baki_stok,
    k.jumlah_kayu_masuk               = g.jumlah_kayu_masuk,
    k.total_stok_kayu_balak           = g.total_stok_kayu_balak,
    k.total_kayu_masuk_jentera        = g.total_kayu_masuk_jentera,
    k.total_kayu_keluar_jentera       = g.total_kayu_keluar_jentera,
    k.total_kayu_dibawa_bulan_hadapan = g.total_kayu_dibawa_bulan_hadapan;

UPDATE kemasukan_bahans k
JOIN spesis sp ON sp.id = k.spesis_id AND sp.kumpulan_kayu_id = 5
JOIN (
    SELECT k2.formcs_id,
           ROUND(SUM(k2.baki_stok), 2)              AS baki_lepas,
           ROUND(SUM(k2.kayu_masuk), 2)             AS kemasukan,
           ROUND(SUM(k2.jumlah_stok_kayu_balak), 2) AS stok,
           ROUND(SUM(k2.proses_masuk), 2)           AS ke_jentera,
           ROUND(SUM(k2.proses_keluar), 2)          AS dari_jentera,
           ROUND(SUM(k2.baki_stok_kehadapan), 2)    AS baki_depan
    FROM kemasukan_bahans k2
    JOIN form_c_s c ON c.id = k2.formcs_id AND c.id IN (44887, 34738)
    GROUP BY k2.formcs_id
) g ON g.formcs_id = k.formcs_id
SET k.jumlah_besar_baki_stok_bulan_lepas              = g.baki_lepas,
    k.jumlah_besar_kemasukan_kayu_ke_kilang           = g.kemasukan,
    k.jumlah_besar_stok_kayu_balak                    = g.stok,
    k.jumlah_besar_kayu_ke_dalam_jentera              = g.ke_jentera,
    k.jumlah_besar_pengeluaran_kayu_daripada_jentera  = g.dari_jentera,
    k.jumlah_besar_baki_stok_bulan_depan              = g.baki_depan
WHERE ABS(IFNULL(k.jumlah_besar_stok_kayu_balak, 0) - g.stok) > 0.05
   OR ABS(IFNULL(k.jumlah_besar_kayu_ke_dalam_jentera, 0) - g.ke_jentera) > 0.05
   OR ABS(IFNULL(k.jumlah_besar_pengeluaran_kayu_daripada_jentera, 0) - g.dari_jentera) > 0.05
   OR ABS(IFNULL(k.jumlah_besar_baki_stok_bulan_depan, 0) - g.baki_depan) > 0.05
   OR ABS(IFNULL(k.jumlah_besar_kemasukan_kayu_ke_kilang, 0) - g.kemasukan) > 0.05
   OR ABS(IFNULL(k.jumlah_besar_baki_stok_bulan_lepas, 0) - g.baki_lepas) > 0.05;


-- -------------------------------------------------------------------------------------
-- STEP 10  (S4 checklist 7.4 / 7.7)  Borang 4E row 2 "Jumlah papan lapis yang dijual dalam
-- pasaran tempatan" must equal the buyer table total. Row 2 is blank on these 8 forms. Then the
-- certified 3394 (no IPJPSM correction) gets the buyer report total as its report figure.
-- -------------------------------------------------------------------------------------
SELECT e.id, e.shuttle_id, e.bulan, e.status, e.jumlah_pasaran_tempatan AS baris_2,
       (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id) AS jumlah_pembeli
FROM form4_e_s e
WHERE e.id IN (3136,3241,3244,3247,3250,3394,3316,3319);

UPDATE form4_e_s e
SET e.jumlah_pasaran_tempatan = (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id),
    e.updated_at = NOW()
WHERE e.id IN (3136,3241,3244,3247,3250,3394,3316,3319)
  AND e.jumlah_pasaran_tempatan IS NULL;

UPDATE form4_e_s e
SET e.jumlah_pasaran_tempatan_laporan = (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan_laporan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id),
    e.updated_at = NOW()
WHERE e.id IN (3394) AND e.status = 'Lulus' AND COALESCE(e.jumlah_pasaran_tempatan_cleaning, 0) = 0;


-- -------------------------------------------------------------------------------------
-- STEP 11  (S3 checklist 6.1)  Borang D must follow its Borang C: D still sent while the same
-- month's C is not. The code now sends D back together with C; this fixes the months already
-- in that state.
--   Shuttle 3: 28165 (391 Heang Lee, Mei), 28489 (580 Chop Yeap Yuen Kee, Mei),
--              33121 (850 Gema Arus, Jan), 35302 (328 Casarina, Mei)
--   Shuttle 5: 3811 (1849 Fong Yik, Apr), 4318 (1915 Pahang Lian Huat, Mei),
--              4405 (1217 Yilian, Okt: 5D saved on 2 Jul 2026, before October's 5C exists)
-- -------------------------------------------------------------------------------------
SELECT 'S3' AS shuttle, d.id, s.nama_kilang, d.bulan, d.status AS status_d, c.status AS status_c
FROM form_d_s d JOIN shuttles s ON s.id = d.shuttle_id
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
WHERE d.id IN (28165,28489,33121,35302)
UNION ALL
SELECT 'S5', d.id, s.nama_kilang, d.bulan, d.status, c.status
FROM form5_d_s d JOIN shuttles s ON s.id = d.shuttle_id
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
WHERE d.id IN (3811,4318,4405);

UPDATE form_d_s d
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
SET d.status = 'Tidak Lengkap', d.updated_at = NOW()
WHERE d.id IN (28165,28489,33121,35302)
  AND d.status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM')
  AND c.status IN ('Tidak Lengkap', 'Sedang Diisi', 'Tidak Diisi', 'Ditutup');

UPDATE form5_d_s d
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
SET d.status = 'Tidak Lengkap', d.updated_at = NOW()
WHERE d.id IN (3811,4318,4405)
  AND d.status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM')
  AND c.status IN ('Tidak Lengkap', 'Sedang Diisi', 'Tidak Diisi', 'Ditutup');

INSERT INTO ulasan_phds (ulasan, user_id, formds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form_d_s d
WHERE d.id IN (28165,28489,33121,35302) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

INSERT INTO ulasan_phds (ulasan, user_id, form5ds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form5_d_s d
WHERE d.id IN (3811,4318,4405) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.form5ds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

UPDATE batches b
JOIN form_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.borang_d = '0', b.updated_at = NOW()
WHERE d.id IN (28165,28489,33121,35302) AND d.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';

UPDATE batches b
JOIN form5_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.borang_d = '0', b.updated_at = NOW()
WHERE d.id IN (3811,4318,4405) AND d.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';


-- -------------------------------------------------------------------------------------
-- STEP 12  (S5 checklist Kilang 4, IPJPSM 4)  Opening stock (lajur 02) does not match the
-- previous month's closing stock (lajur 07). The later month goes back to the kilang with its
-- Borang D; when reopened, the opening stock is reloaded from the previous month.
--   35569 LEE WAH SAWMILL (238) Mei      Apr closes 11.20, Mei saved with no stock rows
--   36748 Sim Seng Huat (22) Feb         Jan closes 4,905.26, Feb opened 4,874.03
--   41584 SUJ PALLET (1876) Mac          Feb closes 8.00, Mac saved with no stock rows
--   46294 RUMPUN MAKMUR (1933) Apr       Mac closes 538.38, Apr opened 0
-- -------------------------------------------------------------------------------------
SELECT c.id, s.nama_kilang, c.bulan, c.status, c.tiada_pengeluaran
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (35569, 36748, 41584, 46294);

UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (35569, 36748, 41584, 46294)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Baki stok bulan lepas tidak sama dengan baki stok akhir Borang C bulan sebelumnya. Sila semak semula baki stok bulan lepas (lajur 02) dan hantar semula Borang C bulan ini.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (35569, 36748, 41584, 46294) AND c.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Baki stok bulan lepas tidak sama%');

UPDATE form_d_s SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (29029, 34144, 38107) AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM');

UPDATE form5_d_s SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (3445) AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM');

INSERT INTO ulasan_phds (ulasan, user_id, formds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form_d_s d
WHERE d.id IN (29029, 34144, 38107) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

INSERT INTO ulasan_phds (ulasan, user_id, form5ds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form5_d_s d
WHERE d.id IN (3445) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.form5ds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
SET b.borang_c = '0', b.borang_d = '0', b.updated_at = NOW()
WHERE c.id IN (35569, 36748, 41584, 46294) AND c.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';


-- -------------------------------------------------------------------------------------
-- STEP 13  (S5 checklist Kilang 5)  Month sent while the month before it is empty:
-- 36973 Timbalabs (670) Borang 5C Mei, April "Tidak Diisi". Mei goes back to the kilang; the
-- system only lets them reopen it after April is sent. Kilang registered during 2026 are not
-- included: their earlier months are before registration and are not owed.
-- -------------------------------------------------------------------------------------
SELECT c.id, s.nama_kilang, c.bulan, c.status
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (36973);

UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (36973)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Borang C April belum diisi. Sila isi dan hantar Borang C April dahulu, kemudian semak semula baki stok bulan lepas dan hantar semula Borang C Mei.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (36973) AND c.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Borang C April belum diisi%');

UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
SET b.borang_c = '0', b.updated_at = NOW()
WHERE c.id IN (36973) AND c.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';


-- -------------------------------------------------------------------------------------
-- STEP 14  (S5 checklist IPJPSM 5, Laporan 33)  Shuttle 5: Borang 5C saved before 27 Jul 2026
-- had no "Pengeluaran Kayu Kumai" column (06), so output = 0 and 5D was checked against the
-- wrong column. 5C (and same-month 5D) go back to the kilang to complete column 06.
-- 21 Borang 5C / 16 Borang 5D (12 kilang). Nothing is deleted; figures stay pre-filled.
-- -------------------------------------------------------------------------------------
SELECT c.id, s.nama_kilang, c.bulan, c.status
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (38485,38488,34729,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840);

UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (38485,38488,34729,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Sila semak semula: lengkapkan lajur (06) Pengeluaran Kayu Kumai dan pastikan Borang 5D bulan yang sama sama dengan jumlah pengeluaran ini.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (38485,38488,34729,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840)
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Sila semak semula: lengkapkan lajur (06)%');

UPDATE form5_d_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (3814,3817,3262,3451,3454,4702,4705,4102,4105,3700,3703,4381,4384,4387,4390,4393)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, form5ds_id, created_at, updated_at)
SELECT 'Sila semak semula: jumlah Borang 5D mestilah sama dengan Pengeluaran Kayu Kumai (lajur 06) Borang 5C bulan yang sama.', NULL, d.id, NOW(), NOW()
FROM form5_d_s d
WHERE d.id IN (3814,3817,3262,3451,3454,4702,4705,4102,4105,3700,3703,4381,4384,4387,4390,4393)
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.form5ds_id = d.id AND u.ulasan LIKE 'Sila semak semula: jumlah Borang 5D%');

UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
LEFT JOIN form5_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.status = 'Sedang Diproses',
    b.borang_c = '0',
    b.borang_d = IF(d.status = 'Tidak Lengkap', '0', b.borang_d),
    b.updated_at = NOW()
WHERE c.id IN (38485,38488,34729,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840)
  AND c.status = 'Tidak Lengkap';


-- -------------------------------------------------------------------------------------
-- AFTER: every line below should show 0 (rerun the data checks as well)
-- -------------------------------------------------------------------------------------
SELECT id FROM users WHERE kategori_pengguna = 'PHD' AND status = 1 AND deleted_at IS NULL AND daerah_id IS NULL;
SELECT id FROM shuttles WHERE status_hak_milik REGEXP '^[0-9]+$';
SELECT id FROM form_c_s WHERE shuttle_id = 28 AND no_lesen = 'LL03163101810420192';
SELECT id FROM form4_e_s WHERE id IN (3136,3241,3244,3247,3250,3394,3316,3319) AND jumlah_pasaran_tempatan IS NULL;
