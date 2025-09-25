<template>
  <AppLayout
  :company-profile="props.companyProfile"
  :sosmed-icons="props.sosmedIcons"
  :footer-contacts="props.footerContacts"
  :categories="props.categories"
   >
    <!-- Hero Image -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 mb-10">
      <img
        src="https://picsum.photos/1200/400?random=10"
        alt="Category Hero"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white">
          Category: {{ currentCategory.name }}
        </h1>
      </div>
    </div>

   <!-- Scrollable Categories (Horizontal) -->
  <div class="bg-white/10 backdrop-blur-sm rounded max-w min-w-0 overflow-x-auto">
    <div class="overflow-x-auto flex space-x-3 px-4 py-2">
      <a
        v-for="(cat, i) in categories"
        :key="i"
        :href="route('category.show', cat.slug)"
        :class="[
          'flex-shrink-0 rounded-full shadow-md px-2 py-1 text-xs sm:px-3 sm:py-1.5 sm:text-sm md:px-4 md:py-2 md:text-base transition duration-300',
          currentCategory.slug === cat.slug
            ? 'bg-blue-500 text-white'
            : 'bg-[#0b132b] text-gray-300 hover:bg-blue-500 hover:text-white'
        ]"
      >
        {{ cat.name }}
      </a>
    </div>
  </div>

    <!-- Category News -->
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
      <section>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold uppercase">Category News</h2>
          <a href="#" class="text-sm text-yellow-500 hover:underline">View All</a>
        </div>

       <!-- Panggil komponen News -->
       <News :posts="props.categoryPosts.data" />
          <div class="text-center mt-6" v-if="props.categoryPosts.next_page_url">
            <button 
              @click="loadMore" 
              class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            >
              Load More
            </button>
          </div>
      </section>
    </div>
    
    <LatestNews 
    :latest-news="props.latestNews"
    :trending-news="props.trendingNews"/>

   <!-- Banner Iklan -->
  <div class="w-full my-10 flex justify-center">
    <img
      src="https://picsum.photos/1200/200?random=20"
      alt="Advertisement"
      class="w-full h-20 md:h-28 object-cover rounded-lg shadow"
    />
  </div>

  </AppLayout>
</template>

<script setup>
  import AppLayout from '@/Layouts/AppLayout.vue'
  import LatestNews from '@/Pages/LatestNews.vue'
  import News from '@/Pages/News.vue'

  const props = defineProps({
    category: Object,
    categories: Array,
    categoryPosts: Array,
    latestNews: Array,
    trendingNews: Array,
    companyProfile: Object,
    sosmedIcons: Array,
    footerContacts: Array,
  })

  import { usePage } from '@inertiajs/vue3'

  const page = usePage()
  const currentCategory = props.category

</script>
