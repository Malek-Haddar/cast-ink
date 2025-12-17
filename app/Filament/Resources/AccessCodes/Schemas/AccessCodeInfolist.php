<?php

namespace App\Filament\Resources\AccessCodes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccessCodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('podcast.title')
                    ->label('Podcast'),
                TextEntry::make('user.name')
                    ->label('Used By')
                    ->placeholder('-'),
                IconEntry::make('is_used')
                    ->label('Used')
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
