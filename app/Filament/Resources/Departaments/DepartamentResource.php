<?php

namespace App\Filament\Resources\Departaments;

use App\Filament\Resources\Departaments\Pages\CreateDepartament;
use App\Filament\Resources\Departaments\Pages\EditDepartament;
use App\Filament\Resources\Departaments\Pages\ListDepartaments;
use App\Filament\Resources\Departaments\Schemas\DepartamentForm;
use App\Filament\Resources\Departaments\Tables\DepartamentsTable;
use App\Models\Departament;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DepartamentResource extends Resource
{
    protected static ?string $model = Departament::class;
    protected static string | UnitEnum | null $navigationGroup = 'Systems Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DepartamentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartamentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartaments::route('/'),
            'create' => CreateDepartament::route('/create'),
            'edit' => EditDepartament::route('/{record}/edit'),
        ];
    }
}
