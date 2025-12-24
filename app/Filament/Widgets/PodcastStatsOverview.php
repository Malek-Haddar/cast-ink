<?php

namespace App\Filament\Widgets;

use App\Models\AccessCode;
use App\Models\Episode;
use App\Models\Podcast;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PodcastStatsOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Podcasts', Podcast::count())
                ->description('Podcasts in the platform')
                ->descriptionIcon('heroicon-m-microphone')
                ->color('primary'),
            Stat::make('Total Episodes', Episode::count())
                ->description('Episodes across all podcasts')
                ->descriptionIcon('heroicon-m-play-circle')
                ->color('success'),
            Stat::make('Access Codes', AccessCode::count())
                ->description(AccessCode::where('is_used', true)->count() . ' used / ' . AccessCode::where('is_used', false)->count() . ' remaining')
                ->descriptionIcon('heroicon-m-key')
                ->color('warning'),
        ];
    }
}
