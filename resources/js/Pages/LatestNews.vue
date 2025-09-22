<template>
  <div class="max-w-screen-xl mx-auto px-4 py-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kiri -->
    <div class="lg:col-span-2 space-y-6">
      <!-- Latest News -->
      <section class="bg-white shadow rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-bold uppercase">Latest News</h2>
          <a href="#" class="text-sm text-yellow-500 hover:underline">View All</a>
        </div>

        <!-- 2 Card Besar -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
          <div
            v-for="(news, i) in latestNews"
            :key="i"
            class="border border-gray-300 rounded-lg overflow-hidden shadow-sm"
          >
            <img :src="news.image" class="w-full h-48 object-cover" />
            <div class="p-4">
              <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                {{ news.category }}
              </span>
              <h3 class="mt-2 font-semibold text-lg">{{ news.title }}</h3>
              <p class="text-sm text-gray-600 mt-1">{{ news.description }}</p>
              <p class="text-xs text-gray-400 mt-2">By {{ news.author }} • {{ news.date }}</p>
            </div>
          </div>
        </div>

        <!-- List Kecil Horizontal -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div
            v-for="(news, i) in listNews"
            :key="i"
            class="flex items-center space-x-3 border-b border-gray-300 pb-3"
          >
            <img :src="news.image" class="w-24 h-16 object-cover rounded" />
            <div>
              <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                {{ news.category }}
              </span>
              <h4 class="text-sm font-semibold leading-snug mt-1">
                {{ news.title }}
              </h4>
              <p class="text-xs text-gray-400">{{ news.date }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Trending News -->
   <!-- Trending News -->
<aside class="space-y-6">
  <section class="bg-white shadow rounded-lg p-4">
    <h3 class="font-bold mb-3">Trending News</h3>

    <div class="space-y-4">
      <!-- Trending News Pertama (Big Card) -->
      <div v-if="trending.length > 0" class="relative rounded-lg overflow-hidden">
        <img
          :src="trending[0].image"
          class="w-full h-48 object-cover"
        />
        <div class="absolute inset-0 bg-black/40 p-4 flex flex-col justify-end">
          <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded inline-block w-fit">
            {{ trending[0].category }}
          </span>

          <h4 class="text-white font-semibold text-base mt-2">
            {{ trending[0].title }}
          </h4>
          <p class="text-xs text-gray-200 mt-1">
            {{ trending[0].author }} • {{ trending[0].date }}
          </p>
        </div>
      </div>

      <!-- Trending News Lainnya (List kecil) -->
      <div
        v-for="(news, i) in trending.slice(1)"
        :key="i"
        class="flex space-x-3 items-center"
      >
        <img :src="news.image" class="w-20 h-14 object-cover rounded" />
        <div>
          <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
            {{ news.category }}
          </span>
          <h4 class="text-sm font-semibold leading-tight">
            {{ news.title }}
          </h4>
          <p class="text-xs text-gray-400">
            {{ news.author }} • {{ news.date }}
          </p>
        </div>
      </div>
    </div>
  </section>
</aside>

  </div>
</template>

<script setup>
const latestNews = [
  {
    image: "https://picsum.photos/400/300?random=1",
    category: "Business",
    title: "Lorem ipsum dolor sit amet elit...",
    description: "Dolor lorem eos dolor duo et etirmod sea...",
    author: "John Doe",
    date: "Jan 01, 2045",
  },
  {
    image: "https://picsum.photos/400/300?random=2",
    category: "World",
    title: "Another sample news headline here...",
    description: "Sed amet magna clita rebum dolor stet...",
    author: "Jane Doe",
    date: "Jan 02, 2045",
  },
]

const listNews = [
  { image: "https://picsum.photos/100/80?random=3", category: "Business", title: "Lorem ipsum dolor sit amet elit...", date: "Jan 01, 2045" },
  { image: "https://picsum.photos/100/80?random=4", category: "World", title: "Dolor magna clita lorem eos duo...", date: "Jan 02, 2045" },
  { image: "https://picsum.photos/100/80?random=5", category: "Tech", title: "Latest update on smartphone trends", date: "Jan 03, 2045" },
  { image: "https://picsum.photos/100/80?random=6", category: "Fashion", title: "New season, new styles in fashion", date: "Jan 04, 2045" },
]
const trending = [
  { image: "https://picsum.photos/100/80?random=7", category: "Business", title: "Trending business news here...", author:"James Vedry", date:"Sept 03, 2045" },
  { image: "https://picsum.photos/100/80?random=8", category: "World", title: "World events making headlines...", author:"James Vedry", date:"Sept 03, 2045" },
  { image: "https://picsum.photos/100/80?random=9", category: "Tech", title: "Latest gadgets update...", author:"James Vedry", date:"Sept 03, 2045" },
]
</script>
