<template>
  <AppLayout
    :company-profile="companyProfile"
    :sosmed-icons="sosmedIcons"
    :footer-contacts="footerContacts"
    :categories="categories"
    :most-populars="mostPopulars"
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
          Contact
        </h1>
      </div>
    </div>

    <!-- Company Profile -->
    <div class="max-w-screen-xl mx-auto px-4 mt-3">
      <section>
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold uppercase">{{ companyProfile?.name }}</h2>
        </div>

        <!-- Company Logo -->
        <div class="mb-6">
          <img
            :src="companyProfile?.logo"
            :alt="companyProfile?.name"
            class="h-50 object-contain"
          />
        </div>

        <!-- About -->
        <h3 class="text-xl font-semibold mb-2">About</h3>
        <p class="mb-6">
          {{ companyProfile?.about || 'No description available.' }}
        </p>

        <!-- Social Media Icons -->
        <div v-if="sosmedIcons?.length" class="flex space-x-4 mt-6">
          <a
            v-for="(icon, i) in sosmedIcons"
            :key="i"
            :href="icon.url"
            target="_blank"
            rel="noopener"
            class="text-gray-600 hover:text-blue-500"
          >
            <i :class="icon.icon"></i>
          </a>
        </div>
      </section>
    </div>

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
import { Link } from "@inertiajs/vue3"
import AppLayout from "@/Layouts/AppLayout.vue"

const props = defineProps({
  categories: Array,
  companyProfile: Object,
  sosmedIcons: Array,
  footerContacts: Array,
  mostPopulars: Array,
})
</script>
