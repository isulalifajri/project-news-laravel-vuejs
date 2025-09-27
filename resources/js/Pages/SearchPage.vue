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
        src="https://picsum.photos/1200/400?random=30"
        alt="Search Hero"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white">
          Search Results
        </h1>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
      <section>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold uppercase">
            Hasil untuk: "{{ props.query }}"
          </h2>
        </div>

        <!-- Komponen News -->
        <News v-if="posts.length > 0" :posts="posts" :query="props.query" />

        <!-- Kalau tidak ada hasil -->
        <div v-else class="text-center py-20 text-gray-500">
        <p class="text-lg">
            Tidak ada hasil untuk "<strong>{{ props.query }}</strong>"
        </p>
        </div>

        <!-- Tombol Load More -->
        <div v-if="nextPageUrl" class="text-center mt-6">
          <button
            @click="loadMore"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer"
          >
            Load More
          </button>
        </div>
      </section>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from "vue"
import axios from "axios"
import { Link } from "@inertiajs/vue3"

import AppLayout from "@/Layouts/AppLayout.vue"
import News from "@/Pages/News.vue"

const props = defineProps({
  query: String,
  postsSearch: Object,
  categories: Array,
  companyProfile: Object,
  sosmedIcons: Array,
  footerContacts: Array,
  mostPopulars: Array,
})

// State posts dan nextPageUrl
const posts = ref([...props.postsSearch.data])
const nextPageUrl = ref(
  props.postsSearch.next_page_url
    ? route('search.page.load') + "?q=" + encodeURIComponent(props.query) + "&page=2"
    : null
)


const loadMore = async () => {
  if (!nextPageUrl.value) return

  try {
    const res = await axios.get(nextPageUrl.value)
    const postsSearch = res.data?.data
    if (!postsSearch || !Array.isArray(postsSearch)) return

    posts.value.push(...postsSearch)

    // Update next page
    nextPageUrl.value = res.data.next_page_url
      ? route('search.page.load') + "?q=" + encodeURIComponent(props.query) + "&page=" + (res.data.current_page + 1)
      : null
  } catch (err) {
    console.error(err)
  }
}
</script>
