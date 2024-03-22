<?php

namespace App\Filament\Office\Widgets;

use App\Models\Branch;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $branch = \Auth::user()->mangedbrance()->with('sentPackages', 'receivedPackages',)->first();
        $packages = $branch->packages;
        $nonZeroPackages = $packages->where('rating', '!=', 0);

        if ($nonZeroPackages->count() > 0) {
            $avgRating = round($nonZeroPackages->sum('rating') / $nonZeroPackages->count(), 1);
        } else {
            $avgRating = 0;
        }
        $revenue = $packages->sum('price');
        $sentPackages = $branch->sentPackages->count();
        $receivedPackages = $branch->receivedPackages->count();

        //branch rank based on sent and received packages
        $branchRank = Branch::all()->sortByDesc(function ($branch) {
                return $branch->sentPackages->count() + $branch->receivedPackages->count();
            })->pluck('id')->search($branch->id) + 1;

        return [
            //$avgRating
            Stat::make(__('Average Rating'), $avgRating)
                ->color('yellow')
                ->description(__('Based on the average rating across all packages'))
                ->descriptionIcon('heroicon-c-star')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Total Packages'), $packages->count())
                ->color('blue')
                ->description(__('Total number of packages available'))
                ->descriptionIcon('tabler-package')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            //branch rank
            Stat::make(__('Branch Rank'), $branchRank)
                ->color('green')
                ->description(__('Based on the total number of sent and received packages'))
                ->descriptionIcon('tabler-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Sent Packages'), $sentPackages)
                ->color('green')
                ->description(__('Total number of packages sent'))
                ->descriptionIcon('tabler-package-export')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Received Packages'), $receivedPackages)
                ->color('green')
                ->description(__('Total number of packages received'))
                ->descriptionIcon('tabler-package-import')
                ->chart([7, 2, 10, 3, 15, 4, 17]),


            Stat::make(__('Total Revenue'), \Number::currency($revenue, 'LYD', 'ar_LY'))
                ->color('green')
                ->description(__('Total revenue generated'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

        ];

    }
}
