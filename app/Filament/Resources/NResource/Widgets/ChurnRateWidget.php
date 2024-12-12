<?php

namespace App\Filament\Resources\NResource\Widgets;

use Filament\Widgets\ChartWidget;

class ChurnRateWidget extends ChartWidget
{
    protected static ?string $heading = 'Churn Rate';

    protected function getData(): array
    {
        $churnedSubscribers = 250;
        $activeSubscribers = 1000;
        $newSubscribers = 300;

        return [
            'datasets' => [
                [
                    'label' => 'Subscriber Status',
                    'data' => [$churnedSubscribers, $activeSubscribers, $newSubscribers],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Churned', 'Active', 'New'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public static function canView(): bool
    {
        return auth()->user()->hasPermissionTo('read_dashboard');
    }
}
