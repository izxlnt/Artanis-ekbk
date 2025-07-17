# Email Uniqueness Validation System

## Overview
This system ensures that all email addresses are unique across all tables in the database, preventing duplicate email registrations that could cause conflicts or security issues.

## Features

### 1. Custom Validation Rules
- **File**: `app/Rules/UniqueEmailAcrossAllTables.php`
- **Purpose**: Validates email uniqueness across multiple database tables
- **Tables checked**: `users`, `pengguna_kilangs`, `shuttles`, `password_resets`
- **Supports**: Update exclusions (for editing existing records)

- **File**: `app/Rules/DifferentEmailFields.php`
- **Purpose**: Ensures that user email and factory email are different within the same registration
- **Validation**: Case-insensitive email comparison
- **Error Message**: "Email pengguna dan email kilang mesti berbeza. Sila gunakan alamat email yang berbeza."

### 2. Email Validation Service
- **File**: `app/Services/EmailValidationService.php`
- **Purpose**: Centralized email validation logic
- **Methods**:
  - `isEmailUnique()`: Check if email is unique across all tables
  - `getEmailOccurrences()`: Get count of email occurrences per table
  - `areEmailsDifferent()`: Check if two emails are different
  - `getEmailValidationRules()`: Get validation rules for email fields
  - `getEmailValidationRulesWithDifferentCheck()`: Get validation rules with different email check

### 3. Real-time AJAX Validation
- **File**: `public/js/email-validation.js`
- **Purpose**: Client-side real-time email validation
- **Features**:
  - Debounced input checking (500ms delay)
  - Visual feedback (red for duplicate, green for unique)
  - Error message display
  - **NEW**: Checks that user email and factory email are different
  - **NEW**: Validates both uniqueness and field difference in real-time

### 4. AJAX Controller
- **File**: `app/Http/Controllers/EmailValidationController.php`
- **Routes**:
  - `POST /check-email-uniqueness`: Check email uniqueness
  - `POST /get-email-occurrences`: Get email occurrence details

### 5. Middleware Protection
- **File**: `app/Http/Middleware/CheckEmailUniqueness.php`
- **Purpose**: Double-check email uniqueness and field differences before processing requests
- **Features**:
  - Validates email uniqueness across all tables
  - **NEW**: Ensures user email and factory email are different
  - Can be applied to registration routes for extra protection

### 6. Duplicate Detection Command
- **File**: `app/Console/Commands/CheckDuplicateEmails.php`
- **Command**: `php artisan email:check-duplicates`
- **Purpose**: Check existing database for duplicate emails
- **Features**:
  - Detects cross-table email duplicates
  - **NEW**: Detects same email used for both user and factory in single registration
  - Comprehensive reporting of all email conflicts

## Updated Controllers

### RegisterController
- **File**: `app/Http/Controllers/Auth/RegisterController.php`
- **Changes**:
  - Added `UniqueEmailAcrossAllTables` rule to both `email` and `email_kilang` fields
  - **NEW**: Added `DifferentEmailFields` rule to ensure user and factory emails are different
  - Applied to both validation scenarios (with and without `alamat_sama`)
  - Cross-validation between `email` and `email_kilang` fields

### DaftarController
- **File**: `app/Http/Controllers/DaftarController.php`
- **Changes**:
  - Added `UniqueEmailAcrossAllTables` rule to email validation
  - Applied to both PHD and JPN user registration

## Frontend Updates

### Register Blade Template
- **File**: `resources/views/auth/register.blade.php`
- **Changes**:
  - Added CSRF token meta tag
  - Included email validation JavaScript
  - Fixed email field types to use `type="email"`
  - Fixed `email_kilang` field to use correct old value

## Database Tables with Email Fields

1. **users** - `email` column
2. **pengguna_kilangs** - `email` column
3. **shuttles** - `email` column
4. **password_resets** - `email` column

## Installation Steps

1. **Check for existing duplicates**:
   ```bash
   php artisan email:check-duplicates
   ```

2. **Clear any existing duplicates** (if found):
   - Review the duplicate report
   - Manually clean up duplicates in the database
   - Run the command again to ensure no duplicates remain

3. **Test the validation**:
   - Try registering with an existing email
   - Should see validation error: "Email ini telah digunakan dalam sistem. Sila pilih email yang lain."

4. **Optional: Add middleware to routes**:
   ```php
   Route::post('/register', [RegisterController::class, 'register'])
       ->middleware('check.email.uniqueness');
   ```

## Error Messages

- **Malay**: "Email ini telah digunakan dalam sistem. Sila pilih email yang lain."
- **English**: "This email has been used in the system. Please choose another email."

## Benefits

1. **Data Integrity**: Prevents duplicate emails across all tables
2. **User Experience**: Real-time feedback during registration
3. **Security**: Prevents account conflicts and potential security issues
4. **Maintainability**: Centralized validation logic
5. **Flexibility**: Easy to add more tables or modify validation rules
6. **⭐ NEW**: **Field Separation**: Ensures user and factory emails are always different
7. **⭐ NEW**: **Comprehensive Validation**: Validates both uniqueness and field differences simultaneously

## Usage Examples

### Backend Validation
```php
// In any controller
use App\Rules\UniqueEmailAcrossAllTables;

$validator = Validator::make($data, [
    'email' => ['required', 'email', new UniqueEmailAcrossAllTables()]
]);
```

### Service Usage
```php
// Check if email is unique
use App\Services\EmailValidationService;

if (EmailValidationService::isEmailUnique($email)) {
    // Email is unique, proceed
} else {
    // Email exists, show error
}
```

### Frontend JavaScript
```javascript
// The JavaScript automatically handles real-time validation
// for inputs with names 'email' and 'email_kilang'
```

## Testing

Test the following scenarios:

1. **Factory Registration**: Try using an existing email for both user email and factory email
2. **PHD/JPN Registration**: Try using an existing email
3. **Real-time Validation**: Type an existing email and see immediate feedback
4. **Cross-table Validation**: Use an email from one table in another table's registration
5. **⭐ NEW**: **Same Email in Both Fields**: Try using the same email for both user and factory email
6. **⭐ NEW**: **Case Sensitivity**: Try using the same email with different cases (should still be detected)
7. **⭐ NEW**: **Real-time Field Difference**: Type the same email in both fields and see immediate feedback

## Maintenance

- **Adding new tables**: Update the `$tablesToCheck` array in `UniqueEmailAcrossAllTables.php` and `EmailValidationService.php`
- **Updating error messages**: Modify the `message()` method in the validation rule
- **Performance**: Consider adding database indexes on email columns for better performance
