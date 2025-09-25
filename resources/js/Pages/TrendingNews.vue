<template>
    <aside class="space-y-6">
      <section class="bg-white shadow rounded-lg p-4">
        <h3 class="font-bold mb-3">Trending News</h3>
    
        <div class="space-y-4">
          <!-- Trending News Pertama (Big Card) -->
          <div v-if="trendingNews.length > 0" class="relative rounded-lg overflow-hidden">
            <a :href="`/news/${trendingNews[0].slug}`">
              <img
                :src="trendingNews[0].image"
                class="w-full h-48 object-cover"
              />
              <div class="absolute inset-0 bg-black/40 p-4 flex flex-col justify-end">
                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded inline-block w-fit">
                  {{ trendingNews[0].category }}
                </span>
      
                <h4 class="text-white font-semibold text-base mt-2 line-clamp-2">
                  {{ trendingNews[0].title }}
                </h4>
                <p class="text-xs text-gray-200 mt-1">
                  {{ trendingNews[0].author }} • {{ trendingNews[0].date }}
                </p>
              </div>
            </a>
          </div>
    
          <!-- Trending News Lainnya (List kecil) -->
          <div
            v-for="(news, i) in trendingNews.slice(1)"
            :key="i"
          >
          <a :href="`/news/${news.slug}`" class="flex space-x-3 items-center">
            <img :src="news.image" class="w-20 h-14 object-cover rounded" />
            <div>
              <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
                {{ news.category }}
              </span>
              <h4 class="text-sm font-semibold leading-tight line-clamp-2">
                {{ news.title }}
              </h4>
              <p class="text-xs text-gray-400">
                {{ news.author }} • {{ news.date }}
              </p>
            </div>
          </a>
          </div>
        </div>
      </section>
    </aside>
</template>

<script setup>

const props = defineProps({
  trendingNews: { type: Array, default: () => [] },
})
// const trending = [
//   { image: "https://picsum.photos/100/80?random=7", category: "Business", title: "Trending business news here...", author:"James Vedry", date:"Sept 03, 2045" },
//   { image: "https://picsum.photos/100/80?random=8", category: "World", title: "World events making headlines...", author:"James Vedry", date:"Sept 03, 2045" },
//   { image: "https://picsum.photos/100/80?random=9", category: "Tech", title: "Latest gadgets update...", author:"James Vedry", date:"Sept 03, 2045" },
// ]
</script>