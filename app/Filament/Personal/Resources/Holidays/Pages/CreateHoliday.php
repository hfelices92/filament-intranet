<?php

namespace App\Filament\Personal\Resources\Holidays\Pages;

use App\Filament\Personal\Resources\Holidays\HolidayResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
    // Alternativa a los Hidden en el Form Schema
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['user_id'] = Auth::user()->id;

    //     return $data;
    // }
}
