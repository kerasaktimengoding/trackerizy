<?php

namespace App\Filament\Resources\HabitLogs\Pages;

use App\Filament\Resources\HabitLogs\HabitLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHabitLogs extends ListRecords
{
    protected static string $resource = HabitLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
