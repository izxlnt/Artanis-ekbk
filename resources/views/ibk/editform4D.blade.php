@extends('layouts.layout-ibk-nicepage')

@section('content')

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

</style>

    @livewire('shuttle-four.editform4d',['bulan_id' => $id]);

@endsection
