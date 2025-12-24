<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestUsers extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;
    use \Filament\Widgets\Concerns\InteractsWithPageFilters;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->when($this->filters['startDate'], fn ($query) => $query->whereDate('created_at', '>=', $this->filters['startDate']))
                    ->when($this->filters['endDate'], fn ($query) => $query->whereDate('created_at', '<=', $this->filters['endDate']))
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Joined'),
            ]);
    }
}
