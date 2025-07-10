@extends('layouts.layout-ibk-nicepage')

@section('content')

<style >

table, th, td {
  border: 1px solid black;
}
</style>

@livewire('shuttle-four.form-b',['suku_id' => $id])
{{-- @livewire('shuttle-four.form-b') --}}

{{-- @livewire('user-table') --}}



@endsection
