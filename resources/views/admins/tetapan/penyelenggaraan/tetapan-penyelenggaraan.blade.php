@extends('layouts.layout-ipjpsm-nicepage')

@section('content')

<div>
    <div class="container-fluid" style="width:100%">
        <div class="row">
            <div class="col-12">

                {{-- Breadcrumb --}}
                <div class="page-breadcrumb" style="padding: 0px">
                    <div class="pb-2 row">
                        <div class="col-5 align-self-center">
                            <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex align-items-center justify-content-end">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                            @if (!$loop->last)
                                                <li class="breadcrumb-item">
                                                    <a href="{{ $breadcrumb['link'] }}" style="color: white !important;"
                                                        onMouseOver="this.style.color='lightblue'"
                                                        onMouseOut="this.style.color='white'">{{ $breadcrumb['name'] }}</a>
                                                </li>
                                            @else
                                                <li class="breadcrumb-item active" aria-current="page"
                                                    style="color: yellow !important;">
                                                    {{ $breadcrumb['name'] }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">

                        <div class="text-center mb-4">
                            <h4><i class="fas fa-tools mr-2"></i>TETAPAN MOD PENYELENGGARAAN SISTEM</h4>
                            <p class="text-muted" style="font-size: 13px;">Urus jadual dan maklumat penyelenggaraan sistem yang akan dipaparkan kepada pengguna.</p>
                        </div>

                        {{-- Current Status Banner --}}
                        @if ($tetapan->is_active)
                            <div class="alert alert-warning text-center" style="border-radius: 10px;">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Mod Penyelenggaraan AKTIF</strong> — Pengguna tidak dapat log masuk ke sistem pada masa ini.
                                @if ($tetapan->dikemaskini_oleh)
                                    <br><small class="text-muted">Dikemaskini oleh: <strong>{{ $tetapan->dikemaskini_oleh }}</strong>
                                        pada {{ $tetapan->updated_at->format('d/m/Y h:i A') }}</small>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-success text-center" style="border-radius: 10px;">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Sistem Beroperasi Seperti Biasa</strong> — Mod penyelenggaraan tidak aktif.
                                @if ($tetapan->dikemaskini_oleh)
                                    <br><small class="text-muted">Kemaskini terakhir oleh: <strong>{{ $tetapan->dikemaskini_oleh }}</strong>
                                        pada {{ $tetapan->updated_at->format('d/m/Y h:i A') }}</small>
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('tetapan.penyelenggaraan.kemaskini') }}" method="POST" id="form-penyelenggaraan">
                            @csrf

                            {{-- Toggle --}}
                            <div class="card mb-4" style="border: 1px solid #dee2e6; border-radius: 10px;">
                                <div class="card-body d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
                                    <div>
                                        <h6 class="mb-1"><i class="fas fa-power-off mr-2 text-danger"></i>Aktifkan Mod Penyelenggaraan</h6>
                                        <small class="text-muted">Apabila diaktifkan, semua pengguna (kecuali pentadbir IPJPSM) tidak dapat mengakses sistem.</small>
                                    </div>
                                    <div class="custom-control custom-switch" style="transform: scale(1.4); transform-origin: right;">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1" {{ $tetapan->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active"></label>
                                    </div>
                                </div>
                            </div>

                            {{-- Date Range --}}
                            <div class="card mb-4" style="border: 1px solid #dee2e6; border-radius: 10px;">
                                <div class="card-header" style="background: #f8f9fa; border-radius: 10px 10px 0 0;">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Tempoh Penyelenggaraan <span class="text-muted" style="font-weight: normal; font-size: 12px;">(Pilihan — kosongkan jika tiada tarikh tetap)</span></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="start_date" class="font-weight-bold" style="font-size: 13px;">
                                                <i class="fas fa-calendar-check mr-1 text-success"></i>Tarikh &amp; Masa Mula
                                            </label>
                                            <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                                value="{{ $tetapan->start_date ? $tetapan->start_date->format('Y-m-d\TH:i') : '' }}">
                                            <small class="text-muted">Contoh: 18 Mei 2026, 10:00 malam</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="end_date" class="font-weight-bold" style="font-size: 13px;">
                                                <i class="fas fa-calendar-times mr-1 text-danger"></i>Tarikh &amp; Masa Tamat
                                            </label>
                                            <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                                value="{{ $tetapan->end_date ? $tetapan->end_date->format('Y-m-d\TH:i') : '' }}">
                                            <small class="text-muted">Sistem dijangka kembali beroperasi pada masa ini</small>
                                        </div>
                                    </div>

                                    {{-- Date preview --}}
                                    <div id="date-preview" class="mt-2 p-3" style="background: #e9f5ec; border-radius: 8px; border: 1px solid #b7e4c7; display: none;">
                                        <small><i class="fas fa-info-circle mr-1 text-success"></i>
                                            <strong>Paparan kepada pengguna:</strong>
                                            <span id="date-preview-text"></span>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="card mb-4" style="border: 1px solid #dee2e6; border-radius: 10px;">
                                <div class="card-header" style="background: #f8f9fa; border-radius: 10px 10px 0 0;">
                                    <h6 class="mb-0"><i class="fas fa-comment-alt mr-2 text-warning"></i>Mesej kepada Pengguna <span class="text-muted" style="font-weight: normal; font-size: 12px;">(Pilihan)</span></h6>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control" id="message" name="message" rows="3"
                                        maxlength="500"
                                        placeholder="Cth: Sistem sedang dikemaskini untuk meningkatkan prestasi dan keselamatan. Kami memohon maaf atas kesulitan ini.">{{ old('message', $tetapan->message) }}</textarea>
                                    <div class="d-flex justify-content-between mt-1">
                                        <small class="text-muted">Jika dikosongkan, mesej lalai akan digunakan.</small>
                                        <small class="text-muted"><span id="msg-count">{{ strlen($tetapan->message ?? '') }}</span>/500</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Internal notes --}}
                            <div class="card mb-4" style="border: 1px solid #dee2e6; border-radius: 10px;">
                                <div class="card-header" style="background: #f8f9fa; border-radius: 10px 10px 0 0;">
                                    <h6 class="mb-0"><i class="fas fa-sticky-note mr-2 text-secondary"></i>Catatan Dalaman <span class="text-muted" style="font-weight: normal; font-size: 12px;">(Tidak dipaparkan kepada pengguna)</span></h6>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control" id="catatan" name="catatan" rows="2"
                                        maxlength="1000"
                                        placeholder="Cth: Penyelenggaraan pangkalan data oleh pasukan IT. Rujuk tiket #TK-2026-001.">{{ old('catatan', $tetapan->catatan) }}</textarea>
                                    <small class="text-muted">Nota untuk rujukan pentadbir sahaja.</small>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 10px;">
                                <a href="{{ route('home') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-5" id="btn-simpan">
                                    <i class="fas fa-save mr-2"></i>Simpan Tetapan
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Character counter for message
    document.getElementById('message').addEventListener('input', function () {
        document.getElementById('msg-count').textContent = this.value.length;
    });

    // Date range preview
    function updateDatePreview() {
        const start = document.getElementById('start_date').value;
        const end   = document.getElementById('end_date').value;
        const preview = document.getElementById('date-preview');
        const text    = document.getElementById('date-preview-text');

        const fmt = (val) => {
            if (!val) return null;
            const d = new Date(val);
            return d.toLocaleString('ms-MY', { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        };

        if (start || end) {
            preview.style.display = 'block';
            if (start && end) {
                text.textContent = ` ${fmt(start)} hingga ${fmt(end)}`;
            } else if (start) {
                text.textContent = ` Bermula ${fmt(start)}`;
            } else {
                text.textContent = ` Dijangka selesai ${fmt(end)}`;
            }
        } else {
            preview.style.display = 'none';
        }
    }

    document.getElementById('start_date').addEventListener('change', updateDatePreview);
    document.getElementById('end_date').addEventListener('change', updateDatePreview);
    updateDatePreview();

    // Confirm before activating
    document.getElementById('form-penyelenggaraan').addEventListener('submit', function (e) {
        const isActive = document.getElementById('is_active').checked;
        const wasActive = {{ $tetapan->is_active ? 'true' : 'false' }};

        if (isActive && !wasActive) {
            if (!confirm('Anda akan mengaktifkan Mod Penyelenggaraan.\n\nSemua pengguna tidak akan dapat mengakses sistem.\n\nTeruskan?')) {
                e.preventDefault();
            }
        }
    });
</script>

@endsection
