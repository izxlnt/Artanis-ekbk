<?php

namespace App\Imports;

use App\Models\Shuttle;
use Maatwebsite\Excel\Concerns\ToModel;

class LaporanTigaTiga implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Shuttle([
            'venue'     => $row[1],
            'car_radius'    => $row[2],
            'walking_radius'    => $row[3],
            'longitude'    => $row[1],
            'latitude'    => $row[5],
            'level'    => $row[6],
            'size'    => $row[7],
            'banquet'    => $row[8],
            'classroom'    => $row[9],
            'theater'    => $row[10],
            'cocktail'     => $row[11],
            'cabaret'    => $row[12],
            'booth_capacity'    => $row[13],
            'daily_rate'    => $row[14],
            'thumbnail'     => $row[15],
            'hotel_id'    => $row[16]
        ]);
    }
}
