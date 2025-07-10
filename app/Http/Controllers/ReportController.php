<?php

namespace App\Http\Controllers;

use App\Models\Shuttle;
use PdfReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function displayReport(Request $request)
{
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $sortBy = $request->input('sort_by');

    $title = 'Registered User Report'; // Report title

    $meta = [ // For displaying filters description on header
        'Registered on' => $fromDate . ' To ' . $toDate,
        'Sort By' => $sortBy
    ];

    $queryBuilder = Shuttle::select(['nama_kilang']); // Do some querying..


    // dd($meta);

    $columns = [ // Set Column to be displayed
        'Shuttle' => 'shuttle_type',
        // 'Registered At', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result
        'Nama Kilang' => 'nama_kilang',

    ];

    // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
    return PdfReport::of($title, $meta, $queryBuilder,$columns)

                    // ->editColumn('Registered At', [ // Change column class or manipulate its data for displaying to report
                    //     'displayAs' => function($result) {
                    //         return $result->registered_at->format('d M Y');
                    //     },
                    //     'class' => 'left'
                    // ])
                    ->editColumns(['Total Balance', 'nama_kilang'], [ // Mass edit column
                        'class' => 'right bold'
                    ])
                    // ->showTotal([
                    //     'Total Balance' => 'point' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                    // ])
                    ->limit(20)
                    ->stream();
  }
}
