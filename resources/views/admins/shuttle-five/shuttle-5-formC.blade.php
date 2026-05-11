@extends('layouts.layout-user-nicepage-formC')

@section('content')

<style >

table, th, td {
  border: 1px solid black;
}
</style>

@livewire('shuttle-five.form-c', ['month' => $id, 'year' => $year])

{{-- @livewire('user-table') --}}



@endsection
