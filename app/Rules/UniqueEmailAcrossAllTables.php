<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailAcrossAllTables implements Rule
{
    protected $excludeId;
    protected $excludeTable;
    protected $excludeColumn;

    /**
     * Create a new rule instance.
     *
     * @param mixed $excludeId ID to exclude from validation (for updates)
     * @param string $excludeTable Table to exclude from validation
     * @param string $excludeColumn Column name to exclude from validation
     */
    public function __construct($excludeId = null, $excludeTable = null, $excludeColumn = 'email')
    {
        $this->excludeId = $excludeId;
        $this->excludeTable = $excludeTable;
        $this->excludeColumn = $excludeColumn;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Tables with email columns to check
        $tablesToCheck = [
            'users' => 'email',
            'pengguna_kilangs' => 'email',
            'shuttles' => 'email',
            'password_resets' => 'email'
        ];

        foreach ($tablesToCheck as $table => $column) {
            $query = DB::table($table)->where($column, $value);
            
            // If we're excluding a specific record (for updates)
            if ($this->excludeId && $this->excludeTable === $table) {
                $query->where('id', '!=', $this->excludeId);
            }
            
            // Check if email exists in this table
            if ($query->exists()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email ini telah digunakan dalam sistem. Sila pilih email yang lain.';
    }
}
