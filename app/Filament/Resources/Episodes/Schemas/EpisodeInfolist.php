<?php

namespace App\Filament\Resources\Episodes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EpisodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('podcast.title')
                    ->label('Podcast'),
                TextEntry::make('title'),
                TextEntry::make('audio_path')
                    ->label('Audio Path')
                    ->url(fn ($record) => $record->audio_path ? asset('storage/' . $record->audio_path) : null, true)
                    ->copyable()
                    ->copyMessage('Path copied')
                    ->placeholder('-'),
                TextEntry::make('duration')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_free')
                    ->label('Free Episode')
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
