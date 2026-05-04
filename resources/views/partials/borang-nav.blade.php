@php
    /*
     * Variables expected:
     *   $shuttle_type  : int  — 3, 4, or 5
     *   $current_form  : string — 'A', 'B', 'C', 'D', or 'E'
     *   $role          : string — 'ipjpsm' or 'phd'
     */
    $forms = ['A', 'B', 'C', 'D'];
    if ($shuttle_type >= 4) $forms[] = 'E';

    $borderColors = [
        'A' => 'black',
        'B' => '#ee8dcd',
        'C' => '#bbb235',
        'D' => '#1b9e21',
        'E' => '#2692eb',
    ];

    $routeMap = [
        'ipjpsm' => [
            3 => ['A'=>'ipjpsm.borang-keseluruhan.shuttle3.borangA','B'=>'ipjpsm.borang-keseluruhan.shuttle3.borangB','C'=>'ipjpsm.borang-keseluruhan.shuttle3.borangC','D'=>'ipjpsm.borang-keseluruhan.shuttle3.borangD'],
            4 => ['A'=>'ipjpsm.borang-keseluruhan.shuttle4.borangA','B'=>'ipjpsm.borang-keseluruhan.shuttle4.borangB','C'=>'ipjpsm.borang-keseluruhan.shuttle4.borangC','D'=>'ipjpsm.borang-keseluruhan.shuttle4.borangD','E'=>'ipjpsm.borang-keseluruhan.shuttle4.borangE'],
            5 => ['A'=>'ipjpsm.borang-keseluruhan.shuttle5.borangA','B'=>'ipjpsm.borang-keseluruhan.shuttle5.borangB','C'=>'ipjpsm.borang-keseluruhan.shuttle5.borangC','D'=>'ipjpsm.borang-keseluruhan.shuttle5.borangD','E'=>'ipjpsm.borang-keseluruhan.shuttle5.borangE'],
        ],
        'phd' => [
            3 => ['A'=>'phd.senarai-tugasan-3A','B'=>'phd.senarai-tugasan-3B','C'=>'phd.senarai-tugasan-3C','D'=>'phd.senarai-tugasan-3D'],
            4 => ['A'=>'phd.senarai-tugasan-4A','B'=>'phd.senarai-tugasan-4B','C'=>'phd.senarai-tugasan-4C','D'=>'phd.senarai-tugasan-4D','E'=>'phd.senarai-tugasan-4E'],
            5 => ['A'=>'phd.senarai-tugasan-5A','B'=>'phd.senarai-tugasan-5B','C'=>'phd.senarai-tugasan-5C','D'=>'phd.senarai-tugasan-5D','E'=>'phd.senarai-tugasan-5E'],
        ],
    ];

    $ajaxRoute = $role === 'ipjpsm' ? 'ajax.count.ipjpsm.detail' : 'ajax.count.phd.detail';
    $partialId = 'borang_nav_' . $role . '_s' . $shuttle_type . '_' . uniqid();
@endphp

<div class="row" id="{{ $partialId }}">
    <div class="col-md-12" style="position:relative">
        @foreach($forms as $form)
        @php
            $isActive = $current_form === $form;
            $bg       = $isActive ? 'rgb(196,188,186)' : 'white';
            $border   = $borderColors[$form];
            $routeName = $routeMap[$role][$shuttle_type][$form];
        @endphp
        <a href="{{ route($routeName, date('Y')) }}"
           class="btn borang-nav-btn"
           style="background-color:{{ $bg }};color:black;border-color:{{ $border }};position:relative;margin-right:4px;margin-bottom:4px">
            Borang {{ $shuttle_type }}{{ $form }}
            <span class="badge badge-pill badge-danger nav-form-badge"
                  data-form="form{{ $form }}"
                  style="position:absolute;top:-8px;right:-8px;font-size:10px;display:none">0</span>
        </a>
        @endforeach
    </div>
</div>

<script>
(function(){
    var pid     = '#{{ $partialId }}';
    var ajaxUrl = "{{ route($ajaxRoute) }}";
    $.get(ajaxUrl, { shuttle_type: {{ $shuttle_type }} }, function(data) {
        $(pid).find('.nav-form-badge').each(function(){
            var key   = $(this).data('form');
            var count = data[key];
            if(count && count > 0){
                $(this).text(count).show();
            }
        });
    });
})();
</script>
