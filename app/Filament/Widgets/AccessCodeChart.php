<?php

namespace App\Filament\Widgets;

use App\Models\AccessCode;
use Filament\Widgets\ChartWidget;

class AccessCodeChart extends ChartWidget
{
    protected static bool $isDiscovered = false;

    protected ?string $heading = 'Access Code Usage';

    protected function getData(): array
    {
        $used = AccessCode::where('is_used', true)->count();
        $unused = AccessCode::where('is_used', false)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Access Codes',
                    'data' => [$used, $unused],
                    'backgroundColor' => ['#ef4444', '#22c55e'],
                ],
            ],
            'labels' => ['Used', 'Unused'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
