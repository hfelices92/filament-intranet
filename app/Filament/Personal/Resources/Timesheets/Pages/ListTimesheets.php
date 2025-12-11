<?php

namespace App\Filament\Personal\Resources\Timesheets\Pages;

use App\Filament\Personal\Resources\Timesheets\TimesheetResource;
use App\Imports\TimeSheetImport;
use App\Models\Timesheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {

        $lastTimesheet = Timesheet::where('user_id', Auth::id())
            ->latest()
            ->first();


        return [
            Action::make('inWork')
                ->label('Entrada')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn() => !$lastTimesheet || $lastTimesheet->day_out !== null)
                ->disabled(fn() => $lastTimesheet && $lastTimesheet->day_out === null)
                ->action(function () {
                    $user = Auth::user();
                    $timesheet = new Timesheet();
                    $timesheet->user_id = $user->id;
                    $timesheet->calendar_id = 1;
                    $timesheet->type = 'work';
                    $timesheet->day_in = Carbon::now();
                    $timesheet->save();
                    Notification::make()
                        ->title('Jornada iniciada')
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('inPause')
                ->label('Pausa')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn() => $lastTimesheet && $lastTimesheet->day_out === null && $lastTimesheet->type === 'work')
                ->disabled(fn() => !$lastTimesheet || $lastTimesheet->day_out !== null || $lastTimesheet->type !== 'work')
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();

                    $timesheet = new Timesheet();
                    $timesheet->user_id = Auth::id();
                    $timesheet->calendar_id = 1;
                    $timesheet->type = 'pause';
                    $timesheet->day_in = Carbon::now();
                    $timesheet->save();

                    Notification::make()
                        ->title('Pausa iniciada')
                        ->success()
                        ->send();
                }),
            Action::make('stopPause')
                ->label('Detener Pausa')
                ->color('primary')
                ->requiresConfirmation()
                ->visible(fn() => $lastTimesheet && $lastTimesheet->day_out === null && $lastTimesheet->type === 'pause')
                ->disabled(fn() => !$lastTimesheet || $lastTimesheet->day_out !== null || $lastTimesheet->type !== 'pause')
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();

                    $timesheet = new Timesheet();
                    $timesheet->user_id = Auth::id();
                    $timesheet->calendar_id = 1;
                    $timesheet->type = 'work';
                    $timesheet->day_in = Carbon::now();
                    $timesheet->save();
                    Notification::make()
                        ->title('Pausa finalizada')
                        ->success()
                        ->send();
                }),
            Action::make('stopWork')
                ->label('Salida')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn() => $lastTimesheet && $lastTimesheet->day_out === null)
                ->disabled(fn() => !$lastTimesheet || $lastTimesheet->day_out !== null)
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    Notification::make()
                        ->title('Jornada finalizada')
                        ->success()
                        ->send();
                }),
            CreateAction::make()->color('info'),
            ExcelImportAction::make()
                ->use(TimeSheetImport::class)
                ->slideOver()
                ->label('Importar Horarios')
                ->color('info'),
            Action::make('createPdf')
                ->label('Crear PDF')

                ->color('warning')
                ->requiresConfirmation()
                ->url(
                    fn(): string => route('pdf.example', ['user'=> Auth::user()]), 
                    shouldOpenInNewTab: true
                ),
        ];
    }
}
