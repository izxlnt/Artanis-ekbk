<?php

namespace App\Services;

use App\Models\SystemLicense;

/**
 * System-wide access lock, independent of the maintenance-mode feature.
 * Maintenance mode is a client-toggleable "we're doing upkeep" notice (and
 * explicitly lets BPE/admin users through). This is the opposite: nobody,
 * including the client's own admin, can turn it off from any in-app screen.
 *
 * Two separate credentials, two separate purposes:
 * - CONTROL_PANEL_TOKEN gates /system-control/{token} — this alone is
 *   enough to lock or unlock at will, forever, no other secret needed.
 *   This is what you use yourself.
 * - LICENSE_SECRET (optional) additionally lets you hand out a short,
 *   typable one-time code (e.g. to the client once they've paid) so they
 *   can unlock it themselves on the public locked-out page, without ever
 *   giving them your panel link. If it's not set, that specific option is
 *   simply unavailable — the panel still works either way.
 */
class LicenseService
{
    public function hasSecret(): bool
    {
        return !empty(config('app.license_secret'));
    }

    public function current(): SystemLicense
    {
        return SystemLicense::firstOrCreate([], ['is_locked' => false]);
    }

    public function isLocked(): bool
    {
        return (bool) $this->current()->is_locked;
    }

    /**
     * Format: XXXX-XXXX-XXXX-XXXX, derived from HMAC-SHA256(nonce, secret).
     * Null if LICENSE_SECRET isn't configured — that's fine, the panel
     * doesn't need it.
     */
    public function deriveKey(string $nonce): ?string
    {
        if (!$this->hasSecret()) {
            return null;
        }
        $hash = hash_hmac('sha256', $nonce, config('app.license_secret'));
        $short = strtoupper(substr($hash, 0, 16));
        return implode('-', str_split($short, 4));
    }

    public function verifyKey(string $nonce, string $suppliedKey): bool
    {
        $expected = $this->deriveKey($nonce);
        if ($expected === null) {
            return false;
        }
        return hash_equals($this->normalizeKey($expected), $this->normalizeKey($suppliedKey));
    }

    private function normalizeKey(string $key): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $key));
    }

    /**
     * @return string|null the freshly generated public unlock key for this
     *                      lock event, or null if LICENSE_SECRET isn't set
     *                      (lock still succeeds — unlock via the panel).
     */
    public function lock(?string $reason = null, ?string $message = null): ?string
    {
        $nonce = bin2hex(random_bytes(32));

        $license = $this->current();
        $license->is_locked      = true;
        $license->nonce          = $nonce;
        $license->locked_reason  = $reason;
        $license->locked_message = $message;
        $license->locked_at      = now();
        $license->unlocked_at    = null;
        $license->save();

        return $this->deriveKey($nonce);
    }

    /**
     * The public, key-based unlock path (the box on the locked-out page).
     * Always fails gracefully (returns false) if no key could ever be valid
     * — e.g. LICENSE_SECRET isn't set — rather than erroring.
     */
    public function unlock(string $suppliedKey): bool
    {
        $license = $this->current();

        if (!$license->is_locked || !$license->nonce) {
            return false;
        }

        if (!$this->verifyKey($license->nonce, $suppliedKey)) {
            return false;
        }

        $license->is_locked   = false;
        $license->unlocked_at = now();
        $license->save();

        return true;
    }

    /**
     * The panel's own unlock action: the CONTROL_PANEL_TOKEN already proved
     * who you are, so this skips the key system entirely — no LICENSE_SECRET
     * required.
     */
    public function forceUnlock(): void
    {
        $license = $this->current();
        $license->is_locked   = false;
        $license->unlocked_at = now();
        $license->save();
    }

    /**
     * Reprint the currently valid public key without re-locking (in case it
     * was lost) — safe because the nonce doesn't change until the next
     * lock(). Null if the system isn't locked, or if LICENSE_SECRET isn't set.
     */
    public function currentKey(): ?string
    {
        $license = $this->current();
        if (!$license->is_locked || !$license->nonce) {
            return null;
        }
        return $this->deriveKey($license->nonce);
    }
}
