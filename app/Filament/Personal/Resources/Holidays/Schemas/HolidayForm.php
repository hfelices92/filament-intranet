<?php

namespace App\Filament\Personal\Resources\Holidays\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class HolidayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('calendar_id')
                    ->relationship('calendar', 'name')
                    ->required(),
                Hidden::make('user_id')
                    ->default(Auth::user()->id),
                DatePicker::make('day')
                    ->required(),
                Hidden::make('type')
                    ->default('pending'),
            ]);
    }
}
