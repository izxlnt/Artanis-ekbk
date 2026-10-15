{{--
    Sijil SSM and Lesen Kilang of a kilang ($kilang_info = shuttles row). Kilang upload either an
    image or a PDF; a PDF cannot be shown in <img>, so it gets a "Lihat PDF" button instead.
--}}
<div class="row">
    <div class="col-md-3"></div>
    @foreach (['sijil_ssm' => 'Sijil SSM', 'lesen_kilang' => 'Lesen Kilang'] as $field => $label)
        <div class="col-md-4">
            <p>Fail Dimuat Naik ({{ $label }}):</p>
            @if (!empty($kilang_info->$field))
                @php
                    $docUrl = asset(str_replace('public', 'storage', $kilang_info->$field));
                    $docExt = strtolower(pathinfo($kilang_info->$field, PATHINFO_EXTENSION));
                @endphp
                @if ($docExt === 'pdf')
                    <a href="{{ $docUrl }}" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-file-pdf"></i> Lihat PDF</a>
                @else
                    <img src="{{ $docUrl }}" alt="{{ $label }}" style="width:100%;height:30vh;object-fit:contain;">
                    <div class="mt-1"><a href="{{ $docUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat / Muat Turun</a></div>
                @endif
            @else
                <p class="text-muted">Tiada fail dimuat naik</p>
            @endif
        </div>
    @endforeach
</div>
