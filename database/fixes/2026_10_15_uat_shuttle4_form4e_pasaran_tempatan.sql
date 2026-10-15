-- =====================================================================================
-- eShuttle UAT - Shuttle 4 round 2 (15 Oct 2026), items 7.4 / 7.7: Borang 4E row 2
-- "Jumlah papan lapis yang dijual dalam pasaran tempatan" must equal the buyer table total
-- (the blue "Jumlah"). Database: eshuttle_training.
--
-- Why: row 2 used to be typed by the kilang separately, so it was blank or different from the
-- buyer rows (e.g. shuttle 2041 Mac: blank vs 80 m3). The form now fills it from the buyer
-- table; this aligns the 2026 forms already submitted.
--
-- Scope: 2026 forms already submitted, ids frozen below. Buyer rows are not changed.
--   row 2:          3136,3241,3244,3247,3250,4069,4072,4075,4078,3394,3316,3319
--   report figure:  3394 (Lulus, no IPJPSM correction; report copy was 0, buyers 279.14)
-- =====================================================================================

-- preview
SELECT e.id, e.shuttle_id, e.bulan, e.status,
       e.jumlah_pasaran_tempatan AS baris_2,
       (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id) AS jumlah_pembeli,
       e.jumlah_pasaran_tempatan_laporan AS laporan,
       (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan_laporan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id) AS jumlah_pembeli_laporan
FROM form4_e_s e
WHERE e.id IN (3136,3241,3244,3247,3250,4069,4072,4075,4078,3394,3316,3319);

-- 1. row 2 = buyer table total
UPDATE form4_e_s e
SET e.jumlah_pasaran_tempatan = (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id),
    e.updated_at = NOW()
WHERE e.id IN (3136,3241,3244,3247,3250,4069,4072,4075,4078,3394,3316,3319);

-- 2. certified form without an IPJPSM correction: its report figure = buyer report figures
UPDATE form4_e_s e
SET e.jumlah_pasaran_tempatan_laporan = (SELECT ROUND(COALESCE(SUM(pp.jumlah_jualan_laporan), 0), 2) FROM penjualan_pembelis pp WHERE pp.form4es_id = e.id),
    e.updated_at = NOW()
WHERE e.id IN (3394) AND e.status = 'Lulus' AND COALESCE(e.jumlah_pasaran_tempatan_cleaning, 0) = 0;

-- after
SELECT e.id, e.status, e.jumlah_pasaran_tempatan, e.jumlah_pasaran_tempatan_laporan
FROM form4_e_s e
WHERE e.id IN (3136,3241,3244,3247,3250,4069,4072,4075,4078,3394,3316,3319);
