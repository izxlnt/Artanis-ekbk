<?php

namespace Tests\Feature;

use App\Services\LicenseService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * The code-based lock (app/license-lock.php) is the simplest mechanism:
 * edit the file, deploy, done — no .env, no database, no token. This test
 * writes to the real file temporarily and always restores it, even if an
 * assertion fails, so the actual dev environment is never left locked.
 */
class CodeBasedLicenseLockTest extends TestCase
{
    use DatabaseTransactions;

    private $filePath;
    private $originalContents;

    protected function setUp(): void
    {
        parent::setUp();
        app(LicenseService::class)->current()->update(['is_locked' => false]);
        Cache::flush();

        $this->filePath = base_path('app/license-lock.php');
        $this->originalContents = file_get_contents($this->filePath);
    }

    protected function tearDown(): void
    {
        // Always restore the real file, regardless of pass/fail, so this
        // dev environment is never left in a locked state by a test run.
        file_put_contents($this->filePath, $this->originalContents);
        parent::tearDown();
    }

    private function writeLockFile(bool $locked, ?string $message = null): void
    {
        $export = var_export(['locked' => $locked, 'message' => $message], true);
        file_put_contents($this->filePath, "<?php\n\nreturn {$export};\n");
    }

    /** @test */
    public function file_defaults_to_unlocked_and_does_not_block_anything()
    {
        $this->assertFalse(app(LicenseService::class)->isCodeLocked());
        $this->get('/')->assertOk();
    }

    /** @test */
    public function setting_locked_true_blocks_every_request()
    {
        $this->writeLockFile(true);

        $this->assertTrue(app(LicenseService::class)->isCodeLocked());

        $resp = $this->get('/');
        $resp->assertStatus(503);
        $resp->assertSee('Sistem Tidak Dapat Diakses');
    }

    /** @test */
    public function custom_message_is_shown_when_provided()
    {
        $this->writeLockFile(true, 'Akaun anda telah digantung sementara.');

        $this->get('/')->assertSee('Akaun anda telah digantung sementara.');
    }

    /** @test */
    public function code_lock_has_no_exceptions_not_even_the_control_panel()
    {
        $this->writeLockFile(true);

        // Unlike the DB-based lock, there is nothing a panel button or a
        // typed key could do to undo a lock baked into deployed code — so
        // the panel itself is blocked too, consistent with "edit the file
        // and redeploy is the only way out." Uses a placeholder segment
        // rather than the real configured token — irrelevant here, since
        // the code-lock check fires before any token validation happens.
        $resp = $this->get('/system-control/any-non-empty-value-matches-the-route');
        $resp->assertStatus(503);
    }

    /** @test */
    public function setting_locked_back_to_false_restores_access_immediately()
    {
        $this->writeLockFile(true);
        $this->get('/')->assertStatus(503);

        $this->writeLockFile(false);
        $this->get('/')->assertOk();
    }

    /** @test */
    public function isLocked_reflects_the_code_lock_even_with_db_lock_off()
    {
        $service = app(LicenseService::class);
        $this->assertFalse($service->isLocked());

        $this->writeLockFile(true);
        $this->assertTrue($service->isLocked());
    }
}
