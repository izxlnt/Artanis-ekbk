@extends('layouts.layout-ibk-nicepage')

@section('content')

<style >

table, th, td {
  border: 1px solid black;
}
</style>

@livewire('shuttle-five.form-d',['bulan_id' => $id, 'form_c_data'=> $form_c_data])

{{-- @livewire('user-table') --}}



@endsection
