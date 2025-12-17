<?php

namespace App\Filament\Resources\Episodes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EpisodeForm
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
                TextInput::make('title')
                    ->required(),
                FileUpload::make('audio_path')
                    ->label('Audio')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav', 'audio/flac'])
                    ->directory('episodes')
                    ->disk('local')
                    ->visibility('private')
                    ->downloadable()
                    ->openable()
                    ->required(),
                TextInput::make('duration')
                    ->numeric(),
                Toggle::make('is_free')
                    ->label('Free Episode')
                    ->default(false),
            ]);
    }
}
