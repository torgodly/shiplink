<?php

namespace App\Filament\Office\Resources\PackageResource\Pages;

use App\Enums\ShippingStatus;
use App\Filament\Office\Resources\PackageResource;
use App\Models\Package;
use App\Traits\HasChangeStatusAction;
use App\Traits\HasTimelineInfolist;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Support\Concerns\HasBadge;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Arr;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ShowProgress extends Page implements HasInfolists, HasActions, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithActions;
    use InteractsWithForms;
    use HasBadge;
    //our custom trait
    use HasTimelineInfolist;
    use HasChangeStatusAction;

//    use InteractsWithRecord;

    protected static string $resource = PackageResource::class;
    protected static string $view = 'filament.office.resources.package-resource.pages.show-progress';
    public Package $record;

    public function getTitle(): string|Htmlable
    {
        return __('Package Progress');
    }




}
