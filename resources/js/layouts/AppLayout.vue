<template>
  <div class="min-h-screen flex flex-col bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <header class="bg-white shadow">
      <div class="container mx-auto flex justify-between items-center px-6 py-4">
        <!-- Logo -->
        <h1 class="text-xl font-bold text-blue-600">MyNews</h1>

        <!-- Navigation -->
        <nav class="space-x-6">
          <Link href="/" class="hover:text-blue-600 transition">Home</Link>
          <Link href="/posts" class="hover:text-blue-600 transition">Posts</Link>
          <Link href="/categories" class="hover:text-blue-600 transition">Categories</Link>
        </nav>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-6 py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 text-center text-sm text-gray-500">
      © 2025 MyNews. All rights reserved.
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
