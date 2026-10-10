-- =====================================================================================
-- eShuttle UAT - Shuttle 5: send Borang 5C (and same-month 5D) back to the kilang for
-- re-verification. Database: eshuttle_training.
--
-- Why: until 27 Jul 2026 the Shuttle 5 Form C screens had no "Pengeluaran Kayu Kumai"
-- column (06). Forms saved then have output = 0, and their 5D was checked against the
-- processing-in column (05) instead of the output, so 5D totals do not match.
--
-- Scope (decided 10 Oct 2026): only the 22 affected Form C of 2026 (12 kilang), including
-- the one already approved by IPJPSM; PHD informs the kilang (no system notification).
-- The ids are frozen below so re-running can never widen the scope.
--
-- Nothing is deleted: all figures stay on the forms and are pre-filled when the kilang
-- opens them. Backup of every touched row: storage/app/backup/before_s5_formc_reverify_2026_10_10.json
-- =====================================================================================

-- preview: the 22 Form C and their current status
SELECT c.id, s.nama_kilang, c.bulan, c.status
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (38485,38488,34729,51010,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840);

-- 1. Borang 5C -> "Tidak Lengkap" (the kilang sees "Borang tidak lengkap" and can edit it)
UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (38485,38488,34729,51010,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

-- 2. reason shown to the kilang on the reopened form (latest review note)
INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Sila semak semula: lengkapkan lajur (06) Pengeluaran Kayu Kumai dan pastikan Borang 5D bulan yang sama sama dengan jumlah pengeluaran ini.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (38485,38488,34729,51010,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840)
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Sila semak semula: lengkapkan lajur (06)%');

-- 3. the submitted 5D of the same months -> "Tidak Lengkap" (its total must be re-entered to match 5C)
UPDATE form5_d_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (3814,3817,3262,4924,3451,3454,4702,4705,4102,4105,3700,3703,4381,4384,4387,4390,4393)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, form5ds_id, created_at, updated_at)
SELECT 'Sila semak semula: jumlah Borang 5D mestilah sama dengan Pengeluaran Kayu Kumai (lajur 06) Borang 5C bulan yang sama.', NULL, d.id, NOW(), NOW()
FROM form5_d_s d
WHERE d.id IN (3814,3817,3262,4924,3451,3454,4702,4705,4102,4105,3700,3703,4381,4384,4387,4390,4393)
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.form5ds_id = d.id AND u.ulasan LIKE 'Sila semak semula: jumlah Borang 5D%');

-- 4. monthly packages: C (and D) are no longer approved, so the month's package goes back to
--    "Sedang Diproses" and must be re-sent by PHD after re-approval
UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
LEFT JOIN form5_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.status = 'Sedang Diproses',
    b.borang_c = '0',
    b.borang_d = IF(d.status = 'Tidak Lengkap', '0', b.borang_d),
    b.updated_at = NOW()
WHERE c.id IN (38485,38488,34729,51010,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840);

-- check
SELECT c.id, s.nama_kilang, c.bulan, c.status AS c_status, d.status AS d_status, b.status AS pakej, b.borang_c, b.borang_d
FROM form_c_s c
JOIN shuttles s ON s.id = c.shuttle_id
LEFT JOIN form5_d_s d ON d.shuttle_id = c.shuttle_id AND d.tahun = c.tahun AND d.bulan = c.bulan
LEFT JOIN batches b ON b.shuttle_id = c.shuttle_id AND b.tahun = c.tahun AND b.bulan = c.bulan
WHERE c.id IN (38485,38488,34729,51010,50752,42922,42925,42418,36754,36757,50377,50380,43318,43321,36976,37759,37762,46828,46831,46834,46837,46840);
