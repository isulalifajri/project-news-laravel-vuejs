<template>
  <AppLayout>
    <!-- Banner Iklan -->
    <div class="w-full mb-8 flex justify-center">
      <img
        src="https://picsum.photos/1000/150?random=50"
        alt="Advertisement"
        class="w-full md:w-3/4 h-20 md:h-28 object-cover rounded-lg shadow"
      />
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Left Content -->
      <div class="lg:col-span-2">
        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-bold mb-3">
          {{ post.title }}
        </h1>

        <!-- Meta -->
        <p class="text-sm text-gray-500 mb-5">
          By <span class="font-semibold">{{ post.author }}</span> •
          {{ post.date }}
        </p>

        <!-- Featured Image -->
        <img
          :src="post.image"
          alt="featured image"
          class="w-full rounded-lg shadow mb-6"
        />

        <!-- Content -->
        <div class="prose max-w-none mb-10">
          <p class="mb-4" v-html="post.content">
          </p>
        </div>

        <!-- Action Bar -->
       <div class="border border-blue-300 bg-gray-50 rounded-lg shadow-sm flex items-center gap-6 px-4 py-3 mb-6">
          <button
            @click="likes++"
            class="flex items-center gap-1 text-gray-600 hover:text-yellow-600 transition"
          >
            👍 <span>{{ likes }}</span>
          </button>

          <button
            @click="dislikes++"
            class="flex items-center gap-1 text-gray-600 hover:text-red-600 transition"
          >
            👎 <span>{{ dislikes }}</span>
          </button>

          <button
            class="flex items-center gap-1 text-gray-600 hover:text-blue-600 transition"
          >
            🔗 Share
          </button>

          <button
            @click="toggleFavorite"
            class="flex items-center gap-1 text-gray-600 hover:text-yellow-500 transition"
          >
            ⭐ <span>{{ isFavorite ? "Favorit" : "Save" }}</span>
          </button>

          <span class="ml-auto text-sm text-gray-500">
            💬 {{ comments.length }} comments
          </span>
        </div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-10">
          <span
            v-for="(tag, i) in post.tags"
            :key="i"
            class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full hover:bg-yellow-400 hover:text-black cursor-pointer"
          >
            #{{ tag }}
          </span>
        </div>

        <!-- Comments Section -->
        <div class="border-t pt-6">
          <h3 class="text-lg font-bold mb-4">Comment ({{ comments.length }})</h3>

          <!-- Input komentar -->
          <div class="flex items-start gap-3 mb-6">
            <img
              src="https://i.pravatar.cc/40?img=2"
              alt="User"
              class="w-10 h-10 rounded-full"
            />
            <textarea
              v-model="newComment"
              placeholder="Tulis komentar..."
              class="w-full border rounded-lg p-2 focus:ring focus:ring-yellow-300"
              rows="3"
            ></textarea>
            <button
              @click="addComment"
              class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600"
            >
              Kirim
            </button>
          </div>

          <!-- List komentar -->
          <div
            v-for="(comment, i) in comments"
            :key="i"
            class="flex items-start gap-3 mb-4"
          >
            <img
              :src="comment.avatar"
              alt="User"
              class="w-10 h-10 rounded-full"
            />
            <div class="flex-1 bg-gray-100 rounded-lg p-3">
              <p class="text-sm font-semibold">{{ comment.author }}</p>
              <p class="text-sm text-gray-700">{{ comment.text }}</p>
              <div class="flex gap-4 text-xs text-gray-500 mt-1">
                <span>👍 {{ comment.likes }}</span>
                <span class="cursor-pointer hover:underline">Balas</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Sidebar -->
      <div class="lg:col-span-1">
        <TrendingNews />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue"
import TrendingNews from "@/Pages/TrendingNews.vue"
import { ref } from "vue"

const props = defineProps({
  post: Object,
})

// State interaksi
const likes = ref(8)
const dislikes = ref(2)
const isFavorite = ref(false)

function toggleFavorite() {
  isFavorite.value = !isFavorite.value
}

// Komentar
const comments = ref([
  {
    author: "Budi",
    text: "Artikel yang sangat menarik 👍",
    avatar: "https://i.pravatar.cc/40?img=5",
    likes: 8,
  },
  {
    author: "Siti",
    text: "Semoga reformasi berjalan lancar!",
    avatar: "https://i.pravatar.cc/40?img=6",
    likes: 5,
  },
])

const newComment = ref("")

function addComment() {
  if (newComment.value.trim() === "") return
  comments.value.push({
    author: "Guest",
    text: newComment.value,
    avatar: "https://i.pravatar.cc/40?img=7",
    likes: 0,
  })
  newComment.value = ""
}
</script>
