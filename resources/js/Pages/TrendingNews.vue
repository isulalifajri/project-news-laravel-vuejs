<template>
    <aside class="space-y-6">
      <section class="bg-white shadow rounded-lg p-4">
        <h3 class="font-bold mb-3">Trending News</h3>
    
        <div class="space-y-4">
          <!-- Trending News Pertama (Big Card) -->
          <div v-if="trendingNews.length > 0" class="relative rounded-lg overflow-hidden">
            <Link :href="route('show.news', trendingNews[0].slug)">
              <img
                :src="trendingNews[0].image"
                class="w-full h-48 object-cover"
              />
              <div class="absolute inset-0 bg-black/40 p-4 flex flex-col justify-end">
                <Link :href="route('category.show', trendingNews[0].catSlug)">
                  <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded inline-block w-fit">
                    {{ trendingNews[0].category }}
                  </span>
                </Link>
      
                <h4 class="text-white font-semibold text-base mt-2 line-clamp-2">
                  {{ trendingNews[0].title }}
                </h4>
                <p class="text-xs text-gray-200 mt-1">
                  {{ trendingNews[0].author }} • {{ trendingNews[0].date }}
                </p>
              </div>
            </Link>
          </div>
    
          <!-- Trending News Lainnya (List kecil) -->
          <div
            v-for="(news, i) in trendingNews.slice(1)"
            :key="i"
          >
          <Link :href="route('show.news', news.slug)" class="flex space-x-3 items-center">
            <img :src="news.image" class="w-20 h-14 object-cover rounded" />
            <div>
              <Link :href="route('category.show', news.catSlug)">
                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                  {{ news.category }}
                </span>
              </Link>
              <h4 class="text-sm font-semibold leading-tight line-clamp-2">
                {{ news.title }}
              </h4>
              <p class="text-xs text-gray-400">
                {{ news.author }} • {{ news.date }}
              </p>
            </div>
          </Link>
          </div>
        </div>
      </section>
    </aside>
</template>

<script setup>

import { Link } from '@inertiajs/vue3'

const props = defineProps({
  trendingNews: { type: Array, default: () => [] },
})

</script>