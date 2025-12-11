<?php

namespace App\Filament\Resources\Holidays\Pages;

use App\Filament\Resources\Holidays\HolidayResource;
use App\Mail\HolidayApproved;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if($record->type === 'accepted'){
            $user = $record->user;
            $mailData = [
                'name' => $user->name,
                'email' => $user->email,
                'day' => $record->day,
            ];
            Mail::to('feligo.dev@gmail.com')->send(new HolidayApproved($mailData));
        }

        return $record;
    }
}
