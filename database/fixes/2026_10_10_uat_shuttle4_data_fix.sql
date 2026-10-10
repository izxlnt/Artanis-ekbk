-- =====================================================================================
-- eShuttle UAT (Shuttle 4, 9 Oct 2026 checklist) - one-off data corrections
-- Database: eshuttle_training. Same conventions as 2026_10_10_uat_shuttle3_data_fix.sql:
-- each step has a preview SELECT and only touches rows that are provably wrong.
-- =====================================================================================


-- -------------------------------------------------------------------------------------
-- STEP 1  (checklist 10.10 - 10.14)  Form 4E approved by IPJPSM: the approval page pre-filled
-- every "cleaning" box with 0.00, so approving without edits overwrote the report figures
-- (*_laporan) with 0 and Laporan 42-47 showed no data. Where IPJPSM made no correction
-- (cleaning = 0), the report figure is the kilang's own figure.
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
-- STEP 2  Shuttle 4 and 5 Form C 2026: group "Jumlah" totals saved as true total x number
-- of species (same defect as Shuttle 3, fixed in code the same way). Recompute only the
-- groups whose stored totals are wrong (1 Shuttle 4 form, 3 Shuttle 5 forms on 10 Oct 2026).
-- -------------------------------------------------------------------------------------
SELECT c.id AS formcs_id, s.shuttle_type, s.nama_kilang, c.bulan, sp.kumpulan_kayu_id,
       MAX(k.total_stok_kayu_balak) AS stored, ROUND(SUM(k.jumlah_stok_kayu_balak), 2) AS actual
FROM form_c_s c
JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type IN ('4', '5')
JOIN kemasukan_bahans k ON k.formcs_id = c.id
JOIN spesis sp ON sp.id = k.spesis_id
WHERE c.tahun >= 2026
GROUP BY c.id, s.shuttle_type, s.nama_kilang, c.bulan, sp.kumpulan_kayu_id
HAVING ABS(stored - actual) > 0.05;

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
    JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type IN ('4', '5')
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
    JOIN form_c_s c ON c.id = k2.formcs_id AND c.tahun >= 2026
    JOIN shuttles s ON s.id = c.shuttle_id AND s.shuttle_type IN ('4', '5')
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
