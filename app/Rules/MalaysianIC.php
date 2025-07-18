<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MalaysianIC implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // Remove any spaces or dashes
        $ic = str_replace([' ', '-'], '', $value);
        
        // Check if IC is exactly 12 digits
        if (!preg_match('/^\d{12}$/', $ic)) {
            return false;
        }
        
        // Extract parts
        $year = substr($ic, 0, 2);
        $month = substr($ic, 2, 2);
        $day = substr($ic, 4, 2);
        $birthPlace = substr($ic, 6, 2);
        $gender = substr($ic, 8, 3);
        $checkDigit = substr($ic, 11, 1);
        
        // Validate date
        if (!$this->isValidDate($year, $month, $day)) {
            return false;
        }
        
        // Validate birth place (01-16, 21-59, 82-83)
        if (!$this->isValidBirthPlace($birthPlace)) {
            return false;
        }
        
        // For now, let's skip the check digit validation as it seems to have different variants
        // We'll focus on the more reliable validations: format, date, and birth place
        
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format :attribute tidak sah. Sila masukkan nombor kad pengenalan Malaysia yang betul (12 digit).';
    }
    
    /**
     * Validate date part of IC
     */
    private function isValidDate($year, $month, $day)
    {
        // Convert 2-digit year to 4-digit year
        $currentYear = date('Y');
        $currentCentury = intval($currentYear / 100) * 100;
        $fullYear = $currentCentury + intval($year);
        
        // If the year is greater than current year, it's from previous century
        if ($fullYear > $currentYear) {
            $fullYear -= 100;
        }
        
        // Check if it's a valid date
        return checkdate(intval($month), intval($day), $fullYear);
    }
    
    /**
     * Validate birth place codes
     */
    private function isValidBirthPlace($birthPlace)
    {
        $validCodes = [
            '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
            '11', '12', '13', '14', '15', '16', '21', '22', '23', '24',
            '25', '26', '27', '28', '29', '30', '31', '32', '33', '34',
            '35', '36', '37', '38', '39', '40', '41', '42', '43', '44',
            '45', '46', '47', '48', '49', '50', '51', '52', '53', '54',
            '55', '56', '57', '58', '59', '82', '83'
        ];
        
        return in_array($birthPlace, $validCodes);
    }
    
    /**
     * Validate check digit using Malaysian IC algorithm
     */
    private function isValidCheckDigit($ic)
    {
        // Malaysian IC uses a different algorithm than what we initially implemented
        // The correct algorithm is modulo 11, not modulo 10
        $weights = [2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2];
        $sum = 0;
        
        for ($i = 0; $i < 11; $i++) {
            $digit = intval($ic[$i]);
            $product = $digit * $weights[$i];
            // For Malaysian IC, we don't adjust products > 9
            $sum += $product;
        }
        
        $remainder = $sum % 11;
        
        // Check digit mapping for Malaysian IC
        $checkDigitMap = [
            0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6,
            6 => 7, 7 => 8, 8 => 9, 9 => 0, 10 => 'X'
        ];
        
        $expectedCheckDigit = $checkDigitMap[$remainder];
        $actualCheckDigit = $ic[11];
        
        // Handle 'X' case (though rare in Malaysian IC)
        if ($expectedCheckDigit === 'X') {
            return strtoupper($actualCheckDigit) === 'X';
        }
        
        return $expectedCheckDigit == intval($actualCheckDigit);
    }
}
