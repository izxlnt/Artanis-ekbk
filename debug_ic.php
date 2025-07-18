<?php

require_once 'vendor/autoload.php';

use App\Rules\MalaysianIC;

$ic = '970920025823';
echo "Testing IC: $ic\n";

// Break down the IC
$year = substr($ic, 0, 2);
$month = substr($ic, 2, 2);
$day = substr($ic, 4, 2);
$birthPlace = substr($ic, 6, 2);
$gender = substr($ic, 8, 3);
$checkDigit = substr($ic, 11, 1);

echo "Year: $year\n";
echo "Month: $month\n";
echo "Day: $day\n";
echo "Birth Place: $birthPlace\n";
echo "Gender: $gender\n";
echo "Check Digit: $checkDigit\n";

// Check date validity
$currentYear = date('Y');
$currentCentury = intval($currentYear / 100) * 100;
$fullYear = $currentCentury + intval($year);

if ($fullYear > $currentYear) {
    $fullYear -= 100;
}

echo "Full Year: $fullYear\n";

$isValidDate = checkdate(intval($month), intval($day), $fullYear);
echo "Is Valid Date: " . ($isValidDate ? 'YES' : 'NO') . "\n";

// Check birth place
$validCodes = [
    '01', '02', '03', '04', '05', '06', '07', '08', '09', '10',
    '11', '12', '13', '14', '15', '16', '21', '22', '23', '24',
    '25', '26', '27', '28', '29', '30', '31', '32', '33', '34',
    '35', '36', '37', '38', '39', '40', '41', '42', '43', '44',
    '45', '46', '47', '48', '49', '50', '51', '52', '53', '54',
    '55', '56', '57', '58', '59', '82', '83'
];

$isValidBirthPlace = in_array($birthPlace, $validCodes);
echo "Is Valid Birth Place: " . ($isValidBirthPlace ? 'YES' : 'NO') . "\n";

// Check digit validation - Updated algorithm
$weights = [2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2];
$sum = 0;

for ($i = 0; $i < 11; $i++) {
    $digit = intval($ic[$i]);
    $product = $digit * $weights[$i];
    $sum += $product; // No adjustment for products > 9
    echo "Position $i: digit=$digit, weight={$weights[$i]}, product=$product\n";
}

echo "Sum: $sum\n";
$remainder = $sum % 11;
echo "Remainder: $remainder\n";

// Check digit mapping for Malaysian IC
$checkDigitMap = [
    0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6,
    6 => 7, 7 => 8, 8 => 9, 9 => 0, 10 => 'X'
];

$expectedCheckDigit = $checkDigitMap[$remainder];
echo "Expected Check Digit: $expectedCheckDigit\n";
echo "Actual Check Digit: $checkDigit\n";
echo "Check Digit Valid: " . ($expectedCheckDigit == intval($checkDigit) ? 'YES' : 'NO') . "\n";

// Final test
$rule = new MalaysianIC();
echo "Overall Result: " . ($rule->passes('test', $ic) ? 'VALID' : 'INVALID') . "\n";
