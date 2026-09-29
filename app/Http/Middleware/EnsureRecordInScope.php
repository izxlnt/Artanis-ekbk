<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Checks that a record opened by id belongs to the logged-in user's scope:
 *   PHD  -> the kilang's district (daerah_id) is one of the PHD's districts
 *   JPN  -> the kilang's state matches the JPN's state
 *   IBK  -> the record belongs to the user's own kilang
 * BPE / BPM (national roles) are not restricted.
 *
 * Which routes open which kind of record is listed in config/record_scope.php.
 * RECORD_SCOPE_MODE: off | log (default; only logs what would be blocked) | enforce (403).
 */
class EnsureRecordInScope
{
    private const MODELS = [
        'FormA'         => \App\Models\FormA::class,
        'FormB'         => \App\Models\FormB::class,
        'FormC'         => \App\Models\FormC::class,
        'FormD'         => \App\Models\FormD::class,
        'Form4D'        => \App\Models\Form4D::class,
        'Form4E'        => \App\Models\Form4E::class,
        'Form5D'        => \App\Models\Form5D::class,
        'Form5E'        => \App\Models\Form5E::class,
        'Shuttle'       => \App\Models\Shuttle::class,
        'Batch'         => \App\Models\Batch::class,
        'User'          => \App\Models\User::class,
        'Pengumuman'    => \App\Models\Pengumuman::class,
        'PengumumanJpn' => \App\Models\PengumumanJpn::class,
    ];

    public function handle(Request $request, Closure $next)
    {
        $mode = config('record_scope.mode', 'log');
        $route = $request->route();

        if ($mode === 'off' || !$route || !Auth::check()) {
            return $next($request);
        }

        $entry = config('record_scope.routes.' . $route->uri());
        if (!$entry) {
            return $next($request);
        }

        // "Kind" (id from the {id} route parameter) or "Kind:name" (route parameter or request input "name")
        [$kind, $param] = array_pad(explode(':', $entry, 2), 2, 'id');
        if ($kind !== 'DaerahHutan' && !isset(self::MODELS[$kind])) {
            return $next($request);
        }

        $user = Auth::user();
        $value = $route->parameter($param) ?? $request->input($param);
        $reason = $this->outOfScope($user, $kind, $value);

        if ($reason !== null) {
            Log::warning('record_scope: ' . ($mode === 'enforce' ? 'BLOCKED' : 'would block') . ' - ' . $reason, [
                'user_id' => $user->id,
                'role'    => $user->kategori_pengguna,
                'method'  => $request->method(),
                'route'   => $route->uri(),
                'target'  => $kind . ':' . $value,
            ]);

            if ($mode === 'enforce') {
                abort(403, 'Anda tidak dibenarkan mengakses rekod ini.');
            }
        }

        return $next($request);
    }

    /** null when the record is in scope (or cannot be judged), otherwise the reason it is not. */
    private function outOfScope($user, string $kind, $id): ?string
    {
        $role = $user->kategori_pengguna;
        if (!in_array($role, ['PHD', 'JPN', 'IBK'], true) || $id === null) {
            return null;
        }

        // A district name (JPN emailing a PHD): the district must be in the JPN's state.
        if ($kind === 'DaerahHutan') {
            $negeri = \DB::table('daerahs')->where('daerah_hutan', $id)->value('negeri');
            return $role === 'JPN' && $negeri !== null && $negeri !== $user->negeri
                ? "district '{$id}' is in state '{$negeri}', JPN is '{$user->negeri}'"
                : null;
        }

        $model = self::MODELS[$kind];
        $record = $model::find($id);
        if (!$record) {
            return null; // the controller already handles a missing record
        }

        // Announcements are scoped by their own district / state, not through a kilang.
        if ($kind === 'Pengumuman') {
            return $role === 'PHD' && $record->daerah_hutan !== $user->daerah_hutan
                ? "announcement is for district '{$record->daerah_hutan}', user is '{$user->daerah_hutan}'"
                : null;
        }
        if ($kind === 'PengumumanJpn') {
            return $role === 'JPN' && $record->negeri !== $user->negeri
                ? "announcement is for state '{$record->negeri}', user is '{$user->negeri}'"
                : null;
        }

        $shuttle = $kind === 'Shuttle' ? $record : $record->shuttle;
        if (!$shuttle) {
            return null;
        }

        if ($role === 'PHD') {
            return in_array((int) $shuttle->daerah_id, array_map('intval', $user->daerah_ids), true)
                ? null
                : "kilang #{$shuttle->id} is in district {$shuttle->daerah_id}, PHD covers [" . implode(',', $user->daerah_ids) . ']';
        }

        if ($role === 'JPN') {
            return $shuttle->negeri_id === $user->negeri
                ? null
                : "kilang #{$shuttle->id} is in state '{$shuttle->negeri_id}', JPN is '{$user->negeri}'";
        }

        // IBK
        return (int) $shuttle->id === (int) $user->shuttle_id
            ? null
            : "kilang #{$shuttle->id} is not the user's own kilang #{$user->shuttle_id}";
    }
}
