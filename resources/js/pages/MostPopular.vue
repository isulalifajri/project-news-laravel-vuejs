<template>
  <div class="max-w-screen-xl mx-auto px-4 mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Most Popular</h2>

    <div class="grid md:grid-cols-4 gap-6">
      <div
        v-for="(item, index) in mostPopular"
        :key="index"
        class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden"
      >
        <!-- Gambar -->
        <img
          :src="item.image"
          :alt="item.title"
          class="w-full h-40 object-cover"
        />

        <!-- Konten -->
        <div class="p-4">
          <span
            class="bg-yellow-500 text-white text-xs px-2 py-1 rounded inline-block w-fit"
          >
            {{ item.category }}
          </span>

          <h3 class="text-base font-semibold mt-2 line-clamp-2">
            {{ item.title }}
          </h3>

          <p class="text-xs text-gray-500 mt-1">
            {{ item.author }} • {{ item.date }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

const mostPopular = [
  {
    image: "https://picsum.photos/300/160?random=1",
    category: "Tech",
    title: "5 Gadget Terbaru yang Wajib Kamu Punya di 2025",
    author: "Jhon",
    date: "Sep 20, 2025",
  },
  {
    image: "https://picsum.photos/300/160?random=2",
    category: "Business",
    title: "Strategi Bisnis yang Lagi Booming Tahun Ini",
    author: "Admin",
    date: "Sep 19, 2025",
  },
  {
    image: "https://picsum.photos/300/160?random=3",
    category: "Lifestyle",
    title: "10 Tips Hidup Sehat di Era Digital",
    author: "Jhon",
    date: "Sep 18, 2025",
  },
  {
    image: "https://picsum.photos/300/160?random=4",
    category: "Travel",
    title: "Destinasi Wisata Paling Populer Tahun 2025",
    author: "Jane",
    date: "Sep 17, 2025",
  },
]
</script>
