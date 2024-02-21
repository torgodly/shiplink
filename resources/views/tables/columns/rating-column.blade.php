
<div class="flex p-2">
    @for($i = 0; $i < 5; $i++)
        <div class="flex w-full rounded-sm   fill-current focus:outline-none focus:shadow-outline p-1 m-0
            {{ $getState() > $i ? 'text-yellow-400' : 'text-gray-400' }} ">
            <x-heroicon-c-star class="w-6 h-6 transition duration-150" />
            <!-- Add some content here if needed -->
        </div>
    @endfor
</div>
