<x-filament-panels::page>
    <div>
        <div class="flex justify-between items-center">
            {{ $this->PendingAction }}
            {{ $this->ProcessingAction}}
            {{$this->OutForDeliveryAction}}
            {{$this->InTransitAction}}
            {{$this->WaitingForPickupAction}}
            {{$this->ReturnedAction}}
            {{$this->DeliveredAction}}
        </div>



        <x-filament-actions::modals/>
    </div>
    {{$this->activityTimelineInfolist}}

</x-filament-panels::page>
