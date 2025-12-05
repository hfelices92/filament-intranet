<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Dom\Text;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->icon(Heroicon::OutlinedUser)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                       
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn($state) => filled($state))
                            
                            ->helperText('Leave blank to keep the current password.')

                            ,
                        
                    ]),
                Section::make('Address Information')
                    ->icon(Heroicon::MapPin)
                    ->columns(3)
                    ->schema([
                        Select::make('country_id')
                            //  ->relationship(name: 'country', titleAttribute: 'name') 
                            ->relationship('country', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->optionsLimit(Country::count())
                            ->noSearchResultsMessage('No country found.')
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->required(),
                        Select::make('state_id')
                            ->label('State/Province')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                             ->reactive()
                            ->noSearchResultsMessage('No states found.')
                            ->afterStateUpdated(function (Set $set) {
                                $set('city_id', null);
                            })
                            ->required(),
                        Select::make('city_id')
                            ->label('City')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->noSearchResultsMessage('No states found.')
                            ->required(),
                        TextInput::make('address')
                            ->label('Address')
                            ->required(),
                        TextInput::make('postal_code')
                            ->label('Postal Code')
                            ->required(),
                    ])

            ])->columns(1);
    }
}
