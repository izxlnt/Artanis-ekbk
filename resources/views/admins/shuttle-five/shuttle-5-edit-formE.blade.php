@extends('layouts.layout-ibk-nicepage')

@section('content')

<style >

table, th, td {
  border: 1px solid black;
}
</style>

@livewire('shuttle-five.edit5-e',['bulan_id' => $id, 'ulasan_phd' => $ulasan_phd, 'shuttle_id' => $shuttle_id,  'form_5e_id' => $form_5e_id])

{{-- @livewire('user-table') --}}



@endsection
