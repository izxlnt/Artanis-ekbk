-- =====================================================================================
-- eShuttle UAT - Shuttle 5 round 2 (15 Oct 2026): months filled after a month that is now empty.
-- Database: eshuttle_training.
--
-- Why: on 26 Jun 2026 April's Borang C of these two kilang was reset to "Tidak Diisi" and its
-- figures removed (direct database change, outside the system). May had already been sent, so
-- its opening stock (column 02) came from an April that no longer exists. May goes back to the
-- kilang ("Tidak Lengkap"); the system now only lets them open it after April is sent, and the
-- opening stock is then reloaded from April's closing stock.
--
-- Scope (ids frozen):
--   36973  Timbalabs (M) Sdn Bhd (shuttle 670)              Borang 5C Mei
--   35209  Sim Seng Huat Timber Industries (shuttle 1723)    Borang 5C Mei
-- Borang 5D of these months is not filled yet, so nothing else changes. Nothing is deleted.
-- Kilang registered during 2026 (12 Shuttle 3 kilang) are NOT included: their earlier months
-- are before registration and are not owed.
-- =====================================================================================

-- preview
SELECT c.id, s.nama_kilang, c.bulan, c.status
FROM form_c_s c JOIN shuttles s ON s.id = c.shuttle_id
WHERE c.id IN (36973, 35209);

-- 1. Borang C Mei -> "Tidak Lengkap"
UPDATE form_c_s
SET status = 'Tidak Lengkap', updated_at = NOW()
WHERE id IN (36973, 35209)
  AND status IN ('Sedang Diproses', 'Tiada Pengeluaran', 'Dihantar ke IPJPSM', 'Lulus');

-- 2. note shown to the kilang on the reopened form
INSERT INTO ulasan_phds (ulasan, user_id, formcs_id, created_at, updated_at)
SELECT 'Borang C April belum diisi. Sila isi dan hantar Borang C April dahulu, kemudian semak semula baki stok bulan lepas dan hantar semula Borang C Mei.', NULL, c.id, NOW(), NOW()
FROM form_c_s c
WHERE c.id IN (36973, 35209) AND c.status = 'Tidak Lengkap'
  AND NOT EXISTS (SELECT 1 FROM ulasan_phds u WHERE u.formcs_id = c.id AND u.ulasan LIKE 'Borang C April belum diisi%');

-- 3. the May package no longer has an approved Borang C (not sent to IPJPSM yet)
UPDATE batches b
JOIN form_c_s c ON c.shuttle_id = b.shuttle_id AND c.tahun = b.tahun AND c.bulan = b.bulan
SET b.borang_c = '0', b.updated_at = NOW()
WHERE c.id IN (36973, 35209) AND c.status = 'Tidak Lengkap' AND b.status <> 'Dihantar ke IPJPSM';

-- after
SELECT c.id, c.shuttle_id, c.bulan, c.status FROM form_c_s c WHERE c.id IN (36973, 35209);
