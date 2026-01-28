# Form Requirement System Implementation

## Overview
This document describes the implementation of a registration-based form requirement system for the Artanis EKBK application. The system ensures users only fill forms that are required based on their registration date.

## Business Rules

### Rule 1: Current Year Registration (2026)
- Users registered in 2026 fill forms from their registration month onwards
- Example: User registered in February 2026 fills forms from February to December 2026

### Rule 2: Previous Year Registration (2025)
- Users registered in 2025 fill forms from their registration quarter onwards for 2025
- Plus ALL forms for 2026
- Example: User registered June 2025 (Q2) fills Q2-Q4 2025 + All 2026

### Rule 3: Registration Before 2025
- Users registered in 2024 or earlier fill ALL 2025 forms and ALL 2026 forms

## Implementation Components

### 1. FormRequirementService
**Location:** `app/Services/FormRequirementService.php`

**Purpose:** Centralized service to calculate required forms based on user registration date

**Key Methods:**
- `getRequiredForms($registrationDate, $currentYear)` - Main logic to determine required forms
- `isFormARequired($registrationDate, $formYear)` - Validate if FormA is required
- `isFormBRequired($registrationDate, $formYear, $quarter)` - Validate if FormB quarter is required
- `isFormCDERequired($registrationDate, $formYear, $month)` - Validate if monthly forms are required
- `getDashboardTasks($user, $currentYear)` - Generate task list for dashboard display

**Returns:**
```php
[
    'years_to_fill' => [2025, 2026],
    'months_to_fill' => [
        2025 => [6, 7, 8, 9, 10, 11, 12],
        2026 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    ],
    'quarters_to_fill' => [
        2025 => [2, 3, 4],
        2026 => [1, 2, 3, 4]
    ],
    'forma_required' => true,
    'formb_required' => true,
    'formc_d_e_required' => true
]
```

### 2. UserController Updates
**Location:** `app/Http/Controllers/UserController.php`

**Changes:**
- Import FormRequirementService
- Initialize service in `index_user()` method
- Get required forms based on user registration date
- Create only required Batch, FormA, FormB, FormC records
- Pass `$tugasan` to view for dashboard display

**Form Creation Logic:**
```php
// Get requirements
$formRequirementService = new FormRequirementService();
$requirements = $formRequirementService->getRequiredForms($user->created_at, $currentYear);
$tugasan = $formRequirementService->getDashboardTasks($user, $currentYear);

// Create only required Batch records
foreach ($requirements['months_to_fill'][$currentYear] as $month) {
    Batch::create([...]);
}

// Create FormA only if required
if ($requirements['forma_required']) {
    FormA::create([...]);
}

// Create only required FormB quarters
foreach ($requirements['quarters_to_fill'][$currentYear] as $quarter) {
    FormB::create([...]);
}

// Create only required FormC months
foreach ($requirements['months_to_fill'][$currentYear] as $month) {
    FormC::create([...]);
}
```

### 3. Dashboard View Updates
**Location:** `resources/views/home-user.blade.php`

**Changes:**
- Display required tasks from `$tugasan` variable
- Show completion status with color coding
- Green badges for completed forms
- Yellow badges for incomplete forms
- Include pengumuman (announcements) below tasks

**Task Display Format:**
```blade
@foreach($tugasan as $task)
<div class="list-group-item {{ $task['completed'] ? 'list-group-item-success' : 'list-group-item-warning' }}">
    <h6>
        @if($task['completed'])
            <i class="fas fa-check-circle text-success"></i>
        @else
            <i class="fas fa-exclamation-circle text-warning"></i>
        @endif
        {{ $task['form_name'] }}
    </h6>
    <p>{{ $task['description'] }}</p>
    <span class="badge {{ $task['completed'] ? 'badge-success' : 'badge-warning' }}">
        {{ $task['completed'] ? 'SELESAI' : 'BELUM SELESAI' }}
    </span>
</div>
@endforeach
```

## Form Types

### FormA (Yearly)
- One form per year
- Required for users based on registration year

### FormB (Quarterly)
- 4 quarters per year (Q1-Q4)
- Quarter 1: January-March
- Quarter 2: April-June
- Quarter 3: July-September
- Quarter 4: October-December

### FormC, FormD, FormE (Monthly)
- 12 months per year
- One form per month

## Example Scenarios

### Scenario 1: User registered February 15, 2026
**Required Forms:**
- Batch: February-December 2026 (11 months)
- FormA: 2026
- FormB: Q1-Q4 2026 (4 quarters)
- FormC/D/E: February-December 2026 (11 months)

### Scenario 2: User registered June 10, 2025
**Required Forms:**
- 2025:
  - Batch: June-December 2025 (7 months)
  - FormB: Q2, Q3, Q4 2025 (3 quarters)
  - FormC/D/E: June-December 2025 (7 months)
- 2026:
  - Batch: January-December 2026 (12 months)
  - FormA: 2026
  - FormB: Q1-Q4 2026 (4 quarters)
  - FormC/D/E: January-December 2026 (12 months)

### Scenario 3: User registered November 5, 2024
**Required Forms:**
- 2025:
  - Batch: January-December 2025 (12 months)
  - FormB: Q1-Q4 2025 (4 quarters)
  - FormC/D/E: January-December 2025 (12 months)
- 2026:
  - Batch: January-December 2026 (12 months)
  - FormA: 2026
  - FormB: Q1-Q4 2026 (4 quarters)
  - FormC/D/E: January-December 2026 (12 months)

## Dashboard Task Examples

### Task Structure:
```php
[
    'form_name' => 'BORANG A - TAHUN 2026',
    'description' => 'Penyata Tahunan Pengeluaran Balak',
    'completed' => false,
    'year' => 2026,
    'period' => null
]
```

### Quarter Task:
```php
[
    'form_name' => 'BORANG B - SUKU TAHUN 1, 2026',
    'description' => 'Januari - Mac 2026',
    'completed' => true,
    'year' => 2026,
    'quarter' => 1
]
```

### Monthly Task:
```php
[
    'form_name' => 'BORANG C - FEBRUARI 2026',
    'description' => 'Penyata Bulanan - Februari',
    'completed' => false,
    'year' => 2026,
    'month' => 2
]
```

## Testing Recommendations

1. **Test Current Year Registration**
   - Create user with registration date in current year (2026)
   - Verify only months from registration month onwards are created
   - Check dashboard shows correct tasks

2. **Test Previous Year Registration**
   - Create user with registration date in 2025
   - Verify correct quarters for 2025
   - Verify all months for 2026

3. **Test Old Registration**
   - Create user with registration date in 2024 or earlier
   - Verify all 2025 and 2026 forms are created

4. **Test Dashboard Display**
   - Check task list shows all required forms
   - Verify completion status is accurate
   - Test color coding (green for complete, yellow for incomplete)

## Next Steps

1. **Add Form Access Validation**
   - Create middleware to prevent unauthorized form access
   - Validate form access in controllers before displaying forms

2. **Extend to Shuttle 4 and 5**
   - Apply same logic to Form4A, Form4B, Form4C, Form4D, Form4E
   - Apply same logic to Form5A, Form5B, Form5C, Form5D, Form5E

3. **Add Previous Year Forms**
   - Implement creation of required forms for previous years (e.g., 2025)
   - Currently only handles current year (2026)

4. **Create Form Access Middleware**
   - Prevent users from accessing forms they shouldn't fill
   - Show error message when trying to access non-required forms

## Files Modified

1. `app/Services/FormRequirementService.php` - NEW
2. `app/Http/Controllers/UserController.php` - MODIFIED
3. `resources/views/home-user.blade.php` - MODIFIED

## Benefits

1. **Efficient Database Usage** - Only required forms are created
2. **Clear User Guidance** - Dashboard shows exactly what needs to be filled
3. **Prevents Confusion** - Users don't see unnecessary forms
4. **Accurate Reporting** - Only relevant data is collected
5. **Flexible Business Rules** - Easy to modify requirements in service class

## Maintenance Notes

- All business logic is centralized in `FormRequirementService`
- To change requirements, update the service class methods
- Dashboard tasks are automatically generated based on requirements
- Form creation is now registration-date-aware
