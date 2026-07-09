<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Read-only smoke test intended to run against a database seeded with REAL
 * production data: logs in as actual production users (IBK per shuttle type,
 * PHD, BPE/IPJPSM, JPN) and renders every major listing page for the current
 * data year, asserting none of them crash (HTTP 5xx). Skips gracefully when
 * the matching users don't exist (e.g. an empty dev database).
 *
 * DatabaseTransactions matters even though these are GETs — some listing
 * pages auto-create missing month rows for the viewed year.
 */
class ProdDataListingSmokeTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        // All pages render inside ONE php process here (unlike production's
        // request-per-process), so memory accumulates across the ~50 pages.
        // Raise the limit so only a genuinely runaway single page can fail.
        ini_set('memory_limit', '1G');
    }

    private function year(): int
    {
        return (int) config('app.data_start_year');
    }

    private function assertPageDoesNotCrash(User $user, string $routeName, array $params, string $context): void
    {
        if (!Route::has($routeName)) {
            return; // route doesn't exist in this app version — nothing to check
        }
        $response = $this->actingAs($user)->get(route($routeName, $params));
        $this->assertLessThan(500, $response->status(),
            "{$context}: route {$routeName} returned HTTP {$response->status()} for real user #{$user->id}.");
    }

    /** @test */
    public function real_ibk_users_can_render_their_senarai_pages()
    {
        $checked = 0;
        foreach (['3', '4', '5'] as $type) {
            $user = User::where('kategori_pengguna', 'IBK')
                ->where('status', 1)->where('is_approved', 1)
                ->whereHas('shuttle', fn ($q) => $q->where('shuttle_type', $type))
                ->first();
            if (!$user) {
                continue;
            }
            $checked++;

            $pages = ['A', 'B', 'C', 'D'];
            if (in_array($type, ['4', '5'], true)) {
                $pages[] = 'E';
            }
            foreach ($pages as $p) {
                $this->assertPageDoesNotCrash($user, "user.shuttle-{$type}-senarai{$p}", [$this->year()], "IBK shuttle {$type}");
            }
            $this->assertPageDoesNotCrash($user, 'home-user', [], "IBK shuttle {$type} home");
        }

        if ($checked === 0) {
            $this->markTestSkipped('No real IBK users in this database — load production data to run this smoke test.');
        }
    }

    /** @test */
    public function real_phd_user_can_render_every_tugasan_and_list_page()
    {
        $user = User::where('kategori_pengguna', 'PHD')
            ->where('status', 1)->where('is_approved', 1)
            ->whereNotNull('daerah')
            ->first()
            ?? User::where('kategori_pengguna', 'PHD')->where('status', 1)->first();
        if (!$user) {
            $this->markTestSkipped('No real PHD users in this database.');
        }

        foreach (['3A', '3B', '3C', '3D', '4A', '4B', '4C', '4D', '4E', '5A', '5B', '5C', '5D', '5E'] as $page) {
            $this->assertPageDoesNotCrash($user, "phd.senarai-tugasan-{$page}", [$this->year()], 'PHD tugasan');
        }
        foreach (['3', '4', '5'] as $type) {
            foreach (['A', 'B', 'C', 'D', 'E'] as $p) {
                $this->assertPageDoesNotCrash($user, "phd.shuttle-{$type}-list{$p}", [$this->year()], 'PHD list');
            }
        }
    }

    /** @test */
    public function real_bpe_user_can_render_every_ipjpsm_list_page()
    {
        $user = User::where('kategori_pengguna', 'BPE')->where('status', 1)->first();
        if (!$user) {
            $this->markTestSkipped('No real BPE users in this database.');
        }

        foreach (['3', '4', '5'] as $type) {
            foreach (['A', 'B', 'C', 'D', 'E'] as $p) {
                $this->assertPageDoesNotCrash($user, "shuttle-{$type}-list{$p}", [$this->year()], 'BPE/IPJPSM list');
            }
        }
    }

    /** @test */
    public function real_jpn_user_can_render_every_jpn_list_page()
    {
        $user = User::where('kategori_pengguna', 'JPN')->where('status', 1)->first();
        if (!$user) {
            $this->markTestSkipped('No real JPN users in this database.');
        }

        foreach (['3', '4', '5'] as $type) {
            foreach (['A', 'B', 'C', 'D', 'E'] as $p) {
                $this->assertPageDoesNotCrash($user, "jpn.shuttle-{$type}-list{$p}-jpn", [$this->year()], 'JPN list');
            }
        }
        $this->assertPageDoesNotCrash($user, 'jpn.senarai-tugasan', [], 'JPN tugasan');
    }
}
