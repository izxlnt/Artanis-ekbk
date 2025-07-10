@extends('layouts.layout-ibk-nicepage')

@section('content')
<div>
    @livewire('shuttle-three.edit-form3-b',['shuttle_id' => $id]);
</div>
@endsection
