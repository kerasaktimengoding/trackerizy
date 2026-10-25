<?php

namespace App\Filament\Resources\Habits\Pages;

use App\Filament\Resources\Habits\HabitResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHabit extends ViewRecord
{
    protected static string $resource = HabitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
