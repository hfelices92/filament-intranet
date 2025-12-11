<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function TimeSheetRecords(User $user){
        $timesheets = $user->timesheets;
        $pdf = Pdf::loadView('pdf.example', ['timesheets' => $timesheets]);
        return $pdf->download('timesheet_records.pdf');
    }
}
