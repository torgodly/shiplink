<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Package;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $packages = Package::all();
        $users = User::where('type', 'user')->get();
        $branches = Branch::all();
        $totalRating = $packages->where('rating', '!=', 0)->sum('rating');
        $totalCount = $packages->where('rating', '!=', 0)->count();

        $avgRating = $totalCount > 0 ? round($totalRating / $totalCount, 1) : 0;

        //revenue
        $revenue = $packages->sum('price');

        //most Active Branch
        $mostActiveBranch = $branches->sortByDesc(function ($branch) {
            return $branch->sentPackages->count() + $branch->receivedPackages->count();
        })->first();

//        dd($mostActiveBranch);

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

            Stat::make(__('Total Users'), $users->count())
                ->color('green')
                ->description(__('Total number of registered users'))
                ->descriptionIcon('tabler-users')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Total Branches'), $branches->count())
                ->color('orange')
                ->description(__('Total number of branches operating'))
                ->descriptionIcon('heroicon-o-building-office')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Total Revenue'), \Number::currency($revenue, 'LYD', 'ar_LY'))
                ->color('green')
                ->description(__('Total revenue generated'))
                ->descriptionIcon('heroicon-o-banknotes')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make(__('Most Active Branch'), $mostActiveBranch?->name)
                ->color('blue')
                ->description(__('Branch with the highest activity'))
                ->descriptionIcon('heroicon-o-building-office')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

        ];

    }
}
