<?php

namespace App\Filament\Personal\Resources\Timesheets\Pages;

use App\Filament\Personal\Resources\Timesheets\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('inWork')
                ->label('Entrada')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->user_id = $user->id;
                    $timesheet->calendar_id =1;
                    $timesheet->type = 'work';
                    $timesheet->day_in = Carbon::now();
                    $timesheet->day_out = Carbon::now();
                    $timesheet->save();
                })
               ,
            Action::make('inPause')
                ->label('Pausa')
                ->color('primary')
                ->requiresConfirmation()
               ,
            CreateAction::make()->color('info'),
        ];
    }
}
