<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmailValidationService
{
    /**
     * Check if email is unique across all tables
     *
     * @param string $email
     * @param int|null $excludeId
     * @param string|null $excludeTable
     * @return bool
     */
    public static function isEmailUnique($email, $excludeId = null, $excludeTable = null)
    {
        $tablesToCheck = [
            'users' => 'email',
            'pengguna_kilangs' => 'email',
            'shuttles' => 'email',
            'password_resets' => 'email'
        ];

        foreach ($tablesToCheck as $table => $column) {
            $query = DB::table($table)->where($column, $email);
            
            // If we're excluding a specific record (for updates)
            if ($excludeId && $excludeTable === $table) {
                $query->where('id', '!=', $excludeId);
            }
            
            // Check if email exists in this table
            if ($query->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get all email occurrences across tables
     *
     * @param string $email
     * @return array
     */
    public static function getEmailOccurrences($email)
    {
        $tablesToCheck = [
            'users' => 'email',
            'pengguna_kilangs' => 'email',
            'shuttles' => 'email',
            'password_resets' => 'email'
        ];

        $occurrences = [];

        foreach ($tablesToCheck as $table => $column) {
            $count = DB::table($table)->where($column, $email)->count();
            if ($count > 0) {
                $occurrences[$table] = $count;
            }
        }

        return $occurrences;
    }

    /**
     * Check if emails are different from each other
     *
     * @param string $email1
     * @param string $email2
     * @return bool
     */
    public static function areEmailsDifferent($email1, $email2)
    {
        if (empty($email1) || empty($email2)) {
            return true; // Allow empty emails (other validation will handle required)
        }

        return strtolower(trim($email1)) !== strtolower(trim($email2));
    }

    /**
     * Get validation rules for email fields with different email check
     *
     * @param string $otherFieldName
     * @param mixed $otherFieldValue
     * @param int|null $excludeId
     * @param string|null $excludeTable
     * @return array
     */
    public static function getEmailValidationRulesWithDifferentCheck($otherFieldName, $otherFieldValue, $excludeId = null, $excludeTable = null)
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            new \App\Rules\UniqueEmailAcrossAllTables($excludeId, $excludeTable),
            new \App\Rules\DifferentEmailFields($otherFieldName, $otherFieldValue)
        ];
    }
}
