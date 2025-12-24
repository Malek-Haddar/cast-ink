<?php

namespace App\Filament\Widgets;

use App\Models\Episode;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestEpisodes extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;

    use \Filament\Widgets\Concerns\InteractsWithPageFilters;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Episode::query()
                    ->when($this->filters['startDate'], fn ($query) => $query->whereDate('created_at', '>=', $this->filters['startDate']))
                    ->when($this->filters['endDate'], fn ($query) => $query->whereDate('created_at', '<=', $this->filters['endDate']))
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('podcast.title')
                    ->label('Podcast'),
                Tables\Columns\IconColumn::make('is_free')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
