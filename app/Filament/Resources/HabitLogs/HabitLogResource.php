<?php

namespace App\Filament\Resources\HabitLogs;

use App\Filament\Resources\HabitLogs\Pages\CreateHabitLog;
use App\Filament\Resources\HabitLogs\Pages\EditHabitLog;
use App\Filament\Resources\HabitLogs\Pages\ListHabitLogs;
use App\Filament\Resources\HabitLogs\Pages\ViewHabitLog;
use App\Filament\Resources\HabitLogs\Schemas\HabitLogForm;
use App\Filament\Resources\HabitLogs\Schemas\HabitLogInfolist;
use App\Filament\Resources\HabitLogs\Tables\HabitLogsTable;
use App\Models\HabitLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HabitLogResource extends Resource
{
    protected static ?string $model = HabitLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return HabitLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HabitLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HabitLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHabitLogs::route('/'),
            'create' => CreateHabitLog::route('/create'),
            'view' => ViewHabitLog::route('/{record}'),
            'edit' => EditHabitLog::route('/{record}/edit'),
        ];
    }
}
