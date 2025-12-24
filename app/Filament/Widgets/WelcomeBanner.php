<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeBanner extends Widget
{
    protected string $view = 'filament.widgets.welcome-banner';
    
    protected static ?int $sort = -1; // Show at the very top

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'podcastCount' => \App\Models\Podcast::count(),
            'episodeCount' => \App\Models\Episode::count(),
        ];
    }
}
