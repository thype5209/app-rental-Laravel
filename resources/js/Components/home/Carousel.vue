<script setup>


</script>


<template>
    <div class="carousel w-full h-max relative box-border py-10">
        <carousel :items-to-show="3" :items-to-scroll="1" class="w-full" :autoplay="2000" :wrapAround="true">
            <slide v-for="slide in 4" :key="slide" class="w-full">
                <div 
                    class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-md sm:p-6 md:p-8 dark:bg-default-dark dark:border-gray-700">
                    <div class="space-y-6">
                        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Nama Mobil/Spesifikasi</h5>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-center">Rp. Harga</label>
                        <div class="flex justify-center overflow-hidden">
                        <img :src="PathImage + `car-side.png`" alt="" class="h-max bg-cover w-[50%]">
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-default-yellow hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-default-yellow dark:focus:ring-yellow-600 transition-colors">Sewa Mobil</button>
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                            Status Sewa? <a href="#" class="text-defbg-default-yellow hover:underline dark:text-yellow-500">Harga Sewa</a>
                        </div>
                    </div>
                </div>
            </slide>

            <template #addons>
                <pagination />
            </template>
        </carousel>
    </div>

</template>

<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination } from 'vue3-carousel'

export default {
    name: 'CarouselVue',
    components: {
        Carousel,
        Slide,
        Pagination,
    },
    data() {
        return {
        PathImage : '../img/',

        }
    },


}
</script>

<!-- <style scoped>
.carousel__slide {
  padding: 5px;
}

.carousel__viewport {
  perspective: 100px;
}

.carousel__track {
  transform-style: preserve-3d;
}

.carousel__slide--sliding {
  transition: 0.5s;
}

.carousel__slide {
  opacity: 0.9;
  transform: rotateY(-20deg) scale(0.9);
}

.carousel__slide--active ~ .carousel__slide {
  transform: rotateY(20deg) scale(0.9);
}

.carousel__slide--prev {
  opacity: 1;
  transform: rotateY(-10deg) scale(0.95);
}

.carousel__slide--next {
  opacity: 1;
  transform: rotateY(10deg) scale(0.95);
}

.carousel__slide--active {
  opacity: 1;
  transform: rotateY(0) scale(1.1);
}
</style> -->
