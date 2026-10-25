<?php

namespace App\Filament\Resources\HabitLogs\Pages;

use App\Filament\Resources\HabitLogs\HabitLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHabitLog extends CreateRecord
{
    protected static string $resource = HabitLogResource::class;
}
