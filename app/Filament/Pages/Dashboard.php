<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function getColumns(): int | array
    {
        return 2;
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\WelcomeBanner::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DashboardOverview::class,
            \App\Filament\Widgets\LatestEpisodes::class,
            \App\Filament\Widgets\LatestUsers::class,
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate'),
                        DatePicker::make('endDate'),
                    ])
                    ->columns(2)
                    ->columnSpan('full'),
            ]);
    }
}