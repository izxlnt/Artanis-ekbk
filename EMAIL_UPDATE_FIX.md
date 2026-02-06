# Email Update Fix - Resolving SSM and IC Email Conflict

## Issue Description

When updating emails for factory users, both the factory SSM ID and individual user IC were getting the same email address. This was happening across all user roles (IPJPSM, PHD, JPN, and factory users).

## Root Cause

The email update logic was incorrectly updating all three email storage locations (`users`, `pengguna_kilangs`, and `shuttles` tables) regardless of the user type. This caused:

1. **Factory Email Updates** (`updateEmailKilang`) - Were updating both Shuttle email AND PenggunaKilang email
2. **Individual User Email Updates** (`updateEmailPengguna`) - Were updating both PenggunaKilang email AND Shuttle email
3. **Government User Email Updates** (`updateEmailPhd`, `updateEmailJpn`, `updateEmailIpjpsm`) - Were incorrectly attempting to update PenggunaKilang and Shuttle emails

## Database Structure

The system has three types of users with different email storage:

### 1. Factory Users (login_id = SSM number)
- Email stored in: `users.email` + `shuttles.email`
- Does NOT have: `pengguna_kilang_id` (or it's null)
- Has: `shuttle_id` pointing to factory

### 2. Individual Users (login_id = IC number)
- Email stored in: `users.email` + `pengguna_kilangs.email`
- Has: `pengguna_kilang_id` pointing to their personal info
- Has: `shuttle_id` pointing to their factory

### 3. Government Users (PHD, JPN, IPJPSM)
- Email stored in: `users.email` only
- Does NOT have: `pengguna_kilang_id` or `shuttle_id`

## Solution Implemented

### Files Modified:

1. **app/Http/Controllers/PengurusanPengguna/MainController.php**
   - `updateEmailKilang()` - Now only updates `users.email` + `shuttles.email`
   - `updateEmailPengguna()` - Now only updates `users.email` + `pengguna_kilangs.email`

2. **app/Http/Controllers/AdminController.php**
   - `update_emel_kilang()` - Now only updates `users.email` + `shuttles.email`
   - `update_emel_pengguna()` - Now only updates `users.email` + `pengguna_kilangs.email`
   - `update_emel_phd()` - Now only updates `users.email`
   - `update_emel_jpn()` - Now only updates `users.email`
   - `update_emel_ipjpsm()` - Now only updates `users.email`

## Changes Summary

### Before Fix:
```php
// updateEmailKilang - WRONG: Updated both PenggunaKilang and Shuttle
updateEmailKilang() {
    users.email = new_email
    pengguna_kilangs.email = new_email  // ❌ Should NOT update
    shuttles.email = new_email
}

// updateEmailPengguna - WRONG: Updated both PenggunaKilang and Shuttle
updateEmailPengguna() {
    users.email = new_email
    pengguna_kilangs.email = new_email
    shuttles.email = new_email  // ❌ Should NOT update
}
```

### After Fix:
```php
// updateEmailKilang - CORRECT: Only updates User and Shuttle
updateEmailKilang() {
    users.email = new_email
    shuttles.email = new_email
    // ✓ Does NOT update pengguna_kilangs
}

// updateEmailPengguna - CORRECT: Only updates User and PenggunaKilang
updateEmailPengguna() {
    users.email = new_email
    pengguna_kilangs.email = new_email
    // ✓ Does NOT update shuttles
}

// updateEmailPhd/Jpn/Ipjpsm - CORRECT: Only updates User
updateEmailPhd() {
    users.email = new_email
    // ✓ Does NOT update pengguna_kilangs or shuttles
}
```

## Expected Behavior After Fix

1. **When updating Factory Email (Emel Kilang)**:
   - Updates the factory user's login email (`users.email`)
   - Updates the factory's email (`shuttles.email`)
   - Does NOT affect individual users' personal emails (`pengguna_kilangs.email`)

2. **When updating Individual User Email (Emel Pengguna)**:
   - Updates the user's login email (`users.email`)
   - Updates the user's personal email (`pengguna_kilangs.email`)
   - Does NOT affect the factory's email (`shuttles.email`)

3. **When updating Government User Email (PHD/JPN/IPJPSM)**:
   - Updates only the user's login email (`users.email`)
   - Does NOT attempt to update factory or personal info tables

## Testing Recommendations

1. Test updating factory email - verify that individual users' emails remain unchanged
2. Test updating individual user email - verify that factory email remains unchanged
3. Test updating government user email - verify no errors occur
4. Verify email uniqueness validation still works across all tables
5. Check that `getCurrentEmail()` method still returns correct email for each user type

## Date Resolved
February 6, 2026
