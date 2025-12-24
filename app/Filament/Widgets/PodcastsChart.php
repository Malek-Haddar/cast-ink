<?php

namespace App\Filament\Widgets;

use App\Models\Podcast;
use Filament\Widgets\ChartWidget;

class PodcastsChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $heading = 'Episodes per Podcast';

    protected function getData(): array
    {
        $podcasts = Podcast::withCount('episodes')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Episodes',
                    'data' => $podcasts->pluck('episodes_count')->toArray(),
                    'backgroundColor' => '#fbbf24',
                    'borderColor' => '#fbbf24',
                ],
            ],
            'labels' => $podcasts->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
