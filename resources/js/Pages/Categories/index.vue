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

       <!-- Panggil komponen News -->
       <News />
      </section>
    </div>
    
    <LatestNews />

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
</script>
