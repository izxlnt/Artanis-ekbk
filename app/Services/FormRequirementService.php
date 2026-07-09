<?php

namespace App\Services;

use Carbon\Carbon;

class FormRequirementService
{
    /**
     * Determine which forms a user needs to fill, focused on the current year only.
     *
     * Rule (confirmed 2026-07-08): regardless of registration date, every user's
     * required forms are always January–December of the CURRENT year. Previous-year
     * data is no longer required or auto-generated — if a user already filled
     * December of the previous year (through whatever means), Form C's own
     * carry-forward logic (FormFlowService) will still pick it up for January's
     * opening stock; if they didn't, January just starts fresh at zero. A user
     * who registers mid-year (e.g. August) still gets the full current-year
     * January–December requirement, not a partial one starting at their
     * registration month.
     *
     * @param Carbon $registrationDate - User's created_at date (kept for signature
     *                                   compatibility / reporting; no longer used
     *                                   to vary which years/months are required).
     * @param int $currentYear - Current year (default: current year)
     * @return array - Array with form requirements
     */
    public static function getRequiredForms($registrationDate, $currentYear = null)
    {
        $currentYear = $currentYear ?? date('Y');
        $registrationYear = $registrationDate->year;
        $registrationMonth = $registrationDate->month;
        $registrationQuarter = (int) ceil($registrationMonth / 3);

        return [
            'current_year' => $currentYear,
            'registration_year' => $registrationYear,
            'registration_month' => $registrationMonth,
            'registration_quarter' => $registrationQuarter,
            'years_to_fill' => [$currentYear],
            'months_to_fill' => [$currentYear => range(1, 12)],
            'quarters_to_fill' => [$currentYear => [1, 2, 3, 4]],
            'forma_required' => [$currentYear],
            'formb_required' => [$currentYear => [1, 2, 3, 4]],
            'formc_d_e_required' => [$currentYear => range(1, 12)],
            'message' => "Anda perlu mengisi SEMUA borang untuk tahun " . $currentYear,
        ];
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
            // Show once the quarter has STARTED so users can fill it early in the quarter
            if (!empty($requirements['quarters_to_fill'][$year])) {
                foreach ($requirements['quarters_to_fill'][$year] as $quarter) {
                    // Calculate first month of the quarter
                    // Q1 = January (1), Q2 = April (4), Q3 = July (7), Q4 = October (10)
                    $quarterStartMonth = (($quarter - 1) * 3) + 1;
                    
                    $shouldShow = false;

                    if ($year < $currentYear) {
                        $shouldShow = true;
                    } elseif ($year == $currentYear && $currentMonth >= $quarterStartMonth) {
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
