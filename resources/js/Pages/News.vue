<template>
  <!-- 6 Card Grid -->
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div
      v-for="(news, i) in posts"
      :key="i"
      class="border border-gray-400 rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition"
    >
      <img :src="news.image" class="w-full h-48 object-cover" />
      <div class="p-4">
        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">
          {{ news.category }}
        </span>
        <h3 class="mt-2 font-semibold text-lg line-clamp-2">{{ news.title }}</h3>
        <p class="text-xs text-gray-400 mt-2">
          By {{ news.author }} • {{ news.date }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  posts: {
    type: Array,
    default: () => [
      {
        image: "https://picsum.photos/400/300?random=1",
        category: "Business",
        title: "Strategi Bisnis 2025",
        author: "Admin",
        date: "Sep 20, 2025",
      },
      {
        image: "https://picsum.photos/400/300?random=2",
        category: "Tech",
        title: "AI Mengubah Dunia",
        author: "John",
        date: "Sep 19, 2025",
      },
      {
        image: "https://picsum.photos/400/300?random=3",
        category: "Travel",
        title: "Wisata Populer 2025",
        author: "Jane",
        date: "Sep 18, 2025",
      },
    ],
  },
})
</script>
