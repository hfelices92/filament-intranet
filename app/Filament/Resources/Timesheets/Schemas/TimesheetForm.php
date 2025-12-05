<?php

namespace App\Filament\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

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
                Select::make('user_id')
                    ->options(function () {
                        return \App\Models\User::all()->pluck('name', 'id')->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->preload(),
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
