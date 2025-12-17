<?php

namespace App\Filament\Resources\Podcasts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PodcastForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->label('Cover Image')
                    ->image()
                    ->directory('covers')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->downloadable()
                    ->openable()
                    ->hint('Stored in public/covers'),
                Toggle::make('is_published')
                    ->label('Published')
                    ->default(false),
            ]);
    }
}
