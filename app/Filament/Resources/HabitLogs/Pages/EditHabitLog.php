<?php

namespace App\Filament\Resources\HabitLogs\Pages;

use App\Filament\Resources\HabitLogs\HabitLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHabitLog extends EditRecord
{
    protected static string $resource = HabitLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
