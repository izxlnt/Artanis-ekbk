<?php

namespace App\Observers;

use App\Models\Shuttle;
use App\Services\FormFlowService;
use Illuminate\Support\Facades\DB;

class ShuttleObserver
{
    /**
     * Borang B/C/D/E each keep their own snapshot of no_ssm/no_lesen/nama_kilang,
     * copied from the shuttle at record-creation time (see UserController's
     * form-initialization routine). That snapshot is intentional for forms
     * already submitted - it records what was true at filing time - but it must
     * not go stale on forms the mill hasn't submitted yet. Whenever the shuttle's
     * own company info changes, push it onto every not-yet-submitted form so an
     * unfilled month always shows current company info.
     */
    public function updated(Shuttle $shuttle)
    {
        if (!$shuttle->wasChanged(['no_ssm', 'no_lesen', 'nama_kilang'])) {
            return;
        }

        $sync = [
            'no_ssm' => $shuttle->no_ssm,
            'no_lesen' => $shuttle->no_lesen,
            'nama_kilang' => $shuttle->nama_kilang,
            'updated_at' => now(),
        ];

        $tables = ['formbs', 'form_c_s'];

        switch ((int) $shuttle->shuttle_type) {
            case 4:
                $tables[] = 'form4_d_s';
                $tables[] = 'form4_e_s';
                break;
            case 5:
                $tables[] = 'form5_d_s';
                $tables[] = 'form5_e_s';
                break;
            default:
                $tables[] = 'form_d_s';
        }

        foreach ($tables as $table) {
            DB::table($table)
                ->where('shuttle_id', $shuttle->id)
                ->whereNotIn('status', FormFlowService::SUBMITTED)
                ->update($sync);
        }
    }
}
