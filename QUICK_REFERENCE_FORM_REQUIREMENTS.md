# Quick Reference: Form Requirement System

## How It Works

### 1. User Registration Date Determines Required Forms
```
Registration in 2026 → Fill from registration month onwards
Registration in 2025 → Fill from registration quarter for 2025 + all 2026
Registration ≤ 2024 → Fill all 2025 + all 2026
```

### 2. Dashboard Shows Required Tasks
- Visit: `http://127.0.0.1:8000/pengguna/halaman-utama`
- "SENARAI TUGASAN" section displays:
  - ✅ Green = Completed forms
  - ⚠️ Yellow = Incomplete forms
  - Form name, description, and status

### 3. Only Required Forms are Created
- System automatically creates only necessary forms
- No manual selection needed
- Forms appear when user logs in for the first time each year

## Testing the System

### Test User Scenarios

#### Scenario A: New User (Registered Feb 2026)
```bash
# Expected Results:
- FormA 2026: YES
- FormB 2026: Q1, Q2, Q3, Q4
- FormC/D/E 2026: Feb-Dec (11 months)
- Batch 2026: Feb-Dec (11 months)
```

#### Scenario B: 2025 User (Registered Jun 2025)
```bash
# Expected Results 2025:
- FormB 2025: Q2, Q3, Q4
- FormC/D/E 2025: Jun-Dec (7 months)
- Batch 2025: Jun-Dec (7 months)

# Expected Results 2026:
- FormA 2026: YES
- FormB 2026: Q1, Q2, Q3, Q4
- FormC/D/E 2026: Jan-Dec (12 months)
- Batch 2026: Jan-Dec (12 months)
```

#### Scenario C: Old User (Registered Nov 2024)
```bash
# Expected Results 2025:
- FormB 2025: Q1, Q2, Q3, Q4
- FormC/D/E 2025: Jan-Dec (12 months)
- Batch 2025: Jan-Dec (12 months)

# Expected Results 2026:
- FormA 2026: YES
- FormB 2026: Q1, Q2, Q3, Q4
- FormC/D/E 2026: Jan-Dec (12 months)
- Batch 2026: Jan-Dec (12 months)
```

## Database Queries for Testing

### Check User Registration Date
```sql
SELECT id, name, email, created_at, shuttle_id 
FROM users 
WHERE id = [USER_ID];
```

### Check Created Forms for User
```sql
-- FormA (Yearly)
SELECT * FROM form_a 
WHERE shuttle_id = [SHUTTLE_ID] 
ORDER BY tahun DESC;

-- FormB (Quarterly)
SELECT * FROM form_b 
WHERE shuttle_id = [SHUTTLE_ID] 
ORDER BY tahun DESC, suku_tahun ASC;

-- FormC (Monthly)
SELECT * FROM form_c 
WHERE shuttle_id = [SHUTTLE_ID] 
ORDER BY tahun DESC, bulan ASC;

-- Batch (Monthly)
SELECT * FROM batch 
WHERE shuttle_id = [SHUTTLE_ID] 
ORDER BY tahun DESC, bulan ASC;
```

## Key Files

### Service Class (Business Logic)
```
app/Services/FormRequirementService.php
```

### Controller (Form Creation)
```
app/Http/Controllers/UserController.php
Method: index_user()
```

### View (Dashboard Display)
```
resources/views/home-user.blade.php
Section: SENARAI TUGASAN
```

## Common Tasks

### Change Current Year
Update in `UserController.php`:
```php
$currentYear = date("Y");  // Change to specific year if needed
```

### Modify Business Rules
Edit `FormRequirementService.php`:
- `getRequiredForms()` - Main logic
- `isFormARequired()` - FormA validation
- `isFormBRequired()` - FormB validation
- `isFormCDERequired()` - Monthly forms validation

### Customize Dashboard Display
Edit `home-user.blade.php`:
- Task list format
- Color coding
- Icons
- Layout

## Quarter Mapping
```
Q1: Months 1-3   (Jan-Mar)
Q2: Months 4-6   (Apr-Jun)
Q3: Months 7-9   (Jul-Sep)
Q4: Months 10-12 (Oct-Dec)
```

## Month Names (Malay)
```
1  = Januari    7  = Julai
2  = Februari   8  = Ogos
3  = Mac        9  = September
4  = April      10 = Oktober
5  = Mei        11 = November
6  = Jun        12 = Disember
```

## Form Types by Shuttle

### Shuttle 3 Forms:
- FormA (Yearly)
- FormB (Quarterly)
- FormC (Monthly)
- FormD (Monthly)

### Shuttle 4 Forms:
- Form4A (Yearly)
- Form4B (Quarterly)
- Form4C (Monthly)
- Form4D (Monthly)
- Form4E (Monthly)

### Shuttle 5 Forms:
- Form5A (Yearly)
- Form5B (Quarterly)
- Form5C (Monthly)
- Form5D (Monthly)
- Form5E (Monthly)

## Troubleshooting

### Forms Not Appearing
1. Check user registration date in database
2. Verify `$currentYear` matches expected year
3. Check FormRequirementService logic
4. Verify form creation in UserController

### Dashboard Not Showing Tasks
1. Check `$tugasan` is passed to view
2. Verify compact() includes 'tugasan'
3. Check getDashboardTasks() returns data
4. View blade syntax for errors

### Wrong Forms Created
1. Review getRequiredForms() output
2. Check quarter calculation logic
3. Verify month arrays in requirements
4. Test with known registration dates

## Next Implementation Steps

1. **Form Access Validation** - Prevent unauthorized access
2. **Shuttle 4 & 5 Support** - Extend to other shuttles
3. **Previous Year Forms** - Create 2025 forms for eligible users
4. **Middleware** - Add form access control
5. **Error Messages** - User-friendly messages for blocked access
