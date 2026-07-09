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

    /**
     * Confirmed business rule (2026-07-08): regardless of registration date —
     * mid-year in the current year, or any year before it — every user's
     * required forms are always the full January–December of the CURRENT
     * year. Previous-year data is no longer auto-required.
     */
    public function test_requirements_always_target_only_the_current_year_regardless_of_registration_date(): void
    {
        $midYearRegistration = Carbon::parse('2026-08-20');
        $requirements = FormRequirementService::getRequiredForms($midYearRegistration, 2026);
        $this->assertSame([2026], $requirements['years_to_fill']);
        $this->assertSame(range(1, 12), $requirements['months_to_fill'][2026]);
        $this->assertSame([1, 2, 3, 4], $requirements['quarters_to_fill'][2026]);
        $this->assertArrayNotHasKey(2025, $requirements['months_to_fill']);

        $priorYearRegistration = Carbon::parse('2025-05-01');
        $requirements = FormRequirementService::getRequiredForms($priorYearRegistration, 2026);
        $this->assertSame([2026], $requirements['years_to_fill']);
        $this->assertSame(range(1, 12), $requirements['months_to_fill'][2026]);
        $this->assertArrayNotHasKey(2025, $requirements['months_to_fill']);

        $veryOldRegistration = Carbon::parse('2020-01-01');
        $requirements = FormRequirementService::getRequiredForms($veryOldRegistration, 2026);
        $this->assertSame([2026], $requirements['years_to_fill']);
        $this->assertSame(range(1, 12), $requirements['months_to_fill'][2026]);
        $this->assertArrayNotHasKey(2025, $requirements['months_to_fill']);
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

    /**
     * Confirmed business rule (2026-07-08): buffer/closing-date enforcement
     * is opt-in via the admin "Tetapan Buffer" toggle, OFF by default. With
     * it off (no Buffer row, or a row with aktif=false), a form must never
     * auto-close just because its tarikh_tutup_borang has passed. Only when
     * an admin explicitly activates the buffer does the closing date (plus
     * its delay) apply.
     */
    public function test_buffer_toggle_controls_whether_form_c_closes_after_its_closing_date(): void
    {
        $checker = new ReflectionMethod(FormFlowService::class, 'checkFormC');
        $checker->setAccessible(true);

        $formC = new class {
            public string $status = 'Tidak Diisi';
            public ?string $tarikh_buka_borang = '2026-04-01';
            public ?string $tarikh_tutup_borang = '2026-05-01';
        };

        // No buffer row at all (the default for a fresh install) — well past
        // April's closing date, must still be open.
        [$canFillNoBuffer] = $checker->invoke(null, true, true, 3, true, 4, $formC, false, '2026-05-10', null);
        $this->assertTrue($canFillNoBuffer, 'With no buffer row (buffer rules off by default), the form must never close due to date.');

        $inactiveBuffer = new class {
            public $aktif = false;
            public $delay = 0;
        };
        [$canFillInactiveBuffer] = $checker->invoke(null, true, true, 3, true, 4, $formC, false, '2026-05-10', $inactiveBuffer);
        $this->assertTrue($canFillInactiveBuffer, 'With buffer explicitly inactive, the form must never close due to date.');

        $activeBuffer = new class {
            public $aktif = true;
            public $delay = 0;
        };
        [$canFillActiveBufferPastClose, $reason, $dateBlocked] = $checker->invoke(null, true, true, 3, true, 4, $formC, false, '2026-05-10', $activeBuffer);
        $this->assertFalse($canFillActiveBufferPastClose, 'With buffer active and no delay, the form must close after its closing date.');
        $this->assertSame('Tempoh pengisian Borang C telah ditutup.', $reason);
        $this->assertTrue($dateBlocked);

        [$canFillActiveBufferBeforeClose] = $checker->invoke(null, true, true, 3, true, 4, $formC, false, '2026-04-15', $activeBuffer);
        $this->assertTrue($canFillActiveBufferBeforeClose, 'Before the closing date, the form must still be open even with buffer active.');
    }

    /**
     * Regression test for a reported production issue: "April was closed,
     * then May opened." Root cause: an earlier month's status reverting to
     * "Tidak Lengkap" (PHD sends it back for correction) made that earlier
     * month no longer count as "submitted", which retroactively blocked
     * every LATER month that had already been filled. A month that already
     * has its own non-"Tidak Diisi" record must stay reachable regardless of
     * what an earlier month's status becomes afterwards.
     */
    public function test_correcting_an_earlier_month_does_not_retroactively_lock_a_later_already_filled_month(): void
    {
        $checker = new ReflectionMethod(FormFlowService::class, 'checkFormC');
        $checker->setAccessible(true);

        // April's own record already exists and was submitted ("Lulus") —
        // but March (the previous month) just got sent back to "Tidak
        // Lengkap" by PHD, so prevCFilled/sukuSubmitted are now false.
        $aprilAlreadyFilled = new class {
            public string $status = 'Lulus';
            public ?string $tarikh_buka_borang = '2026-04-01';
            public ?string $tarikh_tutup_borang = '2026-04-30';
        };

        [$canFill, $reason, $dateBlocked] = $checker->invoke(
            null,
            true,   // formAFilled
            false,  // sukuSubmitted — false because March's correction affected this too, in a real scenario
            1,      // suku
            false,  // prevCFilled — false because March is now "Tidak Lengkap", not "submitted"
            4,      // month
            $aprilAlreadyFilled,
            false,  // isPrevYear
            '2026-05-05',
            null
        );

        $this->assertTrue($canFill, 'April must remain reachable once it already has its own record, regardless of prevCFilled/sukuSubmitted going false afterwards. Reason: ' . ($reason ?? 'none'));
        $this->assertNull($reason);
        $this->assertFalse($dateBlocked);
    }
}