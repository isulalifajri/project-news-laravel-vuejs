<template>
  <header>
    <!-- Topbar -->
    <div class="bg-[#0b132b] text-gray-300 text-sm">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-2">
        <!-- Left: date + menu -->
        <div class="flex items-center space-x-4">
          <span class="text-gray-400 hidden sm:inline">Monday, January 1, 2045</span>
          <nav class="hidden sm:flex space-x-4 border-l border-gray-700 pl-4">
            <Link href="/advertise" class="hover:text-yellow-400 transition">Advertise</Link>
            <Link href="/contact" class="hover:text-yellow-400 transition">Contact</Link>
            <Link href="/login" class="hover:text-yellow-400 transition">Login</Link>
          </nav>
        </div>

        <!-- Right: social icons -->
        <div class="flex space-x-4 text-gray-400 text-lg">
          <a href="#" class="hover:text-yellow-400"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-yellow-400"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-yellow-400"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="hover:text-yellow-400"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-yellow-400"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white border-b">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-4">
        <!-- Logo -->
        <h1 class="text-2xl md:text-3xl font-extrabold">
          <span class="text-yellow-500">BIZ</span><span class="text-gray-800">NEWS</span>
        </h1>

        <!-- Search + Login (desktop) -->
        <div class="hidden md:flex items-center space-x-4">
          <!-- Search Form -->
          <form class="relative w-80">
            <input
              type="text"
              placeholder="Search..."
              class="w-full border rounded-full px-4 py-2 pr-10 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
            />
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-yellow-500">
              <i class="fas fa-search"></i>
            </button>
          </form>

          <!-- Login Icon -->
          <Link href="/login" class="text-gray-600 hover:text-yellow-500">
            <i class="fas fa-user-circle text-5xl"></i>
          </Link>
        </div>

        <!-- Mobile menu button -->
        <button
          @click="mobileOpen = !mobileOpen"
          class="md:hidden text-gray-700 focus:outline-none"
        >
          <i class="fas" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i>
        </button>
      </div>
    </div>

    <!-- Navbar (desktop) -->
    <nav class="bg-[#0b132b] hidden md:block">
      <div class="max-w-screen-xl mx-auto px-4">
        <ul class="flex space-x-8 text-white font-medium">
          <li><Link href="/" class="block py-3 px-4 hover:bg-yellow-500 hover:text-black">HOME</Link></li>
          <li><Link href="/category" class="block py-3 px-4 hover:bg-yellow-500 hover:text-black">CATEGORY</Link></li>
          <li><Link href="/single-news" class="block py-3 px-4 hover:bg-yellow-500 hover:text-black">SINGLE NEWS</Link></li>
          <li class="relative group">
            <button class="block py-3 px-4 hover:bg-yellow-500 hover:text-black flex items-center">
              DROPDOWN <i class="fas fa-chevron-down ml-2 text-sm"></i>
            </button>
            <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md text-gray-800 min-w-[150px]">
              <li><Link href="/submenu1" class="block px-4 py-2 hover:bg-gray-100">Submenu 1</Link></li>
              <li><Link href="/submenu2" class="block px-4 py-2 hover:bg-gray-100">Submenu 2</Link></li>
            </ul>
          </li>
          <li><Link href="/contact" class="block py-3 px-4 hover:bg-yellow-500 hover:text-black">CONTACT</Link></li>
        </ul>
      </div>
    </nav>

    <!-- Mobile menu -->
    <transition name="fade">
      <div v-if="mobileOpen" class="bg-[#0b132b] md:hidden">
        <div class="px-4 py-3 space-y-2 text-white font-medium">
          <Link href="/" class="block hover:text-yellow-400">HOME</Link>
          <Link href="/category" class="block hover:text-yellow-400">CATEGORY</Link>
          <Link href="/single-news" class="block hover:text-yellow-400">SINGLE NEWS</Link>
          <Link href="/contact" class="block hover:text-yellow-400">CONTACT</Link>

          <!-- Mobile search -->
          <form class="mt-3 relative">
            <input
              type="text"
              placeholder="Search..."
              class="w-full border rounded-full px-4 py-2 pr-10 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
            />
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-yellow-500">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

const mobileOpen = ref(false)
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
