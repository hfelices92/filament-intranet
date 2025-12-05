<?php

namespace App\Filament\Personal\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class TimesheetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('calendar_id')
                    ->relationship('calendar', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Hidden::make('user_id')
                    ->default(Auth::user()->id)
                    ->required(),
                Select::make('type')
                    ->options([
                        'work' => 'Work',
                        'pause' => 'Pause'
                    ])
                    ->required()->default('work'),
                DateTimePicker::make('day_in')
                    ->required(),
                DateTimePicker::make('day_out')
                    ->required(),
            ]);
    }
}
