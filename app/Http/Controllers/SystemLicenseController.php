<?php

namespace App\Http\Controllers;

use App\Services\LicenseService;
use Illuminate\Http\Request;

class SystemLicenseController extends Controller
{
    /**
     * The public-facing form on the locked-out page itself — anyone can
     * reach this, but only a key matching the current lock's nonce works.
     */
    public function unlock(Request $request, LicenseService $service)
    {
        $request->validate([
            'unlock_key' => 'required|string',
        ]);

        if ($service->unlock($request->input('unlock_key'))) {
            return redirect('/')->with('success', 'Sistem telah dibuka semula.');
        }

        return back()->withErrors(['unlock_key' => 'Kod akses tidak sah.']);
    }

    /**
     * The private control panel — a bookmarkable link gated by a long random
     * token (CONTROL_PANEL_TOKEN) instead of requiring server/SSH access.
     * A wrong or missing token gets a plain 404, not a 403, so a stray guess
     * doesn't even confirm this route exists.
     */
    public function panel(string $token, LicenseService $service)
    {
        $this->requireValidToken($token);

        $license = $service->current();

        return view('system-control-panel', [
            'token'   => $token,
            'license' => $license,
            'key'     => $license->is_locked ? $service->currentKey() : null,
        ]);
    }

    public function panelLock(Request $request, string $token, LicenseService $service)
    {
        $this->requireValidToken($token);

        $request->validate([
            'reason'  => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $service->lock($request->input('reason'), $request->input('message'));

        return redirect()->route('system-control.panel', $token)->with('success', 'Sistem telah dikunci.');
    }

    public function panelUnlock(string $token, LicenseService $service)
    {
        $this->requireValidToken($token);

        $key = $service->currentKey();
        if ($key === null || !$service->unlock($key)) {
            return redirect()->route('system-control.panel', $token)->withErrors(['panel' => 'Sistem tidak dikunci pada masa ini.']);
        }

        return redirect()->route('system-control.panel', $token)->with('success', 'Sistem telah dibuka semula.');
    }

    private function requireValidToken(string $token): void
    {
        $expected = config('app.control_panel_token');

        if (empty($expected) || !hash_equals($expected, $token)) {
            abort(404);
        }
    }
}
