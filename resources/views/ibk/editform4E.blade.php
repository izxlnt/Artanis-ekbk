@extends('layouts.layout-ibk-nicepage')

@section('content')
<div>
    @livewire('shuttle-four.editform4e',['shuttle_id' => $id]);
</div>
@endsection
