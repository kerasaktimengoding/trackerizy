<?php

namespace App\Filament\Resources\HabitLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HabitLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('habit_id')
                    ->relationship('habit', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('count')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('completed')
                    ->required(),
            ]);
    }
}
