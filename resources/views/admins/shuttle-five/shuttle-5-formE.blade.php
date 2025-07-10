@extends('layouts.layout-ibk-nicepage')

@section('content')

<style >

table, th, td {
  border: 1px solid black;
}
</style>

@livewire('shuttle-five.form-e',['bulan_id' => $id])

{{-- @livewire('user-table') --}}



@endsection
