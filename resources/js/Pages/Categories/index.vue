<template>
  <AppLayout>
    <!-- Hero Image -->
    <div class="relative w-full h-64 md:h-80 lg:h-96 mb-10">
      <img
        src="https://picsum.photos/1200/400?random=10"
        alt="Category Hero"
        class="w-full h-full object-cover"
      />
      <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white">
          Category: Business
        </h1>
      </div>
    </div>

    <!-- Category News -->
    <div class="max-w-screen-xl mx-auto px-4">
      <section>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold uppercase">Category News</h2>
          <a href="#" class="text-sm text-yellow-500 hover:underline">View All</a>
        </div>

        <!-- 6 Card Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="(news, i) in categoryNews"
            :key="i"
            class="border rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition"
          >
            <img :src="news.image" class="w-full h-48 object-cover" />
            <div class="p-4">
              <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                {{ news.category }}
              </span>
              <h3 class="mt-2 font-semibold text-lg">{{ news.title }}</h3>
              <p class="text-sm text-gray-600 mt-1">{{ news.description }}</p>
              <p class="text-xs text-gray-400 mt-2">
                By {{ news.author }} • {{ news.date }}
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <LatestNews />

    <!-- Banner Iklan -->
    <div class="w-full mb-10">
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

const categoryNews = [
  {
    image: "https://picsum.photos/400/300?random=1",
    category: "Business",
    title: "Strategi Bisnis 2025",
    description: "Mengenal tren bisnis terbaru di tahun 2025.",
    author: "Admin",
    date: "Sep 20, 2025",
  },
  {
    image: "https://picsum.photos/400/300?random=2",
    category: "Tech",
    title: "AI Mengubah Dunia",
    description: "Teknologi AI terus memengaruhi kehidupan sehari-hari.",
    author: "John",
    date: "Sep 19, 2025",
  },
  {
    image: "https://picsum.photos/400/300?random=3",
    category: "Travel",
    title: "Wisata Populer 2025",
    description: "Destinasi paling dicari wisatawan tahun ini.",
    author: "Jane",
    date: "Sep 18, 2025",
  },
  {
    image: "https://picsum.photos/400/300?random=4",
    category: "Lifestyle",
    title: "Hidup Sehat di Era Digital",
    description: "Tips menjaga kesehatan di era modern.",
    author: "Alice",
    date: "Sep 17, 2025",
  },
  {
    image: "https://picsum.photos/400/300?random=5",
    category: "Sports",
    title: "Liga Sepakbola Dunia",
    description: "Update terbaru dari dunia sepakbola.",
    author: "Bob",
    date: "Sep 16, 2025",
  },
  {
    image: "https://picsum.photos/400/300?random=6",
    category: "Food",
    title: "Kuliner Hits 2025",
    description: "Menu kuliner yang sedang naik daun.",
    author: "Chef",
    date: "Sep 15, 2025",
  },
]
</script>
