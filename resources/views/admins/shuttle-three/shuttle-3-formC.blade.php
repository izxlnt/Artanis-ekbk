@extends('layouts.layout-user-nicepage-formC')

@section('content')

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            overflow: auto;
            /* height: 100px; */
            width: 200px;
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tbody th {
            position: sticky;
            left: 0;
        }

        /* Just common table stuff. Really. */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 8px;
        }

        th {
            background: #eee;
        }

        thead,
        tbody {
            display: block;
        }

        tbody {
            height: 500px;
            /* Just for the demo          */
            overflow-y: auto;
            /* Trigger vertical scroll    */
            overflow-x: hidden;
            /* Hide the horizontal scroll */
            width: 100%;
        }

    </style>

    @livewire('shuttle-three.form-c',['bulan_id' => $id])


    {{-- @livewire('user-table') --}}



@endsection
