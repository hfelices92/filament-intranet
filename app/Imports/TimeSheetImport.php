<?php

namespace App\Imports;

use App\Models\Calendar;
use App\Models\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimeSheetImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            //dd($row);

            $calendar = Calendar::where('name', $row['calendarname'])->first();
            if ($calendar !== null) {

                Timesheet::create([
                    'calendar_id' => $calendar->id,
                    'user_id'     => Auth::user()->id,
                    'type'        => $row['type'],
                    'day_in'      => $row['day_in'],
                    'day_out'     => $row['day_out'],
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ]);
            }
        }
    }
}
