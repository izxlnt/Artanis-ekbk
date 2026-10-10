-- =====================================================================================
-- eShuttle UAT (Shuttle 5, 9 Oct 2026 checklist) - one-off data corrections
-- Database: eshuttle_training. Same conventions as the Shuttle 3/4 fix files:
-- each step has a preview SELECT and only touches rows that are provably wrong.
-- =====================================================================================


-- -------------------------------------------------------------------------------------
-- STEP 1  (checklist 10: Laporan 41-45)  Form 5E approved by IPJPSM: the approval handler
-- only changed the status and never filled the report figures (*_laporan), so every sales
-- report was empty. Where IPJPSM made no correction, the report figure is the kilang's figure.
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
-- STEP 2  (checklist 7.3)  GUNUNG SERAYA WOOD PRODUCTS (shuttle 28): forms still carry the
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
-- STEP 3  (checklist 7.5)  Status Hak Milik shown as "1": one registration path stored the
-- hak_miliks id instead of its text (fixed in RegisterController). Replace the id with the text.
-- -------------------------------------------------------------------------------------
SELECT s.id, s.nama_kilang, s.status_hak_milik, h.keterangan
FROM shuttles s JOIN hak_miliks h ON h.id = s.status_hak_milik
WHERE s.status_hak_milik REGEXP '^[0-9]+$';

UPDATE shuttles s
JOIN hak_miliks h ON h.id = s.status_hak_milik
SET s.status_hak_milik = h.keterangan
WHERE s.status_hak_milik REGEXP '^[0-9]+$';
