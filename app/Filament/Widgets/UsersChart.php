<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsersChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $heading = 'User Registrations';

    protected function getData(): array
    {
        $users = User::select('created_at')
            ->where('created_at', '>=', now()->subMonths(12))
            ->get()
            ->groupBy(function ($user) {
                return $user->created_at->format('Y-m');
            })
            ->map(fn ($users) => $users->count());

        $data = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $data->put($month, $users->get($month, 0));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Users joined',
                    'data' => $data->values()->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
