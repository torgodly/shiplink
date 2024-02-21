
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
        state: $wire.$entangle('{{ $getStatePath() }}'),
        rating: 0,
		hoverRating: 0,
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

        x-init="rating = state; hoverRating = state"

    >
        <template x-for="i in ratings" :key="i">
            <button @click="rate(i); state = rating" @mouseover="hoverRating = i"
                    @mouseleave="hoverRating = rating"
                    aria-hidden="true"
                    :title="star.label"
                    class="rounded-sm text-gray-400 fill-current focus:outline-none focus:shadow-outline p-1 w-12 m-0 cursor-pointer"
                    :class="{'text-gray-600': hoverRating >= i, 'text-yellow-400': rating >= i && hoverRating >= i}">
                <x-heroicon-c-star class="w-15 transition duration-150"/>
            </button>

        </template>

        <input hidden="" x-model="state" >


    </div>
</x-dynamic-component>


