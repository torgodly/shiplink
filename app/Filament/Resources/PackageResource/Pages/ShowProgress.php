<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use App\Models\Package;
use App\Traits\HasTimelineInfolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Resources\Pages\Page;
use Filament\Support\Concerns\HasBadge;
use Illuminate\Contracts\Support\Htmlable;

class ShowProgress extends Page implements HasInfolists
{
    use InteractsWithInfolists;
    use HasTimelineInfolist;
    use HasBadge;

    protected static string $resource = PackageResource::class;
    protected static string $view = 'filament.resources.package-resource.pages.show-progress';
    public Package $record;

    public function getTitle(): string|Htmlable
    {
        return __('Package Progress');
    }


}
