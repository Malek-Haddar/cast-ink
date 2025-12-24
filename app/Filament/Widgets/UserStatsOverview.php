<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    protected static bool $isDiscovered = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            Stat::make('New Users (This Month)', User::where('created_at', '>=', now()->startOfMonth())->count())
                ->description('Users joined this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
            Stat::make('Verified Users', User::whereNotNull('email_verified_at')->count())
                ->description('Users with verified email')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('info'),
            Stat::make('Users with Podcast Access', User::has('podcasts')->count())
                ->description('Users who can access podcasts')
                ->descriptionIcon('heroicon-m-microphone')
                ->color('primary'),
        ];
    }
}
