<template>
  <footer class="bg-[#111827] text-gray-300 pt-10">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Get in Touch -->
      <div>
        <h3 class="text-lg font-bold mb-4">GET IN TOUCH</h3>
        <p class="flex items-center mb-2"><i class="fas fa-map-marker-alt mr-3 text-yellow-500"></i>123 Street, New York, USA</p>
        <p class="flex items-center mb-2"><i class="fas fa-phone mr-3 text-yellow-500"></i>+012 345 67890</p>
        <p class="flex items-center mb-4"><i class="fas fa-envelope mr-3 text-yellow-500"></i>info@example.com</p>
        
        <h3 class="text-lg font-bold mb-2">FOLLOW US</h3>
        <div class="flex space-x-3">
          <a href="#" class="bg-gray-800 hover:bg-yellow-500 hover:text-black p-2 rounded"><i class="fab fa-twitter"></i></a>
          <a href="#" class="bg-gray-800 hover:bg-yellow-500 hover:text-black p-2 rounded"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="bg-gray-800 hover:bg-yellow-500 hover:text-black p-2 rounded"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="bg-gray-800 hover:bg-yellow-500 hover:text-black p-2 rounded"><i class="fab fa-instagram"></i></a>
          <a href="#" class="bg-gray-800 hover:bg-yellow-500 hover:text-black p-2 rounded"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <!-- Popular News -->
      <div>
        <h3 class="text-lg font-bold mb-4">POPULAR NEWS</h3>
        <div v-for="i in 3" :key="i" class="mb-4">
          <span class="bg-yellow-500 text-black text-xs font-bold px-2 py-1">BUSINESS</span>
          <span class="text-sm ml-2">Jan 01, 2045</span>
          <p class="mt-2 text-sm">LOREM IPSUM DOLOR SIT AMET ELIT. PROIN VITAE PORTA DIAM...</p>
        </div>
      </div>

      <!-- Categories -->
      <div>
        <h3 class="text-lg font-bold mb-4">CATEGORIES</h3>
        <div class="flex flex-wrap gap-2">
          <span v-for="(cat, i) in categories" :key="i" 
            class="bg-gray-700 px-3 py-1 text-sm rounded cursor-pointer hover:bg-yellow-500 hover:text-black">
            {{ cat }}
          </span>
        </div>
      </div>

      <!-- Flickr Photos -->
      <div>
        <h3 class="text-lg font-bold mb-4">FLICKR PHOTOS</h3>
        <div class="grid grid-cols-3 gap-2">
          <img v-for="i in 6" :key="i" src="https://picsum.photos/100?random={{ i }}" alt="photo" class="w-full h-20 object-cover rounded" />
        </div>
      </div>
    </div>

    <!-- Bottom -->
    <div class="bg-black text-gray-400 text-sm text-center py-4 mt-8">
      © <span class="text-yellow-500">Your Site Name.</span> All Rights Reserved. 
      Design by <span class="text-yellow-500">HTML Codex</span> 
      Distributed by <span class="text-yellow-500">ThemeWagon</span>
    </div>
  </footer>
</template>

<script setup>
const categories = [
  "Politics","Business","Corporate","Health","Education","Science",
  "Foods","Entertainment","Travel","Lifestyle"
]
</script>
