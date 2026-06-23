{{-- Variables: $form (model|null), $fillLink, $viewLink, $isDue --}}
@if($isDue)
    @php $status = $form ? $form->status : 'Tidak Diisi'; @endphp
    @if($status === 'Ditutup')
        <span data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka">
            <i class="fas fa-lock text-muted"></i>
        </span>
    @elseif($status === 'Tidak Diisi')
        <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang belum diisi">
            <img src="{{ asset('circle_times.png') }}" height="28">
        </a>
    @elseif($status === 'Tidak Lengkap' || $status === 'Sedang Diisi')
        <a href="{{ $fillLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang tidak lengkap">
            <img src="{{ asset('pencil.png') }}" height="28">
        </a>
    @elseif($status === 'Sedang Diproses' || $status === 'Tiada Pengeluaran')
        <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah dihantar">
            <img src="{{ asset('circle_check_yellow.png') }}" height="28">
        </a>
    @else
        <a href="{{ $viewLink }}" data-toggle="tooltip" data-placement="bottom" title="Borang telah disahkan">
            <img src="{{ asset('circle_check.png') }}" height="28">
        </a>
    @endif
@else
    @if($form && $form->status === 'Ditutup')
        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="bottom" title="Borang belum dibuka untuk bulan ini">Ditutup</span>
    @else
        <span class="text-muted">-</span>
    @endif
@endif
