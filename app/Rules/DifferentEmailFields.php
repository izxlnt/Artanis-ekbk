<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DifferentEmailFields implements Rule
{
    protected $otherField;
    protected $otherValue;

    /**
     * Create a new rule instance.
     *
     * @param string $otherField
     * @param mixed $otherValue
     */
    public function __construct($otherField, $otherValue)
    {
        $this->otherField = $otherField;
        $this->otherValue = $otherValue;
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
        // If either field is empty, allow it (other validation will handle required)
        if (empty($value) || empty($this->otherValue)) {
            return true;
        }

        // Compare emails case-insensitively
        return strtolower(trim($value)) !== strtolower(trim($this->otherValue));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email pengguna dan email kilang mesti berbeza. Sila gunakan alamat email yang berbeza.';
    }
}
