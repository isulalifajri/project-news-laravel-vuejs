<template>
  <footer class="bg-[#111827] text-gray-300 pt-10">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Get in Touch -->
      <div>
        <h3 class="text-lg font-bold mb-4">GET IN TOUCH</h3>
        <!-- Address -->
        <p v-if="address" class="flex items-center mb-2">
          <i class="fas fa-map-marker-alt mr-3 text-blue-500"></i>
          {{ address }}
        </p>

        <!-- Phone -->
        <p v-if="phone" class="flex items-center mb-2">
          <i class="fas fa-phone mr-3 text-blue-500"></i>
          {{ phone }}
        </p>

        <!-- Email -->
        <p v-if="email" class="flex items-center mb-4">
          <i class="fas fa-envelope mr-3 text-blue-500"></i>
          {{ email }}
        </p>
        
        <h3 class="text-lg font-bold mb-2">FOLLOW US</h3>
        <div class="flex flex-wrap gap-2">
          <template v-if="props.sosmedIcons && props.sosmedIcons.length > 0">
            <a 
            v-for="(item, i) in props.sosmedIcons" 
            :key="i" 
            :href="item.value || '#'" 
            class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"
            target="_blank"
            v-html="item.icon"></a>
          </template>
          <template v-else>
            <a href="#" class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"><i class="fab fa-twitter"></i></a>
            <a href="#" class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"><i class="fab fa-instagram"></i></a>
            <a href="#" class="bg-gray-800 hover:bg-blue-500 hover:text-black p-2 rounded"><i class="fab fa-youtube"></i></a>
          </template>
        </div>
      </div>

      <!-- Popular News -->
      <div>
        <h3 class="text-lg font-bold mb-4">POPULAR NEWS</h3>
        <div v-if="props.mostPopulars && props.mostPopulars.length">
          <div v-for="(post, i) in props.mostPopulars.slice(0, 3)" :key="i" class="mb-4">
            <span class="bg-blue-500 text-black text-xs font-bold px-2 py-1">
              {{ post.category?.name ?? 'GENERAL' }}
            </span>
            <span class="text-sm ml-2">
              {{ new Date(post.published_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) }}
            </span>
            <p class="mt-2 text-sm uppercase line-clamp-2">{{ post.title }}</p>
          </div>
        </div>
      
        <div v-else>
          <div v-for="i in 3" :key="i" class="mb-4">
            <span class="bg-blue-500 text-black text-xs font-bold px-2 py-1">BUSINESS</span>
            <span class="text-sm ml-2">Jan 01, 2045</span>
            <p class="mt-2 text-sm">LOREM IPSUM DOLOR SIT AMET ELIT. PROIN VITAE PORTA DIAM...</p>
          </div>
        </div>
      </div>

      <!-- Categories -->
      <div>
        <h3 class="text-lg font-bold mb-4">CATEGORIES</h3>
        <div class="flex flex-wrap gap-2">
          <template v-if="props.categories && props.categories.length > 0">
            <span v-for="(cat, i) in props.categories" :key="i" 
              class="bg-gray-700 px-3 py-1 text-sm rounded cursor-pointer hover:bg-blue-500 hover:text-black">
              <a :href="`/category/${cat.slug}`">{{ cat.name }}</a>
            </span>
          </template>
          <template v-else>
            <span class="bg-gray-500 px-3 py-1 text-sm rounded text-gray-200">No categories found</span>
          </template>
        </div>
      </div>

      <!-- Flickr Photos -->
      <div>
        <h3 class="text-lg font-bold mb-4">FLICKR PHOTOS</h3>
        <div class="grid grid-cols-3 gap-2">
           <img 
            v-for="i in 6" 
            :key="i" 
            :src="`https://picsum.photos/100?random=${i}`" 
            alt="photo" 
            class="w-full h-20 object-cover rounded" 
          />
        </div>
      </div>
    </div>

    <!-- Bottom -->
    <div class="bg-black text-gray-400 text-sm text-center py-4 mt-8">
      © {{ currentYear }} <span class="text-blue-500">SKY NEWS</span> All Rights Reserved. 
      Design by <span class="text-blue-500">Isul AF</span>
    </div>
  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  sosmedIcons: { type: Array, default: () => [] },
  footerContacts: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  mostPopulars: { type: Array, default: () => [] },
})

const address = computed(() => props.footerContacts.find(item => item.type === 'address')?.value || '123 Street, New York, USA')
const phone   = computed(() => props.footerContacts.find(item => item.type === 'phone')?.value || '+012 345 67890')
const email   = computed(() => props.footerContacts.find(item => item.type === 'email')?.value || 'info@example.com')

const currentYear = ref(new Date().getFullYear())
</script>
