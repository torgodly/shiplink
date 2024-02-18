<?php

namespace App\Filament\User\Pages;

use App\Enums\ShippingStatus;
use App\Forms\Components\Rating;
use App\Models\Package;
use App\Traits\HasRatingAction;
use App\Traits\hasTimelineInfolist;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use IbrahimBougaoua\FilamentRatingStar\Actions\RatingStar;
use Illuminate\Support\Arr;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ShowProgress extends Page implements HasInfolists, HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithInfolists;
    use HasTimelineInfolist;
    use HasRatingAction;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'show-progress/{record}/show';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $view = 'filament.user.pages.show-progress';

    public $record;

    public function mount(Package $record)
    {
        $this->record = $record;
            //mountAction('Rating')
    }



}
