<template>
  <AppLayout>
    <div class="max-w-screen-xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Kiri (Slider) -->
      <div class="lg:col-span-2">
        <Swiper
          :modules="[Navigation, Pagination, Autoplay]"
          :slides-per-view="1"
          :autoplay="{ delay: 4000 }"
          pagination
          navigation
          loop
          class="rounded-lg overflow-hidden"
        >
          <SwiperSlide v-for="(slide, i) in slides" :key="i">
            <div class="relative">
              <img :src="slide.image" class="w-full h-[400px] object-cover" />
              <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent p-6 flex flex-col justify-end">
                <span class="bg-red-600 text-white text-xs px-2 py-1 rounded mb-2 w-fit">
                  {{ slide.category }}
                </span>
                <h2 class="text-2xl font-bold text-white">{{ slide.title }}</h2>
                <p class="text-sm text-gray-200">by {{ slide.author }} • {{ slide.date }}</p>
              </div>
            </div>
          </SwiperSlide>
        </Swiper>
      </div>
  
      <!-- Kanan (2 card statis) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6">
        <div
          v-for="(card, i) in rightCards"
          :key="i"
          class="relative rounded-lg overflow-hidden"
        >
          <img :src="card.image" class="w-full h-[190px] object-cover" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent p-4 flex flex-col justify-end">
            <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded mb-2 w-fit">
              {{ card.category }}
            </span>
            <h3 class="text-lg font-semibold text-white">{{ card.title }}</h3>
            <p class="text-xs text-gray-200">by {{ card.author }} • {{ card.date }}</p>
          </div>
        </div>
      </div>
    </div>
    <LatestNews />
    <MostPopular /> <!-- Tambahin ini -->
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import LatestNews from '@/Pages/LatestNews.vue'
import MostPopular from '@/Pages/MostPopular.vue'
import { Swiper, SwiperSlide } from 'swiper/vue'

import { Navigation, Pagination, Autoplay } from 'swiper/modules'

// Import CSS
import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/autoplay'

// const slides = [
//   {
//     image: "https://picsum.photos/800/400?random=1",
//     category: "Business",
//     title: "Anna Lora Stuns In White At Her Australian Premiere",
//     author: "Alice Cloe",
//     date: "Jun 19, 2020",
//   },
//   {
//     image: "https://picsum.photos/800/400?random=2",
//     category: "World",
//     title: "Economic Updates Across Asia-Pacific Markets",
//     author: "John Doe",
//     date: "Jun 20, 2020",
//   },
// ]

// const rightCards = [
//   {
//     image: "https://picsum.photos/400/200?random=3",
//     category: "Fashion",
//     title: "Secretart for Economic Air plane that looks like",
//     author: "Alice Cloe",
//     date: "Jun 19, 2020",
//   },
//   {
//     image: "https://picsum.photos/400/200?random=4",
//     category: "Tech",
//     title: "New Gadgets Revolutionize Daily Life",
//     author: "Alice Cloe",
//     date: "Jun 20, 2020",
//   },
// ]

import { usePage } from '@inertiajs/vue3'

const page = usePage()
const props = defineProps({
  slides: { type: Array, required: true },
  rightCards: { type: Array, required: true },
})

</script>
