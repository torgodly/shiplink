<link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.4/tailwind.min.css" rel="stylesheet"/>

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
        rating: 2,
		hoverRating: 2,
		ratings: 5,

		rate(amount) {
		//log the amount
		console.log(amount);
			if (this.rating == amount) {
        this.rating = 0;
      }
			else this.rating = amount;
		},
    currentLabel() {
       let r = this.rating;
      if (this.hoverRating != this.rating) r = this.hoverRating;
      let i = this.ratings.findIndex(e => e.amount == r);
      if (i >=0) {return this.ratings[i].label;} else {return ''};
    }


		}"

    >
        <div class="flex flex-col items-center justify-center space-y-2 rounded m-2 w-72 h-56 p-3 bg-gray-200 mx-auto">
            <div class="flex space-x-0 bg-gray-100">
                <template x-for="i in ratings" :key="i">
                    <button @click="rate(i)" @mouseover="hoverRating = i"
                            @mouseleave="hoverRating = rating"
                            aria-hidden="true"
                            :title="star.label"
                            class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline p-1 w-12 m-0 cursor-pointer"
                            :class="{'text-gray-600': hoverRating >= i, 'text-yellow-400': rating >= i && hoverRating >= i}">
                        <x-heroicon-c-star class="w-15 transition duration-150"/>
                    </button>

                </template>
            </div>


        </div>
    </div>
</x-dynamic-component>


