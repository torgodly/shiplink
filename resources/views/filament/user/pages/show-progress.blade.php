<x-filament-panels::page>
    @if($record->status === 'Delivered' && $record->receiver_code === auth()->user()->receiver_code)
        <div>
            {{ $this->RatingAction }}

            <x-filament-actions::modals/>
        </div>
    @endif
    {{$this->activityTimelineInfolist}}
</x-filament-panels::page>
