<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AccessCodeChart;
use App\Filament\Widgets\PodcastsChart;
use App\Filament\Widgets\PodcastStatsOverview;
use App\Filament\Widgets\UsersChart;
use App\Filament\Widgets\UserStatsOverview;
use Filament\Pages\Page;

class PlatformAnalytics extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected string $view = 'filament.pages.platform-analytics';

    protected static ?string $navigationLabel = 'Analytics';

    protected static ?string $title = 'Platform Analytics';

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
            PodcastStatsOverview::class,
            UsersChart::class,
            PodcastsChart::class,
            AccessCodeChart::class,
        ];
    }
}
