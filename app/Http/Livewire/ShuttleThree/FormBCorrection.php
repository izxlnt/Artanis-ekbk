<?php

namespace App\Http\Livewire\ShuttleThree;

use App\Models\FormB;
use App\Models\GunaTenaga;
use App\Models\KategoriGunaTenaga;
use Livewire\Component;

/**
 * Lets PHD (while a Form B is "Sedang Diproses") and IPJPSM/BPE (while it's
 * "Dihantar ke IPJPSM") correct a submitted Form B's figures before making
 * their Sahkan/Tolak decision - shared across shuttle 3/4/5, since the
 * GunaTenaga/KategoriGunaTenaga data model behind Form B is identical for
 * all three.
 *
 * Corrections are written to the _laporan columns (already used everywhere
 * downstream in the Laporan/report exports), never to the original
 * pekerja_/gaji_ columns IBK submitted - so IBK's original submission
 * stays intact and "Set Semula" (reset) can always restore it. This
 * replaces the old DataCleaning3B component, which showed every original
 * value immediately followed by a separate blank correction box (the "side
 * by side" layout reported as confusing) and, worse, bundled saving a
 * correction with approving the form (forcing status to "Lulus"). Here,
 * correcting data and deciding Sahkan/Tolak are two separate actions.
 */
class FormBCorrection extends Component
{
    public $formb_id;

    public $pekerja_wargabumi_lelaki, $pekerja_wargabumi_perempuan, $pekerja_bukan_wargabumi_lelaki, $pekerja_bukan_wargabumi_perempuan, $pekerja_asing_lelaki, $pekerja_asing_perempuan,
        $jumlah_lelaki, $jumlah_perempuan, $jumlah_pekerja, $gaji_lelaki, $gaji_perempuan, $total_gaji_lelaki, $total_gaji_perempuan, $total_gaji,
        $total_bumi_lelaki, $total_bumi_perempuan, $total_bukanbumi_lelaki, $total_bukanbumi_perempuan, $total_asing_lelaki, $total_asing_perempuan,
        $total_pekerja_lelaki, $total_pekerja_perempuan, $total_pekerja, $jumlah_gaji_lelaki, $jumlah_gaji_perempuan, $jumlah_total_lelaki,
        $gaji_lelaki_perempuan, $jumlah_total_perempuan, $jumlah_total_gaji, $jumlah_lelaki_perempuan;

    private const PER_ROW_FIELDS = [
        'pekerja_wargabumi_lelaki', 'pekerja_wargabumi_perempuan',
        'pekerja_bukan_wargabumi_lelaki', 'pekerja_bukan_wargabumi_perempuan',
        'pekerja_asing_lelaki', 'pekerja_asing_perempuan',
        'jumlah_lelaki', 'jumlah_perempuan', 'jumlah_pekerja',
        'gaji_lelaki', 'gaji_perempuan',
        'gaji_lelaki_perempuan', 'total_gaji_lelaki', 'total_gaji_perempuan', 'total_gaji',
    ];

    private const AGGREGATE_FIELDS = [
        'total_bumi_lelaki', 'total_bumi_perempuan',
        'total_bukanbumi_lelaki', 'total_bukanbumi_perempuan',
        'total_asing_lelaki', 'total_asing_perempuan',
        'total_pekerja_lelaki', 'total_pekerja_perempuan', 'total_pekerja',
        'jumlah_gaji_lelaki', 'jumlah_gaji_perempuan', 'jumlah_lelaki_perempuan',
        'jumlah_total_lelaki', 'jumlah_total_perempuan', 'jumlah_total_gaji',
    ];

    public function mount($formbId)
    {
        $this->formb_id = $formbId;
        $this->loadEffectiveValues();
    }

    public function render()
    {
        $kategori_pekerja = KategoriGunaTenaga::orderBy('id')->get();

        return view('livewire.shuttle-three.form-b-correction', compact('kategori_pekerja'));
    }

    /**
     * Shows the currently-reported (_laporan) value when it has actually
     * been corrected, otherwise the original IBK submission - never the
     * raw _laporan column on its own, since every row already has "0"
     * sitting in every _laporan column from the migration default that
     * added them, regardless of whether anyone has ever corrected that
     * row. A _laporan value of exactly zero is therefore treated the same
     * as "never corrected" (falls back to the original) rather than as a
     * deliberate correction to zero - a rare edge case, but a far safer
     * default than the alternative of every untouched Form B appearing to
     * have been "corrected" to all zeroes.
     */
    private function effectiveValue($row, string $field)
    {
        $laporan = $row->{$field . '_laporan'};

        if ($laporan === null || $laporan === '' || (float) $laporan == 0.0) {
            return $row->{$field};
        }

        return $laporan;
    }

    private function rows()
    {
        return GunaTenaga::where('formbs_id', $this->formb_id)
            ->orderBy('id', 'desc')
            ->get()
            ->unique('kategori_guna_tenaga_id')
            ->keyBy('kategori_guna_tenaga_id');
    }

    private function loadEffectiveValues()
    {
        $kategori_pekerja = KategoriGunaTenaga::orderBy('id')->get();
        $rows = $this->rows();

        foreach ($kategori_pekerja as $key => $kategori) {
            $row = $rows[$kategori->id] ?? null;
            if (!$row) {
                continue;
            }
            foreach (self::PER_ROW_FIELDS as $field) {
                $this->{$field}[$key] = $this->effectiveValue($row, $field);
            }
        }

        $first = $rows->first();
        if ($first) {
            foreach (self::AGGREGATE_FIELDS as $field) {
                $this->{$field} = $this->effectiveValue($first, $field);
            }
        }
    }

    // male cell use this function for calculation, use this in wire:change for male input cells
    public function calcJumlahPekerjaLelaki($key)   //(02)+(04)+(06)= (08)
    {
        $warga = $this->pekerja_wargabumi_lelaki[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0;
        $asing = $this->pekerja_asing_lelaki[$key] ?? 0;

        $this->jumlah_lelaki[$key] = (int) $warga + (int) $bukan_warga + (int) $asing;

        $this->calcJumlahLelakiBumiputera();
        $this->calcJumlahLelakiBukanBumiputera();
        $this->calcJumlahLelakiBukanWarganegara();
        $this->calcTotalAllPekerjaLelaki();

        $this->calcJumlahPekerja($key);
        $this->calcTotalAllJumlahPekerja();

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key);
        $this->calcTotalAllBayaranGajiPerPekerjaLelaki();
        $this->calcTotalAllBayaranGajiLelakiPerempuan();

        $this->calcJumlahGajiUpahSebulanLelaki($key);
        $this->calcTotalAllBayaranGajiLelaki();

        $this->calcJumlahGaji($key);
        $this->calcTotalAllBayaranGaji();

        $this->save();
    }

    // female cell use this function for calculation, use this in wire:change for female input cells
    public function calcJumlahPekerjaPerempuan($key) //(03)+(05)+(07)= (09)
    {
        $warga = $this->pekerja_wargabumi_perempuan[$key] ?? 0;
        $bukan_warga = $this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0;
        $asing = $this->pekerja_asing_perempuan[$key] ?? 0;

        $this->jumlah_perempuan[$key] = (int) $warga + (int) $bukan_warga + (int) $asing;

        $this->calcJumlahPerempuanBumiputera();
        $this->calcJumlahPerempuanBukanBumiputera();
        $this->calcJumlahPerempuanBukanWarganegara();
        $this->calcTotalAllPekerjaPerempuan();

        $this->calcJumlahPekerja($key);
        $this->calcTotalAllJumlahPekerja();

        $this->calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key);
        $this->calcTotalAllBayaranGajiPerPekerjaPerempuan();
        $this->calcTotalAllBayaranGajiLelakiPerempuan();

        $this->calcJumlahGajiUpahSebulanPerempuan($key);
        $this->calcTotalAllBayaranGajiPerempuan();

        $this->calcJumlahGaji($key);
        $this->calcTotalAllBayaranGaji();

        $this->save();
    }

    public function calcJumlahPekerja($key) // (08)+(09)= (10)
    {
        $lelaki = $this->jumlah_lelaki[$key] ?? 0;
        $perempuan = $this->jumlah_perempuan[$key] ?? 0;
        $this->jumlah_pekerja[$key] = (int) $lelaki + (int) $perempuan;
    }

    public function calcTotalAllJumlahPekerja()
    {
        $this->total_pekerja = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_pekerja += (int) ($this->jumlah_pekerja[$key] ?? 0);
        }
    }

    public function calcJumlahGaji($key) //(13)+(14)= (15)
    {
        $lelaki = $this->total_gaji_lelaki[$key] ?? 0;
        $perempuan = $this->total_gaji_perempuan[$key] ?? 0;
        $this->total_gaji[$key] = number_format((float) $lelaki + (float) $perempuan, 2, '.', '');
    }

    public function calcJumlahLelakiBumiputera()
    {
        $this->total_bumi_lelaki = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_bumi_lelaki += (int) ($this->pekerja_wargabumi_lelaki[$key] ?? 0);
        }
    }

    public function calcJumlahPerempuanBumiputera()
    {
        $this->total_bumi_perempuan = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_bumi_perempuan += (int) ($this->pekerja_wargabumi_perempuan[$key] ?? 0);
        }
    }

    public function calcJumlahLelakiBukanBumiputera()
    {
        $this->total_bukanbumi_lelaki = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_bukanbumi_lelaki += (int) ($this->pekerja_bukan_wargabumi_lelaki[$key] ?? 0);
        }
    }

    public function calcJumlahPerempuanBukanBumiputera()
    {
        $this->total_bukanbumi_perempuan = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_bukanbumi_perempuan += (int) ($this->pekerja_bukan_wargabumi_perempuan[$key] ?? 0);
        }
    }

    public function calcJumlahLelakiBukanWarganegara()
    {
        $this->total_asing_lelaki = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_asing_lelaki += (int) ($this->pekerja_asing_lelaki[$key] ?? 0);
        }
    }

    public function calcJumlahPerempuanBukanWarganegara()
    {
        $this->total_asing_perempuan = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_asing_perempuan += (int) ($this->pekerja_asing_perempuan[$key] ?? 0);
        }
    }

    public function calcTotalAllPekerjaLelaki()
    {
        $this->total_pekerja_lelaki = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_pekerja_lelaki += (int) ($this->jumlah_lelaki[$key] ?? 0);
        }
    }

    public function calcTotalAllPekerjaPerempuan()
    {
        $this->total_pekerja_perempuan = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $this->total_pekerja_perempuan += (int) ($this->jumlah_perempuan[$key] ?? 0);
        }
    }

    public function calcTotalAllBayaranGajiPerPekerjaLelaki()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += round((float) ($this->gaji_lelaki[$key] ?? 0), 2);
        }
        $this->jumlah_gaji_lelaki = round($total, 2);
    }

    public function calcTotalAllBayaranGajiPerPekerjaPerempuan()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += round((float) ($this->gaji_perempuan[$key] ?? 0), 2);
        }
        $this->jumlah_gaji_perempuan = round($total, 2);
    }

    public function calcTotalAllBayaranGajiLelakiPerempuan()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += (float) number_format((float) ($this->gaji_lelaki_perempuan[$key] ?? 0), 2, '.', '');
        }
        $this->jumlah_lelaki_perempuan = round($total, 2);
    }

    public function calcJumlahGajiUpahSebulanLelaki($key)   //(14)= (08) * (11)
    {
        $jumlah_lelaki = $this->jumlah_lelaki[$key] ?? 0;
        $gaji_per_pekerja = $this->gaji_lelaki[$key] ?? 0;
        $this->total_gaji_lelaki[$key] = number_format((int) $jumlah_lelaki * (float) $gaji_per_pekerja, 2, '.', '');
    }

    public function calcJumlahGajiUpahSebulanPerempuan($key)   //(14)= (08) * (11)
    {
        $jumlah_perempuan = $this->jumlah_perempuan[$key] ?? 0;
        $gaji_per_pekerja = $this->gaji_perempuan[$key] ?? 0;
        $this->total_gaji_perempuan[$key] = number_format((int) $jumlah_perempuan * (float) $gaji_per_pekerja, 2, '.', '');
    }

    public function calcTotalAllBayaranGajiPerPekerjaLelakiPerempuan($key)
    {
        $perempuan = $this->gaji_perempuan[$key] ?? 0;
        $lelaki = $this->gaji_lelaki[$key] ?? 0;
        $this->gaji_lelaki_perempuan[$key] = round((float) number_format((float) $lelaki + (float) $perempuan, 2, '.', ''), 2);
    }

    public function calcTotalAllBayaranGajiLelaki()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += (float) number_format((float) ($this->total_gaji_lelaki[$key] ?? 0), 2, '.', '');
        }
        $this->jumlah_total_lelaki = round($total, 2);
    }

    public function calcTotalAllBayaranGajiPerempuan()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += (float) number_format((float) ($this->total_gaji_perempuan[$key] ?? 0), 2, '.', '');
        }
        $this->jumlah_total_perempuan = round($total, 2);
    }

    public function calcTotalAllBayaranGaji()
    {
        $total = 0;
        foreach (KategoriGunaTenaga::orderBy('id')->get() as $key => $data) {
            $total += round((float) ($this->total_gaji[$key] ?? 0), 2);
        }
        $this->jumlah_total_gaji = round($total, 2);
    }

    /**
     * Persists the current in-memory figures to the *_laporan columns.
     * Called automatically at the end of calcJumlahPekerjaLelaki()/
     * calcJumlahPekerjaPerempuan() (i.e. on every field's blur) - there is
     * no separate "Simpan Pembetulan" button any more, since a value the
     * reviewer just typed and tabbed away from is already what should be
     * reported; a second explicit save step was reported as redundant.
     */
    public function save()
    {
        $kategori_pekerja = KategoriGunaTenaga::orderBy('id')->get();
        $rows = $this->rows();

        foreach ($kategori_pekerja as $key => $kategori) {
            $row = $rows[$kategori->id] ?? null;
            if (!$row) {
                continue;
            }

            $update = [];
            foreach (self::PER_ROW_FIELDS as $field) {
                $update[$field . '_laporan'] = $this->{$field}[$key] ?? 0;
            }
            foreach (self::AGGREGATE_FIELDS as $field) {
                $update[$field . '_laporan'] = $this->{$field} ?? 0;
            }
            $row->update($update);
        }
    }

    public function resetToOriginal()
    {
        $rows = $this->rows();

        foreach ($rows as $row) {
            $update = [];
            foreach (self::PER_ROW_FIELDS as $field) {
                $update[$field . '_laporan'] = $row->{$field};
            }
            foreach (self::AGGREGATE_FIELDS as $field) {
                $update[$field . '_laporan'] = $row->{$field};
            }
            $row->update($update);
        }

        $this->loadEffectiveValues();

        $this->emit('alert', ['type' => 'success', 'message' => 'Data telah dikembalikan kepada penyerahan asal IBK.']);
    }
}
