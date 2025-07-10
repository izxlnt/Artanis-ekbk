<?php

namespace App\Http\Livewire;

use App\models\User;
use Kdion4891\LaravelLivewireTables\Column;
use Kdion4891\LaravelLivewireTables\TableComponent;

class UserTable extends TableComponent
{
    public $updatedmode = 0;
    public function query()
    {
        return User::query();
    }

    public function edit()
    {
        // dd("hello");
        $this->updatedmode = 1;
        // dd($this->updatedmode);
    }

    public function add()
    {
        $this->updatedmode = 1;
        // return view('home');

    }
    public function columns()
    {
        return [
            Column::make('ID')->searchable()->sortable(),
            Column::make('Name')->searchable()->sortable(),
            Column::make('Email')->searchable()->sortable(),
            Column::make('Created At')->searchable()->sortable(),
            Column::make('Updated At')->searchable()->sortable(),
            // Column::make('Action')

        ];
    }
}
