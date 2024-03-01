<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
        rating: {{ $getState()??0 }},
        hoverRating: {{ $getHoverRating()??0 }},
        ratings: {{ $getRatings() }},
        rate(amount) {
            this.state = (this.state === amount) ? 0 : amount;
            this.rating = (this.rating === amount) ? 0 : amount;
        }

    }">
        <template x-for="i in ratings" :key="i">
            <button @click="rate(i)" @mouseover="hoverRating = i" @mouseleave="hoverRating = rating" aria-hidden="true"
                    type="{{ $getAutoSubmit() ? 'submit' : 'button'}}"
                    class="w-12 p-1 m-0 text-gray-400 rounded-sm cursor-pointer fill-current focus:outline-none focus:shadow-outline"
                    :class="{ 'text-gray-600': hoverRating >= i, 'text-yellow-400': rating >= i && hoverRating >= i  }">
                {{ svg(name:$getIcon(), class:'transition duration-150')  }}
            </button>
        </template>
        <input hidden="" x-model="state">
    </div>
</x-dynamic-component>
