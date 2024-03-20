<?php

namespace App\Filament\Widgets;

use App\Enums\ShippingStatus;
use App\Models\Package;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class StatusChart extends ChartWidget
{
    protected static ?string $heading = 'Packages by Status';
    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
        ],
    ];
    public ?string $filter = 'week';
    protected int|string|array $columnSpan = 1;

    protected static ?string $maxHeight = '250px';

    public function getHeading(): string|Htmlable|null
    {
        return __(parent::getHeading()); // TODO: Change the autogenerated stub
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'اليوم',
            'week' => 'الأسبوع',
            'month' => 'الشهر',
            'year' => 'السنة',
        ];
    }

    protected function getData(): array
    {

// Get the count of packages for each status
        $statusCounts = Package::selectRaw('status, count(*) as count')
            ->when(auth()->user()->is_manager, function ($query) {
                $query->where('sender_branch_id', auth()->user()->mangedbrance->id)->orWhere('receiver_branch_id', auth()->user()->mangedbrance->id);
            })
            ->when($this->filter === 'today', function ($query) {
                $query->whereDate('created_at', today());
            })
            //if its week then get the last 7 days
            ->when($this->filter === 'week', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(7), now()]);
            })
            //if its month then get the last 30 days
            ->when($this->filter === 'month', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(30), now()]);
            })
            //if its year then get the last 365 days
            ->when($this->filter === 'year', function ($query) {
                $query->whereBetween('created_at', [now()->subDays(365), now()]);
            })
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

// Define the order of statuses
        $statuses = ShippingStatus::values();

// Get counts for all statuses, filling in 0 where necessary
        $statusData = collect($statuses)->map(function ($status) use ($statusCounts) {
            return $statusCounts[$status] ?? 0;
        })->values()->all();
// Combine datasets and labels into the desired format
        $result = [
            'datasets' => [
                [
                    'label' => 'Packages by Status',
                    'data' => $statusData,
                    'backgroundColor' => [
                        '#FF8C00',
                        '#36A2EB',
                        '#32CD32',
                        '#FF4500',
                        '#FFD700',
                    ]
                    ,
                    'hoverOffset'=> 10
                ],

            ],
            'labels' => array_map(fn($status) => __($status), $statuses)


        ];

//        dd($result);

        return $result;
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
