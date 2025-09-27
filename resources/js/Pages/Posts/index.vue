<template>
  <AppLayout
    :company-profile="props.companyProfile"
    :sosmed-icons="props.sosmedIcons"
    :footer-contacts="props.footerContacts"
    :categories="props.categories"
    :most-populars="props.mostPopulars"
  >
    <!-- Hero Image -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 mb-10">
      <img
        src="https://picsum.photos/1200/400?random=10"
        alt="Posts Hero"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white">
          Posts News
        </h1>
      </div>
    </div>

    <!-- Scrollable Categories -->
    <div class="bg-white/10 backdrop-blur-sm rounded overflow-x-auto">
      <div class="flex space-x-3 px-4 py-2">
        <!-- Tombol All -->
        <Link
          :href="route('posts')"
          :class="[
            'flex-shrink-0 rounded-full shadow-md px-3 py-1.5 text-sm md:px-4 md:py-2 md:text-base transition duration-300',
            !activeCategorySlug ? 'bg-blue-500 text-white' : 'bg-[#0b132b] text-gray-300 hover:bg-blue-500 hover:text-white'
          ]"
        >
          All
        </Link>

        <!-- Tombol kategori -->
        <Link
          v-for="cat in props.categories"
          :key="cat.id"
          :href="route('category.show', cat.slug)"
          :class="[
            'flex-shrink-0 rounded-full shadow-md px-3 py-1.5 text-sm md:px-4 md:py-2 md:text-base transition duration-300',
            activeCategorySlug === cat.slug ? 'bg-blue-500 text-white' : 'bg-[#0b132b] text-gray-300 hover:bg-blue-500 hover:text-white'
          ]"
        >
          {{ cat.name }}
        </Link>
      </div>
    </div>

    <!-- Posts News -->
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
      <section>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold uppercase">Posts News</h2>
        </div>

        <!-- Komponen News -->
        <News :posts="posts" />

        <!-- Tombol Load More -->
        <div v-if="nextPageUrl" class="text-center mt-6">
          <button @click="loadMore" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
            Load More
          </button>
        </div>
      </section>
    </div>

    <!-- Latest News & Trending -->
    <LatestNews 
      :latest-news="props.latestNews"
      :trending-news="props.trendingNews"
    />

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
import { ref, computed } from "vue"
import axios from "axios"
import { Link } from '@inertiajs/vue3'

import AppLayout from "@/Layouts/AppLayout.vue"
import News from "@/Pages/News.vue"
import LatestNews from "@/Pages/LatestNews.vue"

const props = defineProps({
  categories: Array,
  postNews: Object,
  latestNews: Array,
  trendingNews: Array,
  companyProfile: Object,
  sosmedIcons: Array,
  footerContacts: Array,
  mostPopulars: Array,
})

// Active category slug, null untuk halaman All News
const activeCategorySlug = computed(() => null)

// State posts dan nextPageUrl
const posts = ref([...props.postNews.data])
const nextPageUrl = ref(
  props.postNews.next_page_url
    ? route('posts.news') + "?page=2"
    : null
)

// Fungsi Load More
const loadMore = async () => {
  if (!nextPageUrl.value) return

  try {
    const res = await axios.get(nextPageUrl.value)
    const newPosts = res.data?.data

    if (!newPosts || !Array.isArray(newPosts)) {
      console.warn("Unexpected response:", res.data)
      return
    }

    posts.value.push(...newPosts)

    // Update nextPageUrl
    nextPageUrl.value = res.data.next_page_url
      ? route('posts.news') + '?page=' + (res.data.current_page + 1)
      : null

  } catch (error) {
    console.error("Failed to load more posts:", error)
  }
}
</script>
