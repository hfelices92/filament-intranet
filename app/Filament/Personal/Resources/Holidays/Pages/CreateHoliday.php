<?php

namespace App\Filament\Personal\Resources\Holidays\Pages;

use App\Filament\Personal\Resources\Holidays\HolidayResource;
use App\Mail\HolidayPending;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
    // Alternativa a los Hidden en el Form Schema
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $user = Auth::user();
        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'day' => $data['day'],
        ];
        Mail::to('feligo.dev@gmail.com')->send(new HolidayPending($mailData));
        Notification::make()
            ->title('Solicitud de día libre')
            ->body('Se ha enviado una notificación al administrador para la aprobacion del dia '.$data['day'].'.')
            ->sendToDatabase(Auth::user());
        return $data;
    }

}
