<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Dashboards\Main as Dashboard;
use Nova\Start\Start;

class Main extends Dashboard
{
    public function name()
    {
        return 'Getting Started';
    }

    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards(): array
    {
        return [
            new Start,
        ];
    }
}
