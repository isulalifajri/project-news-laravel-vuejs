<template>
  <header>
    <!-- Topbar -->
    <div class="bg-gray-900 text-gray-200 text-sm">
      <div class="container mx-auto flex justify-between items-center px-4 py-2">
        <!-- Left: date + menu -->
        <div class="flex items-center space-x-4">
          <span>Monday, January 1, 2045</span>
          <nav class="flex space-x-4 border-l border-gray-700 pl-4">
            <Link href="/advertise" class="hover:text-yellow-400">Advertise</Link>
            <Link href="/contact" class="hover:text-yellow-400">Contact</Link>
            <Link href="/login" class="hover:text-yellow-400">Login</Link>
          </nav>
        </div>

        <!-- Right: social icons -->
        <div class="flex space-x-3 text-gray-400">
          <a href="#"><i class="fab fa-twitter hover:text-white"></i></a>
          <a href="#"><i class="fab fa-facebook hover:text-white"></i></a>
          <a href="#"><i class="fab fa-linkedin hover:text-white"></i></a>
          <a href="#"><i class="fab fa-instagram hover:text-white"></i></a>
          <a href="#"><i class="fab fa-youtube hover:text-white"></i></a>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white border-b">
      <div class="container mx-auto flex justify-between items-center px-4 py-6">
        <!-- Logo -->
        <h1 class="text-3xl font-extrabold">
          <span class="text-yellow-500">BIZ</span><span class="text-gray-800">NEWS</span>
        </h1>

        <!-- Right: search + login -->
        <div class="flex items-center space-x-4">
          <!-- Search Form -->
          <form class="relative">
            <input
              type="text"
              placeholder="Search..."
              class="border rounded-full px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-500"
            />
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-blue-600">
              <i class="fas fa-search"></i>
            </button>
          </form>

          <!-- Login Icon -->
          <Link href="/login" class="text-gray-600 hover:text-blue-600">
            <i class="fas fa-user-circle text-2xl"></i>
          </Link>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
