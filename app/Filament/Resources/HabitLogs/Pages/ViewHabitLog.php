<?php

namespace App\Filament\Resources\HabitLogs\Pages;

use App\Filament\Resources\HabitLogs\HabitLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHabitLog extends ViewRecord
{
    protected static string $resource = HabitLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
