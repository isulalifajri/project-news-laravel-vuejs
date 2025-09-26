<template>
  <div class="max-w-screen-xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kiri -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Latest News -->
      <section class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold uppercase">Latest News</h2>
        </div>

        <!-- 2 Card Besar -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
          <div
            v-for="(news, i) in latestNews.slice(0, 2)"
            :key="i"
            class="border border-gray-300 rounded-lg overflow-hidden shadow-sm"
          >
          <Link :href="route('show.news', news.slug)">
            <img :src="news.image" class="w-full h-48 object-cover" />
            <div class="p-4">
              <Link :href="route('category.show', news.catSlug)">
                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                  {{ news.category }}
                </span>
              </Link>
              <h3 class="mt-2 font-semibold text-lg line-clamp-2">{{ news.title }}</h3>
              <p class="text-sm text-gray-600 mt-1 line-clamp-3">{{ news.description }}</p>
              <p class="text-xs text-gray-400 mt-2">
                By {{ news.author }} • {{ news.date }}
              </p>
            </div>
          </Link>
          </div>
        </div>

        <!-- List Kecil Horizontal -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div
            v-for="(news, i) in latestNews.slice(3, 7)"
            :key="i"
          >
          <Link :href="route('show.news', news.slug)" class="flex items-center space-x-3 border-b border-gray-300 pb-3">
            <img :src="news.image" class="w-24 h-16 object-cover rounded" />
            <div>
              <Link :href="route('category.show', news.catSlug)">
                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                  {{ news.category }}
                </span>
              </Link>
              <h4 class="text-sm font-semibold leading-snug mt-1 line-clamp-1">
                {{ news.title }}
              </h4>
              <p class="text-xs text-gray-400">{{ news.date }}</p>
            </div>
          </Link>
          </div>
        </div>
      </section>
    </div>

    <!-- Trending News -->
    <TrendingNews :trending-News="props.trendingNews" />

  </div>
</template>

<script setup>

import TrendingNews from "@/Pages/TrendingNews.vue"
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  mostPopulars: { type: Array, default: () => [] },
  latestNews: { type: Array, default: () => [] },
  trendingNews: { type: Array, default: () => [] },
})

</script>
