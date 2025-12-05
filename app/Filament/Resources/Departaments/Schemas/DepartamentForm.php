<?php

namespace App\Filament\Resources\Departaments\Schemas;


use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepartamentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Departament Name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
