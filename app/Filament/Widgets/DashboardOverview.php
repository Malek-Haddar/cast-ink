<?php

namespace App\Filament\Widgets;

use App\Models\Episode;
use App\Models\Podcast;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    use \Filament\Widgets\Concerns\InteractsWithPageFilters;

    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        return [
            Stat::make('Active Podcasts', Podcast::where('is_published', true)
                ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                ->count())
                ->description('Publicly available')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Total Content', Episode::query()
                ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                ->count() . ' Episodes')
                ->description('Across all series')
                ->descriptionIcon('heroicon-m-musical-note')
                ->color('info'),
            Stat::make('Community', User::query()
                ->when($startDate, fn ($query) => $query->whereDate('created_at', '>=', $startDate))
                ->when($endDate, fn ($query) => $query->whereDate('created_at', '<=', $endDate))
                ->count() . ' Members')
                ->description('Registered listeners')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
        ];
    }
}
