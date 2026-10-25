<?php

namespace App\Filament\Resources\HabitLogs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HabitLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('habit.name')
                    ->label('Habit'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('count')
                    ->numeric(),
                IconEntry::make('completed')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
