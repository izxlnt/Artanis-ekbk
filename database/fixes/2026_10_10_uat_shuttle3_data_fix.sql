-- =====================================================================================
-- eShuttle UAT (Shuttle 3, 9 Oct 2026 checklist) - one-off data corrections
-- Database: eshuttle_training
--
-- Run each step on its own: check the preview SELECT first, then run the UPDATE/DELETE.
-- Every step only touches rows that are provably inconsistent, so re-running is harmless.
-- Take a backup of the touched tables first:
--   mysqldump eshuttle_training form_d_s penjualan_pembelis kemasukan_bahans shuttles pengguna_kilangs > before_fix.sql
-- =====================================================================================


-- -------------------------------------------------------------------------------------
-- STEP 1  (checklist 11.8 - 11.12)  Form D 37060: report total was zeroed by the IPJPSM
-- cleaning page while its buyer rows kept 574.86, so Laporan 41/42/43 (Form D total)
-- showed 11,456 and Laporan 44/45/46 (buyers) 12,031.
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
-- STEP 2  (checklist 6.6)  Shuttle 3 Form D 2026: duplicated buyer rows.
-- The old correction page deleted + re-inserted buyer rows without a transaction, so a
-- double submit left 2-4 copies (buyer total = 2x/4x the form total). Keep the newest
-- row per (form, buyer type).
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
      FROM penjualan_pembelis GROUP BY formds_id, pembeli_id HAVING COUNT(*) > 1) k
  ON k.formds_id = pp.formds_id AND k.pembeli_id = pp.pembeli_id
WHERE pp.id <> k.keep_id;


-- -------------------------------------------------------------------------------------
-- STEP 3  (checklist 6.6)  Shuttle 3 Form D 2026: domestic total out of step with its
-- buyer rows (mostly saved as 0 by the old correction page). The IBK page defines the
-- domestic total as the sum of the buyer rows, so restore that. Only forms not yet
-- finalised by IPJPSM ('Lulus' rows carry IPJPSM's own cleaned report figures).
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
-- STEP 4  (checklist 7)  Shuttle 3 Form C 2026: group "Jumlah" totals saved as
-- (true total x number of species), compounding on every save (e.g. Heang Lee May KKB
-- 207,253.80 instead of 2,438.28). Recompute every group total from its species rows.
-- -------------------------------------------------------------------------------------
-- preview (can take a few minutes on 2.3M rows)
SELECT c.id AS formcs_id, s.nama_kilang, c.bulan, sp.kumpulan_kayu_id,
       MAX(k.total_stok_kayu_balak) AS stored, ROUND(SUM(k.jumlah_stok_kayu_balak), 2) AS actual
FROM form_c_s c
JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type = '3'
JOIN kemasukan_bahans k ON k.formcs_id = c.id
JOIN spesis sp ON sp.id = k.spesis_id
WHERE c.tahun >= 2026
GROUP BY c.id, s.nama_kilang, c.bulan, sp.kumpulan_kayu_id
HAVING ABS(stored - actual) > 0.05
LIMIT 200;

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
    JOIN form_c_s c ON c.id = k2.formcs_id AND c.tahun >= 2026
    JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type = '3'
    GROUP BY k2.formcs_id, sp2.kumpulan_kayu_id
    -- only the groups whose stored totals are wrong (7 forms / 18 groups on 10 Oct 2026)
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

-- grand totals ("Jumlah Besar", stored on the Lain-Lain rows) = sum of all species of the form
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
    JOIN form_c_s c ON c.id = k2.formcs_id AND c.tahun >= 2026
    JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type = '3'
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
-- STEP 5  (checklist 6.1)  Heang Lee Sawmill (shuttle 391) May 2026: Form D stayed
-- PHD-approved while its Form C was sent back for correction. Put Form D back to pending
-- PHD approval (the code now does this automatically when a Form C is sent back).
-- -------------------------------------------------------------------------------------
SELECT id, status FROM form_d_s WHERE shuttle_id = 391 AND tahun = 2026 AND bulan = '5';

UPDATE form_d_s d
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
SET d.status = 'Sedang Diproses'
WHERE d.shuttle_id = 391 AND d.tahun = 2026 AND d.bulan = '5'
  AND d.status = 'Dihantar ke IPJPSM' AND c.status IN ('Sedang Diisi', 'Tidak Lengkap');

UPDATE batches SET borang_d = '1'
WHERE shuttle_id = 391 AND tahun = 2026 AND bulan = '5' AND borang_d = '2';


-- -------------------------------------------------------------------------------------
-- STEP 6  (checklist 10.1)  Orphans left by registrations that failed half-way
-- (duplicate IC) before registration was made atomic. Nothing references them; while
-- they exist the same SSM number is rejected as "already registered".
-- -------------------------------------------------------------------------------------
SELECT s.id, s.nama_kilang, s.no_ssm, s.created_at,
       (SELECT COUNT(*) FROM users u WHERE u.shuttle_id = s.id) AS users,
       (SELECT COUNT(*) FROM pengguna_kilangs p WHERE p.shuttle_id = s.id) AS pengguna,
       (SELECT COUNT(*) FROM form_a_s a WHERE a.shuttle_id = s.id) AS form_a
FROM shuttles s WHERE s.id IN (2008, 2017);

SELECT p.id, p.no_kad_pengenalan, p.shuttle_id,
       (SELECT COUNT(*) FROM users u WHERE u.pengguna_kilang_id = p.id) AS users
FROM pengguna_kilangs p WHERE p.id = 2167;

DELETE FROM pengguna_kilangs
WHERE id = 2167 AND NOT EXISTS (SELECT 1 FROM users u WHERE u.pengguna_kilang_id = 2167);

DELETE FROM shuttles
WHERE id IN (2008, 2017)
  AND NOT EXISTS (SELECT 1 FROM users u WHERE u.shuttle_id = shuttles.id)
  AND NOT EXISTS (SELECT 1 FROM pengguna_kilangs p WHERE p.shuttle_id = shuttles.id)
  AND NOT EXISTS (SELECT 1 FROM form_a_s a WHERE a.shuttle_id = shuttles.id);
