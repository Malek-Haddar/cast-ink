<?php

namespace App\Filament\Resources\AccessCodes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccessCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('podcast_id')
                    ->relationship('podcast', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true),
                Toggle::make('is_used')
                    ->label('Already Used')
                    ->default(false),
                Select::make('used_by')
                    ->label('Used By')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }
}
