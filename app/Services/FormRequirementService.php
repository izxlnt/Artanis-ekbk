<?php

namespace App\Services;

use Carbon\Carbon;

class FormRequirementService
{
    /**
     * Determine which forms a user needs to fill based on their registration date
     * 
     * Rules:
     * 1. Users registered in current year (2026) only fill forms from registration month onwards
     * 2. Users registered in previous year (2025) fill from registration quarter onwards for 2025, then all 2026 forms
     * 3. Users registered in 2024 or earlier must fill ALL forms for 2025 and 2026
     * 
     * @param Carbon $registrationDate - User's created_at date
     * @param int $currentYear - Current year (default: current year)
     * @return array - Array with form requirements
     */
    public static function getRequiredForms($registrationDate, $currentYear = null)
    {
        $currentYear = $currentYear ?? date('Y');
        $registrationYear = $registrationDate->year;
        $registrationMonth = $registrationDate->month;
        $registrationQuarter = ceil($registrationMonth / 3);

        $requirements = [
            'current_year' => $currentYear,
            'registration_year' => $registrationYear,
            'registration_month' => $registrationMonth,
            'registration_quarter' => $registrationQuarter,
            'years_to_fill' => [],
            'months_to_fill' => [],
            'quarters_to_fill' => [],
            'forma_required' => [],
            'formb_required' => [],
            'formc_d_e_required' => [],
            'message' => '',
        ];

        // Rule 4: Registered 2024 or earlier - Fill ALL forms for 2025 and current year
        if ($registrationYear <= ($currentYear - 2)) {
            $requirements['years_to_fill'] = [$currentYear - 1, $currentYear];
            $requirements['months_to_fill'] = [
                $currentYear - 1 => range(1, 12),
                $currentYear => range(1, 12)
            ];
            $requirements['quarters_to_fill'] = [
                $currentYear - 1 => [1, 2, 3, 4],
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['forma_required'] = [$currentYear - 1, $currentYear];
            $requirements['formb_required'] = [
                $currentYear - 1 => [1, 2, 3, 4],
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['formc_d_e_required'] = [
                $currentYear - 1 => range(1, 12),
                $currentYear => range(1, 12)
            ];
            $requirements['message'] = "Anda perlu mengisi SEMUA borang untuk tahun " . ($currentYear - 1) . " dan " . $currentYear;
        }
        // Rule 2: Registered in previous year (2025) - Fill from registration quarter onwards for 2025, then all 2026
        elseif ($registrationYear == ($currentYear - 1)) {
            $requirements['years_to_fill'] = [$currentYear - 1, $currentYear];
            
            // For previous year: from registration quarter onwards
            $prevYearQuarters = range($registrationQuarter, 4);
            $prevYearMonths = [];
            foreach ($prevYearQuarters as $quarter) {
                $startMonth = ($quarter - 1) * 3 + 1;
                $endMonth = $quarter * 3;
                $prevYearMonths = array_merge($prevYearMonths, range($startMonth, $endMonth));
            }
            
            $requirements['months_to_fill'] = [
                $currentYear - 1 => $prevYearMonths,
                $currentYear => range(1, 12)
            ];
            $requirements['quarters_to_fill'] = [
                $currentYear - 1 => $prevYearQuarters,
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['forma_required'] = [$currentYear - 1, $currentYear];
            $requirements['formb_required'] = [
                $currentYear - 1 => $prevYearQuarters,
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['formc_d_e_required'] = [
                $currentYear - 1 => $prevYearMonths,
                $currentYear => range(1, 12)
            ];
            $requirements['message'] = "Anda perlu mengisi borang dari Suku " . $registrationQuarter . " tahun " . ($currentYear - 1) . " dan SEMUA borang untuk tahun " . $currentYear;
        }
        // Rule 1 & 3: Registered in current year - Fill ALL forms from January of current year
        elseif ($registrationYear == $currentYear) {
            $requirements['years_to_fill'] = [$currentYear];
            $requirements['months_to_fill'] = [
                $currentYear => range(1, 12)
            ];
            $requirements['quarters_to_fill'] = [
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['forma_required'] = [$currentYear];
            $requirements['formb_required'] = [
                $currentYear => [1, 2, 3, 4]
            ];
            $requirements['formc_d_e_required'] = [
                $currentYear => range(1, 12)
            ];
            $requirements['message'] = "Anda perlu mengisi SEMUA borang untuk tahun " . $currentYear;
        }

        return $requirements;
    }

    /**
     * Check if a specific FormA is required for a user
     */
    public static function isFormARequired($registrationDate, $formYear)
    {
        $requirements = self::getRequiredForms($registrationDate);
        return in_array($formYear, $requirements['forma_required']);
    }

    /**
     * Check if a specific FormB (quarter) is required for a user
     */
    public static function isFormBRequired($registrationDate, $formYear, $quarter)
    {
        $requirements = self::getRequiredForms($registrationDate);
        
        if (!isset($requirements['formb_required'][$formYear])) {
            return false;
        }
        
        return in_array($quarter, $requirements['formb_required'][$formYear]);
    }

    /**
     * Check if a specific FormC/D/E (month) is required for a user
     */
    public static function isFormCDERequired($registrationDate, $formYear, $month)
    {
        $requirements = self::getRequiredForms($registrationDate);
        
        if (!isset($requirements['formc_d_e_required'][$formYear])) {
            return false;
        }
        
        return in_array($month, $requirements['formc_d_e_required'][$formYear]);
    }

    /**
     * Get month name in Malay
     */
    private static function getMonthName($month)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];
        return $months[$month] ?? '';
    }

    /**
     * Get quarter name in Malay
     */
    public static function getQuarterName($quarter)
    {
        return "Suku " . $quarter;
    }

    /**
     * Get dashboard task list for user - Only show forms that are due or overdue
     */
    public static function getDashboardTasks($user, $currentYear = null)
    {
        $currentYear = $currentYear ?? date('Y');
        $currentMonth = (int) date('n'); // Current month (1-12)
        $currentQuarter = ceil($currentMonth / 3); // Current quarter (1-4)
        
        $registrationDate = Carbon::parse($user->created_at);
        $requirements = self::getRequiredForms($registrationDate, $currentYear);
        $shuttleType = $user->shuttle->shuttle_type ?? 3;
        
        $tasks = [];
        
        // Process all years that have requirements (2025 and 2026)
        foreach ($requirements['years_to_fill'] as $year) {
            
            // FormA tasks - Yearly form, always show if required (no month/quarter restriction)
            // Form A can be filled anytime during or after the year
            if (in_array($year, $requirements['forma_required'])) {
                // Show FormA for past years OR if we're in current year
                // Form A is available throughout the entire year
                if ($year <= $currentYear) {
                    $formA = \App\Models\FormA::where('shuttle_id', $user->shuttle_id)
                        ->where('tahun', $year)
                        ->first();
                    
                    $tasks[] = [
                        'form_name' => "BORANG A - TAHUN $year",
                        'description' => "Penyata Tahunan Pengeluaran Balak - Tahun $year",
                        'completed' => $formA ? ($formA->status != 'Tidak Diisi') : false,
                        'year' => $year,
                        'period' => null,
                        'shuttle_type' => $shuttleType,
                    ];
                }
            }

            // FormB tasks (Quarterly) for each year
            // Only show when the quarter has ENDED (last month of quarter has passed)
            if (!empty($requirements['quarters_to_fill'][$year])) {
                foreach ($requirements['quarters_to_fill'][$year] as $quarter) {
                    // Calculate last month of the quarter
                    // Q1 = March (3), Q2 = June (6), Q3 = September (9), Q4 = December (12)
                    $quarterLastMonth = $quarter * 3;
                    
                    $shouldShow = false;

                    if ($year < $currentYear) {
                        $shouldShow = true;
                    } elseif ($year == $currentYear && $currentMonth >= $quarterLastMonth) {
                        $shouldShow = true;
                    }

                    if ($shouldShow) {
                        $formB = \App\Models\FormB::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('suku_tahun', $quarter)
                            ->first();
                        
                        $quarterMonths = [
                            1 => 'Januari - Mac',
                            2 => 'April - Jun',
                            3 => 'Julai - September',
                            4 => 'Oktober - Disember',
                        ];
                        
                        $tasks[] = [
                            'form_name' => "BORANG B - SUKU TAHUN $quarter, $year",
                            'description' => $quarterMonths[$quarter] . " $year",
                            'completed' => $formB ? ($formB->status != 'Tidak Diisi') : false,
                            'year' => $year,
                            'quarter' => $quarter,
                            'shuttle_type' => $shuttleType,
                        ];
                    }
                }
            }

            // FormC/D/E tasks (Monthly) for each year
            // Only show when the month has PASSED
            if (!empty($requirements['months_to_fill'][$year])) {
                foreach ($requirements['months_to_fill'][$year] as $month) {
                    $shouldShow = false;
                    
                    $shouldShow = false;

                    if ($year < $currentYear) {
                        $shouldShow = true;
                    } elseif ($year == $currentYear && $currentMonth >= $month) {
                        $shouldShow = true;
                    }

                    if ($shouldShow) {
                        $formC = \App\Models\FormC::where('shuttle_id', $user->shuttle_id)
                            ->where('tahun', $year)
                            ->where('bulan', $month)
                            ->first();
                        
                        $tasks[] = [
                            'form_name' => "BORANG C - " . strtoupper(self::getMonthName($month)) . " $year",
                            'description' => "Penyata Bulanan - " . self::getMonthName($month),
                            'completed' => $formC ? ($formC->status != 'Tidak Diisi') : false,
                            'year' => $year,
                            'month' => $month,
                            'shuttle_type' => $shuttleType,
                        ];
                    }
                }
            }
        }

        // Incomplete tasks first, completed tasks last
        usort($tasks, fn($a, $b) => $a['completed'] <=> $b['completed']);

        return $tasks;
    }
}
