# Update Checklist (do these in order)

This is for updating the live server with the latest code. Follow the steps **in this exact
order**. Each step is a command you type and run. Wait for each one to finish before going to the
next.

Open a terminal on the server, go to the project folder, then go through the checklist.

---

### ☐ Step 1 — Get the latest code

```bash
git pull
composer install --no-dev --optimize-autoloader
```

If the production server does NOT use `git pull` (i.e. you upload files manually via FTP/file
manager), see **"Files to Upload"** at the bottom of this document instead of running `git pull`.

---

### ☐ Step 2 — Update the database structure

```bash
php artisan migrate
```

This is required before Step 3. Skipping this will make Step 3 fail with a database error.

---

### ☐ Step 3 — Fix/clean up existing data

```bash
php artisan db:seed --class=NormalizeAllSeeder
```

Just let it run, it will print progress messages. This fixes formatting issues in company
registration numbers, login IDs, and district/state data.

---

### ☐ Step 4 — Fix one specific company's data

```bash
php artisan db:seed --class=FixYeohKokEngDaerahSeeder
```

This corrects the district/state for one company ("Yeoh Kok Eng"). Safe to run even if already
run before.

---

### ☐ Step 5 — Preview the Form C totals fix (no changes yet)

```bash
php artisan formc:repair-tiada-pengeluaran
```

This just **shows** what it would fix. Read the output. If it says `Forms affected: 0`, you can
skip Step 6 — there's nothing to fix.

---

### ☐ Step 6 — Apply the Form C totals fix

Only do this if Step 5 showed forms that need fixing.

```bash
php artisan formc:repair-tiada-pengeluaran --apply
```

---

### ☐ Step 7 — Fix premature FormB Q4 2026 records

```bash
php artisan db:seed --class=FixFormBYear2026Q4Seeder
```

The system auto-creates all 4 quarters when a factory is approved, including Q4 (Oct-Dec) even
when it is only mid-year. This seeder deletes the empty "Tidak Diisi" Q4 2026 placeholders and
moves any filled records that belong to Q4 2025 across correctly.

Expected output: some DELETEs and MOVEs. "Skipped" lines mean conflicts handled in Step 8.

---

### ☐ Step 8 — Resolve remaining Q4 2026 conflict records

```bash
php artisan db:seed --class=FixFormBConflictsSeeder
```

Handles the records that Step 7 could not automatically resolve:
- If Q4 2025 was empty for that factory → moves data there (Case A).
- If Q4 2025 was already filled → the Q4 2026 record is a duplicate; deletes it along with its
  linked workforce (`guna_tenagas`) and review (`ulasan_phds`) data (Case B).

Any "SKIP" lines in the output need manual review.

---

### ☐ Step 10 — Clear old cached files

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

This makes sure the website uses the new pages/forms instead of old cached versions. Without
this, users may see errors or the old version of the forms.

---

## If something goes wrong

- **Step 2 (migrate) fails**: don't continue to Step 3. Take a screenshot of the error and ask for help.
- **Step 3 shows "already taken" / SKIP warnings**: that's normal, it just means that record was already fine. No action needed.
- **Step 6 was run by mistake with nothing to fix**: harmless, it just does nothing.

## Things that are NOT needed this time

- No need to run `npm install` or rebuild front-end assets.
- No need to change anything in the `.env` file.

---

## Files to Upload (only if NOT using `git pull`)

If you update the production server by uploading files manually, upload **everything below**.
Folders/files marked **NEW** don't exist on the server yet — make sure they're created, not
skipped.

### Brand new files (must be added, not just replaced)

```
app/Console/Commands/RepairTiadaPengeluaranTotals.php
app/Http/Controllers/ShuttleFive/FormCController.php
app/Http/Livewire/ShuttleFive/FormCKayuKKB.php
app/Http/Livewire/ShuttleFive/FormCKayuKKR.php
app/Http/Livewire/ShuttleFive/FormCKayuKKS.php
app/Http/Livewire/ShuttleFive/FormCKayuKayuLainLain.php
app/Http/Livewire/ShuttleFive/FormCKayuKayuLembut.php
database/migrations/2026_06_10_000001_change_no_ssm_unique_to_composite_on_shuttles.php
database/seeders/FixShuttleDaerahNegeriIdSeeder.php
database/seeders/FixFormBYear2026Q4Seeder.php
database/seeders/FixFormBConflictsSeeder.php
database/seeders/FixYeohKokEngDaerahSeeder.php
database/seeders/NormalizeSsmLoginIdSeeder.php
database/seeders/RevertShuttleDaerahNegeriIdSeeder.php
resources/views/admins/shuttle-five/FormC/shuttle-5-formC-KKB.blade.php
resources/views/admins/shuttle-five/FormC/shuttle-5-formC-KKR.blade.php
resources/views/admins/shuttle-five/FormC/shuttle-5-formC-KKS.blade.php
resources/views/admins/shuttle-five/FormC/shuttle-5-formC-KayuLembut.blade.php
resources/views/admins/shuttle-five/FormC/shuttle-5-formC-LainLain.blade.php
resources/views/livewire/shuttle-five/form-c-kayu-k-k-b.blade.php
resources/views/livewire/shuttle-five/form-c-kayu-k-k-r.blade.php
resources/views/livewire/shuttle-five/form-c-kayu-k-k-s.blade.php
resources/views/livewire/shuttle-five/form-c-kayu-kayu-lain-lain.blade.php
resources/views/livewire/shuttle-five/form-c-kayu-kayu-lembut.blade.php
resources/views/partials/form-status-cell.blade.php
```

### Existing files that changed (replace the old ones on the server)

```
database/seeders/NormalizeAllSeeder.php
public/.htaccess
routes/web.php
resources/
app/Models/User.php
app/Http/Controllers/UserController.php
app/Http/Controllers/Batch/PhdController.php
app/Http/Controllers/NotifikasiKilangController.php
app/Http/Controllers/ShuttleFive/ListOverallController.php
app/Http/Controllers/ShuttleFive/MainController.php
app/Http/Controllers/ShuttleFour/ListAController.php
app/Http/Controllers/ShuttleFour/ListBController.php
app/Http/Controllers/ShuttleFour/ListCController.php
app/Http/Controllers/ShuttleFour/ListDController.php
app/Http/Controllers/ShuttleFour/ListEController.php
app/Http/Controllers/ShuttleFour/MainController.php
app/Http/Controllers/ShuttleThree/ListAController.php
app/Http/Controllers/ShuttleThree/ListBController.php
app/Http/Controllers/ShuttleThree/ListCController.php
app/Http/Controllers/ShuttleThree/ListDController.php
app/Http/Controllers/ShuttleThree/MainController.php
```

After uploading all of the above, continue from **Step 2** in the checklist above.
