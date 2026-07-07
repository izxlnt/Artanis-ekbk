<?php

namespace Tests\Unit;

use App\Services\FormFlowService;
use App\Services\FormRequirementService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class JulyFlowTest extends TestCase
{
    public function test_current_year_registration_starts_from_january_for_all_monthly_forms(): void
    {
        $registrationDate = Carbon::parse('2026-01-14');

        $requirements = FormRequirementService::getRequiredForms($registrationDate, 2026);

        $this->assertSame([2026], $requirements['years_to_fill']);
        $this->assertSame([1, 2, 3, 4], $requirements['quarters_to_fill'][2026]);
        $this->assertSame(range(1, 12), $requirements['months_to_fill'][2026]);
        $this->assertSame([2026], $requirements['forma_required']);
        $this->assertSame([1, 2, 3, 4], $requirements['formb_required'][2026]);
        $this->assertSame(range(1, 12), $requirements['formc_d_e_required'][2026]);
        $this->assertTrue(FormRequirementService::isFormBRequired($registrationDate, 2026, 1));
        $this->assertFalse(FormRequirementService::isFormBRequired($registrationDate, 2026, 5));
        $this->assertTrue(FormRequirementService::isFormCDERequired($registrationDate, 2026, 1));
        $this->assertTrue(FormRequirementService::isFormCDERequired($registrationDate, 2026, 7));
        $this->assertSame(3, FormFlowService::monthToSuku(7));
    }

    public function test_january_form_c_can_open_without_a_previous_month_in_the_same_year(): void
    {
        $checker = new ReflectionMethod(FormFlowService::class, 'checkFormC');
        $checker->setAccessible(true);

        [$canFill, $reason, $dateBlocked] = $checker->invoke(
            null,
            true,
            true,
            1,
            true,
            1,
            null,
            false,
            '2026-01-07',
            null
        );

        $this->assertTrue($canFill);
        $this->assertNull($reason);
        $this->assertFalse($dateBlocked);

        [$blockedCanFill, $blockedReason, $blockedDateBlocked] = $checker->invoke(
            null,
            true,
            true,
            1,
            true,
            2,
            null,
            false,
            '2026-01-07',
            null
        );

        $this->assertFalse($blockedCanFill);
        $this->assertSame('Borang C bulan ini belum dibuka.', $blockedReason);
        $this->assertTrue($blockedDateBlocked);
    }

    public function test_form_b_q3_opens_in_july_for_current_year(): void
    {
        $checker = new ReflectionMethod(FormFlowService::class, 'checkFormB');
        $checker->setAccessible(true);

        $formB = new class {
            public string $status = 'Tidak Diisi';
            public ?string $tarikh_buka_borang = '2026-07-01';
            public ?string $tarikh_tutup_borang = '2026-10-01';
        };

        [$canFillInJuly, $julyReason, $julyDateBlocked] = $checker->invoke(
            null,
            true,
            $formB,
            false,
            '2026-07-07',
            null,
            3
        );

        $this->assertTrue($canFillInJuly);
        $this->assertNull($julyReason);
        $this->assertFalse($julyDateBlocked);

        [$canFillInJune, $juneReason, $juneDateBlocked] = $checker->invoke(
            null,
            true,
            $formB,
            false,
            '2026-06-30',
            null,
            3
        );

        $this->assertFalse($canFillInJune);
        $this->assertSame('Borang B suku ini belum dibuka.', $juneReason);
        $this->assertTrue($juneDateBlocked);
    }
}