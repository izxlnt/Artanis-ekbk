<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\LicenseService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Verifies the payment/access lock is absolute: unlike maintenance mode,
 * nothing exempts a client's own admin, and only a key derived from
 * LICENSE_SECRET (via LicenseService) can restore access.
 */
class SystemLicenseLockTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        // Start every test from a known, unlocked baseline regardless of
        // whatever the real dev DB's current state happens to be.
        app(LicenseService::class)->current()->update(['is_locked' => false]);
        // The throttle limiter shares the in-memory array cache across every
        // test method in this process — flush it so one test's failed
        // attempts never count against a later, unrelated test.
        Cache::flush();
        // These tests exercise the key-based flow, so force a known secret
        // regardless of whatever the real .env currently has (it may well
        // be unset — LICENSE_SECRET is optional and the panel doesn't need
        // it at all, see SystemControlPanelTest for that scenario).
        config(['app.license_secret' => 'test-secret-for-license-lock-suite']);
    }

    /** @test */
    public function system_is_accessible_when_unlocked()
    {
        $this->get('/')->assertOk();
    }

    /** @test */
    public function locking_blocks_requests_with_the_locked_page()
    {
        app(LicenseService::class)->lock('unit test');

        $resp = $this->get('/');
        $resp->assertStatus(503);
        $resp->assertSee('Sistem Tidak Dapat Diakses');
    }

    /** @test */
    public function even_a_client_admin_bpe_user_is_blocked_unlike_maintenance_mode()
    {
        $bpe = User::where('kategori_pengguna', 'BPE')->first();
        $this->assertNotNull($bpe, 'Sanity: need a real BPE user to prove no exemption exists.');

        app(LicenseService::class)->lock('unit test');

        $this->actingAs($bpe)->get(route('home'))->assertStatus(503);
    }

    /** @test */
    public function wrong_key_does_not_unlock()
    {
        app(LicenseService::class)->lock('unit test');

        $this->post(route('system-locked.unlock'), ['unlock_key' => 'WRONG-WRONG-WRONG-WRON'])
            ->assertSessionHasErrors('unlock_key');

        $this->assertTrue(app(LicenseService::class)->isLocked(), 'Wrong key must not unlock the system.');
    }

    /** @test */
    public function correct_key_unlocks_and_restores_access()
    {
        $key = app(LicenseService::class)->lock('unit test');

        $this->get('/')->assertStatus(503); // sanity: really locked first

        $this->post(route('system-locked.unlock'), ['unlock_key' => $key])
            ->assertRedirect('/')
            ->assertSessionHas('success');

        $this->assertFalse(app(LicenseService::class)->isLocked());
        $this->get('/')->assertOk();
    }

    /** @test */
    public function a_key_from_one_lock_event_does_not_work_for_a_later_lock_event()
    {
        $service = app(LicenseService::class);

        $firstKey = $service->lock('first lock');
        $this->assertTrue($service->unlock($firstKey), 'Sanity: the first key must unlock the first lock.');

        $service->lock('second lock');
        $this->assertFalse($service->unlock($firstKey), 'A key from a previous lock event must not work on a new one.');
    }

    /** @test */
    public function license_key_command_reprints_the_same_key_without_relocking()
    {
        $service = app(LicenseService::class);
        $key = $service->lock('unit test');

        // Calling currentKey() again (what `php artisan license:key` does)
        // must return the identical key, and must not rotate the nonce.
        $this->assertSame($key, $service->currentKey());
        $this->assertSame($key, $service->currentKey());
    }

    /** @test */
    public function repeated_wrong_attempts_are_rate_limited()
    {
        app(LicenseService::class)->lock('unit test');

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('system-locked.unlock'), ['unlock_key' => 'WRONG'])
                ->assertSessionHasErrors('unlock_key');
        }

        // 6th attempt within the throttle window should be rate limited (429).
        $this->post(route('system-locked.unlock'), ['unlock_key' => 'WRONG'])
            ->assertStatus(429);
    }

    /**
     * LICENSE_SECRET is optional — a developer without full server access
     * (or who simply never sets it) must still be able to lock and unlock
     * entirely via the control panel. Confirmed for real: this dev .env
     * currently has it commented out and everything below still works.
     */
    /** @test */
    public function locking_still_works_with_no_license_secret_configured()
    {
        config(['app.license_secret' => null]);
        $service = app(LicenseService::class);

        $key = $service->lock('no secret configured');

        $this->assertNull($key, 'No secret means no public key can be derived.');
        $this->assertTrue($service->isLocked(), 'Locking itself must still succeed without a secret.');
    }

    /** @test */
    public function locked_page_hides_the_code_form_when_no_secret_is_configured()
    {
        config(['app.license_secret' => null]);
        app(LicenseService::class)->lock('no secret configured');

        $resp = $this->get('/');
        $resp->assertStatus(503);
        $resp->assertDontSee('name="unlock_key"', false);
    }

    /** @test */
    public function public_unlock_route_fails_gracefully_with_no_secret_configured()
    {
        config(['app.license_secret' => null]);
        app(LicenseService::class)->lock('no secret configured');

        // Even the correct-looking format can't possibly be valid with no
        // secret to derive against — must fail cleanly, not error.
        $this->post(route('system-locked.unlock'), ['unlock_key' => 'AAAA-BBBB-CCCC-DDDD'])
            ->assertSessionHasErrors('unlock_key');

        $this->assertTrue(app(LicenseService::class)->isLocked());
    }

    /** @test */
    public function force_unlock_works_with_no_secret_configured()
    {
        config(['app.license_secret' => null]);
        $service = app(LicenseService::class);
        $service->lock('no secret configured');

        $service->forceUnlock();

        $this->assertFalse($service->isLocked());
        $this->get('/')->assertOk();
    }
}
