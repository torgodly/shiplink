<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class PackageChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Packages by Branch';
    protected int|string|array $columnSpan = 1;


    public function getHeading(): string|Htmlable|null
    {
        return __(parent::getHeading()); // TODO: Change the autogenerated stub
    }

    protected function getData(): array
    {
        $sent = [];
        $received = [];
        $branches = Branch::with('sentPackages', 'receivedPackages')->get();

        foreach ($branches as $branch) {
            $sent[] = $branch->sent_count;
            $received[] = $branch->received_count;
        }

        return [
            'datasets' => [
                [
                    'label' => __('Sent Packages'),
                    'data' => $sent,
                    'backgroundColor' => '#247DFF',
                    'borderColor' => '#247DFF',
                    'borderWidth' => 1,
                ],
                [
                    'label' => __('Received Packages'),
                    'data' => $received,
                    'backgroundColor' => '#FADD02',
                    'borderColor' => '#FADD02',
                    'borderWidth' => 1,
                ]
            ],
            'labels' => $branches->pluck('name')->toArray(),
        ];

    }

    protected function getType(): string
    {
        return 'bar';
    }
}