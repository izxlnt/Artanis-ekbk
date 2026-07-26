<?php

namespace Tests\Feature;

use App\Services\LicenseService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * The link-based control panel (/system-control/{token}) is the primary
 * "button" for locking/unlocking without needing server/SSH access — gated
 * by CONTROL_PANEL_TOKEN rather than a login.
 */
class SystemControlPanelTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        app(LicenseService::class)->current()->update(['is_locked' => false]);
        Cache::flush();
    }

    private function token(): string
    {
        return config('app.control_panel_token');
    }

    /** @test */
    public function wrong_token_gets_a_plain_404()
    {
        $this->get('/system-control/not-the-real-token')->assertStatus(404);
    }

    /** @test */
    public function correct_token_shows_the_panel_with_unlocked_status()
    {
        $resp = $this->get('/system-control/' . $this->token());
        $resp->assertOk();
        $resp->assertSee('Sistem Aktif');
    }

    /** @test */
    public function panel_can_lock_the_system()
    {
        $this->post(route('system-control.lock', $this->token()), ['reason' => 'unit test'])
            ->assertRedirect(route('system-control.panel', $this->token()));

        $this->assertTrue(app(LicenseService::class)->isLocked());

        // Front door is now blocked...
        $this->get('/')->assertStatus(503);

        // ...but the panel itself still shows the current key.
        $panel = $this->get('/system-control/' . $this->token());
        $panel->assertSee('Sistem Dikunci');
        $panel->assertSee(app(LicenseService::class)->currentKey());
    }

    /** @test */
    public function panel_is_reachable_even_while_the_system_is_locked()
    {
        app(LicenseService::class)->lock('unit test');

        $this->get('/system-control/' . $this->token())->assertOk();
    }

    /** @test */
    public function panel_can_unlock_the_system_without_typing_the_key()
    {
        app(LicenseService::class)->lock('unit test');
        $this->assertTrue(app(LicenseService::class)->isLocked());

        $this->post(route('system-control.unlock', $this->token()))
            ->assertRedirect(route('system-control.panel', $this->token()))
            ->assertSessionHas('success');

        $this->assertFalse(app(LicenseService::class)->isLocked());
        $this->get('/')->assertOk();
    }

    /** @test */
    public function wrong_token_cannot_lock_or_unlock_either()
    {
        $this->post('/system-control/wrong-token/lock', ['reason' => 'x'])->assertStatus(404);
        $this->assertFalse(app(LicenseService::class)->isLocked());

        app(LicenseService::class)->lock('unit test');
        $this->post('/system-control/wrong-token/unlock')->assertStatus(404);
        $this->assertTrue(app(LicenseService::class)->isLocked());
    }
}
