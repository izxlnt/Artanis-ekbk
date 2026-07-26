<?php

namespace App\Services;

use App\Models\SystemLicense;
use RuntimeException;

/**
 * System-wide access lock, independent of the maintenance-mode feature.
 * Maintenance mode is a client-toggleable "we're doing upkeep" notice (and
 * explicitly lets BPE/admin users through). This is the opposite: nobody,
 * including the client's own admin, can turn it off without a key derived
 * from a secret only the developer holds (config('app.license_secret'),
 * set via LICENSE_SECRET in .env — never committed, never shown in any UI).
 *
 * Locking generates a fresh random nonce, so a key valid for one lock event
 * can never be replayed against a later one.
 */
class LicenseService
{
    public function getSecret(): string
    {
        $secret = config('app.license_secret');
        if (empty($secret)) {
            throw new RuntimeException(
                'LICENSE_SECRET is not set in .env — refusing to lock the system, since without it ' .
                'no valid unlock key could ever be generated. Set LICENSE_SECRET to a long random ' .
                'value before using php artisan license:lock.'
            );
        }
        return $secret;
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
     */
    public function deriveKey(string $nonce): string
    {
        $hash = hash_hmac('sha256', $nonce, $this->getSecret());
        $short = strtoupper(substr($hash, 0, 16));
        return implode('-', str_split($short, 4));
    }

    public function verifyKey(string $nonce, string $suppliedKey): bool
    {
        return hash_equals(
            $this->normalizeKey($this->deriveKey($nonce)),
            $this->normalizeKey($suppliedKey)
        );
    }

    private function normalizeKey(string $key): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $key));
    }

    /**
     * @return string the freshly generated unlock key for this lock event
     */
    public function lock(?string $reason = null, ?string $message = null): string
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
     * Reprint the currently valid key without re-locking (in case it was
     * lost) — safe because the nonce doesn't change until the next lock().
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
