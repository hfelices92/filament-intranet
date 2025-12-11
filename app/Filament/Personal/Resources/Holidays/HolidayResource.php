<?php

namespace App\Filament\Personal\Resources\Holidays;

use App\Filament\Personal\Resources\Holidays\Pages\CreateHoliday;
use App\Filament\Personal\Resources\Holidays\Pages\EditHoliday;
use App\Filament\Personal\Resources\Holidays\Pages\ListHolidays;
use App\Filament\Personal\Resources\Holidays\Schemas\HolidayForm;
use App\Filament\Personal\Resources\Holidays\Tables\HolidaysTable;
use App\Models\Holiday;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::user()->id);
    }
    public static function getNavigationBadge(): ?string
    {
        $badge = Holiday::where('user_id', Auth::user()->id)->where('type', 'pending')->count();
        return $badge > 0 ? (string)$badge : null;
    }

     public static function getNavigationBadgeColor(): string|array|null
     {
        return 'danger';
     }
public static function getNavigationBadgeTooltip(): string|Htmlable|null
{
    return 'Solicitudes pendientes de aprobación';
}

     public static function getModelLabel(): string
    {
        return 'Día Libre';
    }
   

    public static function getNavigationLabel(): string
    {
        return 'Mis Días Libres';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Días Libres';
    }
    public static function form(Schema $schema): Schema
    {
        return HolidayForm::configure($schema);
    }
 
    public static function table(Table $table): Table
    {
        return HolidaysTable::configure($table);
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
            'index' => ListHolidays::route('/'),
            'create' => CreateHoliday::route('/create'),
            'edit' => EditHoliday::route('/{record}/edit'),
        ];
    }
}
