<?php

namespace Tests\Feature;

use App\Models\Daerah;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormD;
use App\Models\HakMilik;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Regression coverage for two dashboard/list bugs reported from production:
 *
 * 1. The "Status Borang" (Senarai Tugasan) pages for Form A/B/D/E listed
 *    rows in raw DB order, so an item PHD still needs to act on ("Sedang
 *    Diproses") could be buried under already-resolved rows ("Lulus",
 *    "Dihantar ke IPJPSM"). Form C already sorted action-needed rows first;
 *    this extends the same ordering to the other list pages.
 *
 * 2. The PHD dashboard's pending-form counters (ajax_count_tugasan_phd_*)
 *    summed "Sedang Diproses"/"Tiada Pengeluaran" rows across every year,
 *    while the "Status Borang" pages they link to default to the current
 *    year only - so the badge number and the list a PHD lands on from it
 *    disagreed whenever a prior-year form was still stuck pending. Per
 *    product decision, the counters now scope to the current year to match
 *    what the linked list actually shows.
 */
class PhdStatusBorangPriorityAndYearScopeTest extends TestCase
{
    use DatabaseTransactions;

    private const YEAR = 2026;

    /** @test */
    public function status_borang_3b_lists_rows_needing_phd_action_before_resolved_ones()
    {
        $user = $this->makeIbkUser('3');
        $shuttle = $user->shuttle;
        $this->alignDaerah($shuttle, $phd = $this->makeReviewerUser('PHD'));

        $this->fillFormA($user, $shuttle);

        // Three quarters of the same year, in deliberately non-priority DB
        // insertion order, so a pass-through query would list them exactly
        // as inserted - only an explicit status-based sort would reorder them.
        FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'suku_tahun' => 1, 'status' => 'Lulus',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'LULUS-MARKER', 'no_lesen' => 'L1',
        ]);
        FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'suku_tahun' => 2, 'status' => 'Tidak Lengkap',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'INCOMPLETE-MARKER', 'no_lesen' => 'L2',
        ]);
        FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'suku_tahun' => 3, 'status' => 'Sedang Diproses',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'PENDING-MARKER', 'no_lesen' => 'L3',
        ]);

        $html = $this->actingAs($phd)->get(route('phd.senarai-tugasan-3B', self::YEAR))->assertOk()->getContent();

        $pendingPos = strpos($html, 'PENDING-MARKER');
        $incompletePos = strpos($html, 'INCOMPLETE-MARKER');
        $lulusPos = strpos($html, 'LULUS-MARKER');

        $this->assertNotFalse($pendingPos, 'Sedang Diproses row not found in Status Borang 3B.');
        $this->assertNotFalse($incompletePos, 'Tidak Lengkap row not found in Status Borang 3B.');
        $this->assertNotFalse($lulusPos, 'Lulus row not found in Status Borang 3B.');

        $this->assertLessThan($incompletePos, $pendingPos,
            'A form still needing PHD action (Sedang Diproses) must be listed above a Tidak Lengkap row.');
        $this->assertLessThan($lulusPos, $incompletePos,
            'A Tidak Lengkap row must be listed above an already-certified (Lulus) row.');
    }

    /** @test */
    public function phd_dashboard_pending_count_only_reflects_the_current_year()
    {
        $user = $this->makeIbkUser('3');
        $shuttle = $user->shuttle;
        $this->alignDaerah($shuttle, $phd = $this->makeReviewerUser('PHD'));

        $this->fillFormA($user, $shuttle); // 1 pending FormA, tahun = self::YEAR

        FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR,
            'suku_tahun' => 1, 'status' => 'Sedang Diproses',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'CURRENT', 'no_lesen' => 'L1',
        ]);
        // A form stuck pending from a much older year - must NOT inflate the
        // current-year badge, since the "Status Borang" page it links to
        // defaults to the current year and would never show this row.
        FormB::create([
            'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => 2020,
            'suku_tahun' => 1, 'status' => 'Sedang Diproses',
            'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'STALE', 'no_lesen' => 'L2',
        ]);

        $count = (int) $this->actingAs($phd)->get(route('ajax_count_tugasan_phd_shuttle3'))->assertOk()->getContent();

        // 1 (FormA, from fillFormA) + 1 (current-year FormB) - the 2020 FormB excluded.
        $this->assertSame(2, $count,
            'PHD shuttle-3 pending count must only include the current year, not prior-year backlog.');
    }

    /** @test */
    public function all_status_borang_list_pages_render_with_a_pending_row_for_every_shuttle_type()
    {
        foreach (['3', '4', '5'] as $shuttleType) {
            $user = $this->makeIbkUser($shuttleType);
            $shuttle = $user->shuttle;
            $this->alignDaerah($shuttle, $phd = $this->makeReviewerUser('PHD'));

            $this->fillFormA($user, $shuttle, $shuttleType);

            FormB::create([
                'shuttle_id' => $shuttle->id, 'shuttle_type' => $shuttleType, 'tahun' => self::YEAR,
                'suku_tahun' => 1, 'status' => 'Sedang Diproses',
                'nama_kilang' => $shuttle->nama_kilang, 'no_ssm' => 'B-' . $shuttleType, 'no_lesen' => 'L-' . $shuttleType,
            ]);

            $letters = ['3' => ['A', 'B', 'D'], '4' => ['A', 'B', 'D', 'E'], '5' => ['A', 'B', 'D', 'E']];

            if ($shuttleType === '3') {
                FormD::create([
                    'shuttle_id' => $shuttle->id, 'shuttle_type' => '3', 'tahun' => self::YEAR, 'bulan' => 1,
                    'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => 'D-3', 'no_lesen' => 'LD-3',
                ]);
            } elseif ($shuttleType === '4') {
                Form4D::create([
                    'shuttle_id' => $shuttle->id, 'shuttle_type' => '4', 'tahun' => self::YEAR, 'bulan' => 1,
                    'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => 'D-4', 'no_lesen' => 'LD-4',
                ]);
                Form4E::create([
                    'shuttle_id' => $shuttle->id, 'shuttle_type' => '4', 'tahun' => self::YEAR, 'bulan' => 1,
                    'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => 'E-4', 'no_lesen' => 'LE-4',
                ]);
            } else {
                Form5D::create([
                    'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR, 'bulan' => 1,
                    'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => 'D-5', 'no_lesen' => 'LD-5',
                ]);
                Form5E::create([
                    'shuttle_id' => $shuttle->id, 'shuttle_type' => '5', 'tahun' => self::YEAR, 'bulan' => 1,
                    'status' => 'Sedang Diproses', 'nama_kilang' => $shuttle->nama_kilang,
                    'no_ssm' => 'E-5', 'no_lesen' => 'LE-5',
                ]);
            }

            foreach ($letters[$shuttleType] as $letter) {
                $this->actingAs($phd)
                    ->get(route("phd.senarai-tugasan-{$shuttleType}{$letter}", self::YEAR))
                    ->assertOk();
            }
        }
    }

    private function makeIbkUser(string $shuttleType): User
    {
        $user = User::factory()->create([
            'kategori_pengguna' => 'IBK',
            'status' => 1,
            'is_approved' => 1,
        ]);
        $shuttle = $user->shuttle;
        $shuttle->update(['shuttle_type' => $shuttleType]);
        $user->shuttle_type = $shuttleType;
        $user->save();

        return $user->fresh();
    }

    private function makeReviewerUser(string $kategoriPengguna): User
    {
        $unique = uniqid();

        return User::create([
            'name' => $kategoriPengguna . ' Reviewer',
            'email' => strtolower($kategoriPengguna) . '-' . $unique . '@example.com',
            'login_id' => strtolower($kategoriPengguna) . '-' . $unique,
            'password' => Hash::make('password'),
            'kategori_pengguna' => $kategoriPengguna,
            'status' => 1,
            'is_approved' => 1,
        ]);
    }

    /**
     * PHD's list/count queries scope by daerah via User::daerah_ids, which
     * resolves the user's free-text `daerah` field against daerahs.daerah_hutan
     * and returns matching daerahs.id values - so the shuttle's daerah_id
     * and the PHD's daerah must be pointed at the same real daerahs row.
     */
    private function alignDaerah($shuttle, User $phd): void
    {
        $daerah = Daerah::firstOrFail();
        $shuttle->update(['daerah_id' => $daerah->id]);
        $phd->update(['daerah' => $daerah->daerah_hutan]);
    }

    private function fillFormA(User $user, $shuttle, string $shuttleType = '3'): void
    {
        $hakMilik = HakMilik::first();

        $this->actingAs($user)->get(route("user.shuttle-{$shuttleType}-formA"))->assertOk();

        $response = $this->actingAs($user)->post(route('update.formA', $shuttle->id), [
            'tahun' => self::YEAR,
            'alamat_surat_menyurat_poskod' => '50000',
            'alamat_surat_menyurat_daerah' => 'Kuala Lumpur',
            'no_telefon' => '0123456789',
            'no_ssm' => 'SSM-TEST-' . $shuttle->id,
            'tarikh_tubuh' => '2000-01-01',
            'tarikh_operasi' => '2000-01-01',
            'taraf_syarikat_catatan' => 'Syarikat Sendirian Berhad',
            'nilai_harta' => '100000',
            'email_kilang' => 'kilang' . $shuttle->id . '@example.com',
            'no_lesen' => 'LESEN-TEST-' . $shuttle->id,
            'status_hak_milik' => (string) $hakMilik->id,
            'status_warganegara' => 'Bumiputera',
        ]);
        $response->assertStatus(302)->assertSessionDoesntHaveErrors();

        $this->assertSame('Sedang Diproses', FormA::where('shuttle_id', $shuttle->id)->where('tahun', self::YEAR)->value('status'));
    }
}
