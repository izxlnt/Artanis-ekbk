-- =====================================================================================
-- eShuttle UAT - database-wide check (18 Oct 2026): Borang C whose opening stock (lajur 02) does
-- not match the previous month's closing stock (lajur 07). Database: eshuttle_training.
--
-- Found by checking all 2026 forms (not reported in the UAT papers):
--   LEE WAH SAWMILL (S3, 238)        Apr closes 11.20  -> Mei (Tiada Pengeluaran) saved with no stock rows
--   Sim Seng Huat Sdn Bhd (S5, 22)   Jan corrected 1 Jul (closes 4,905.26) after Feb was sent (opened 4,874.03)
--   SUJ PALLET (S3, 1876)            Feb closes 8.00   -> Mac (Tiada Pengeluaran) saved with no stock rows
--   RUMPUN MAKMUR (S3, 1933)         Mac closes 538.38 -> Apr opened with 0
--
-- The later month goes back to the kilang ("Tidak Lengkap") with its Borang D, the same as the
-- system now does automatically: reopened, its opening stock is reloaded from the previous month;
-- when PHD approves it again, the month after it is checked the same way. Nothing is deleted.
--
-- Ids frozen:  Borang C 35569, 36748, 41584, 46294
--              Borang D (S3) 29029, 34144, 38107   Borang 5D 3445
-- =====================================================================================

-- preview
SELECT c.id, s.nama_kilang, c.bulan, c.status, c.tiada_pengeluaran
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (35569, 36748, 41584, 46294);

-- 1. Borang C -> "Tidak Lengkap"
UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (35569, 36748, 41584, 46294)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Baki stok bulan lepas tidak sama dengan baki stok akhir Borang C bulan sebelumnya. Sila semak semula baki stok bulan lepas (lajur 02) dan hantar semula Borang C bulan ini.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (35569, 36748, 41584, 46294) AND c.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Baki stok bulan lepas tidak sama%');

-- 2. Borang D of the same months -> "Tidak Lengkap"
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

-- 3. those months' packages no longer have approved C / D (packages not yet sent to IPJPSM)
UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
SET b.borang_c = '0', b.borang_d = '0', b.updated_at = NOW()
WHERE c.id IN (35569, 36748, 41584, 46294) AND c.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';

-- after
SELECT c.id, c.shuttle_id, c.bulan, c.status FROM form_c_s c WHERE c.id IN (35569, 36748, 41584, 46294);
