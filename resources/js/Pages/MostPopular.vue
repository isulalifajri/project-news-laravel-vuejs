<template>
  <div class="max-w-screen-xl mx-auto px-4 mt-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Most Popular</h2>

    <div class="grid md:grid-cols-4 gap-6">
      <div
        v-for="(item, index) in mostPopulars.slice(0, 4)"
        :key="index"
        class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden"
      >
      <a :href="`/news/${item.slug}`">
        <!-- Gambar -->
        <img
          :src="item.image"
          :alt="item.title"
          class="w-full h-40 object-cover"
        />

        <!-- Konten -->
        <div class="p-4">
          <span
            class="bg-blue-500 text-white text-xs px-2 py-1 rounded inline-block w-fit"
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
      </a>
      </div>
    </div>
  </div>
</template>

<script setup>

const props = defineProps({
  mostPopulars: { type: Array, default: () => [] },
})
</script>
