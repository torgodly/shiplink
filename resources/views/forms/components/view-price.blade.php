<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        @php
            $data = (object) collect($this->data)->toArray();
            $price = \App\Models\Package::getPrice(weight: $data->weight, height: $data->height, width: $data->width, length: $data->length, fragile: $data->fragile, fast_shipping: $data->fast_shipping, shipping_method: $data->shipping_method, insurance: $data->insurance, is_refrigerated: $data->is_refrigerated)

        @endphp
        <p class="text-5xl text-black text-center">{{ $price }}د.ل</p>
    </div>
</x-dynamic-component>
