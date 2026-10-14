-- =====================================================================================
-- eShuttle UAT - UAT Shuttle 3 round 2 (14 Oct 2026), item 6.1: Borang D must follow its
-- Borang C. Database: eshuttle_training.
--
-- Why: before 14 Oct 2026, sending Borang C back to the kilang ("Tidak Lengkap") left the
-- same month's Borang D submitted. The kilang could then never correct D (D needs its C
-- submitted first) and PHD still saw D waiting / approved for a month whose C is open.
-- The code now sends D back together with C; this fixes the months already in that state.
--
-- Scope: 2026 only, D still submitted while its same-month C is not submitted. The ids are
-- frozen below so re-running can never widen the scope:
--   Shuttle 3: 30529 (shuttle 16, Jan), 33121 (850, Jan), 28165 (391 Heang Lee, May),
--              28489 (580, May), 35302 (328, May)
--   Shuttle 5: 3811 (1849, Apr), 4318 (1915, May)  - C was never filled
-- Earlier years (2024/2025) are certified history and are left alone.
--
-- Nothing is deleted: D figures stay on the form and are shown again when the kilang
-- re-opens it after re-submitting C.
-- =====================================================================================

-- preview
SELECT 'S3' AS shuttle, d.id, s.nama_kilang, d.bulan, d.status AS status_d, c.status AS status_c
FROM form_d_s d JOIN shuttles s ON s.id = d.shuttle_id
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
WHERE d.id IN (30529,33121,28165,28489,35302)
UNION ALL
SELECT 'S5', d.id, s.nama_kilang, d.bulan, d.status, c.status
FROM form5_d_s d JOIN shuttles s ON s.id = d.shuttle_id
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
WHERE d.id IN (3811,4318);

-- 1. Borang D -> "Tidak Lengkap" (only while its C is still not submitted)
UPDATE form_d_s d
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
SET d.status = 'Tidak Lengkap', d.updated_at = NOW()
WHERE d.id IN (30529,33121,28165,28489,35302)
  AND d.status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM')
  AND c.status IN ('Tidak Lengkap', 'Sedang Diisi', 'Tidak Diisi');

UPDATE form5_d_s d
JOIN form_c_s c ON c.shuttle_id = d.shuttle_id AND c.tahun = d.tahun AND c.bulan = d.bulan
SET d.status = 'Tidak Lengkap', d.updated_at = NOW()
WHERE d.id IN (3811,4318)
  AND d.status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM')
  AND c.status IN ('Tidak Lengkap', 'Sedang Diisi', 'Tidak Diisi');

-- 2. note shown to the kilang on the reopened D (same wording the system now uses)
INSERT INTO ulasan_phds (ulasan, user_id, formds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form_d_s d
WHERE d.id IN (30529,33121,28165,28489,35302) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

INSERT INTO ulasan_phds (ulasan, user_id, form5ds_id, created_at, updated_at)
SELECT 'Borang C bulan ini dikembalikan untuk pembetulan. Sila hantar semula Borang C, kemudian semak dan hantar semula Borang D.', NULL, d.id, NOW(), NOW()
FROM form5_d_s d
WHERE d.id IN (3811,4318) AND d.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.form5ds_id = d.id AND u.ulasan LIKE 'Borang C bulan ini dikembalikan%');

-- 3. the month's package no longer has an approved D
UPDATE batches b
JOIN form_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.borang_d = '0', b.updated_at = NOW()
WHERE d.id IN (30529,33121,28165,28489,35302) AND d.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';

UPDATE batches b
JOIN form5_d_s d ON d.shuttle_id = b.shuttle_id AND d.tahun = b.tahun AND d.bulan = b.bulan
SET b.borang_d = '0', b.updated_at = NOW()
WHERE d.id IN (3811,4318) AND d.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';

-- after
SELECT 'S3' AS shuttle, d.id, d.shuttle_id, d.bulan, d.status FROM form_d_s d WHERE d.id IN (30529,33121,28165,28489,35302)
UNION ALL
SELECT 'S5', d.id, d.shuttle_id, d.bulan, d.status FROM form5_d_s d WHERE d.id IN (3811,4318);
