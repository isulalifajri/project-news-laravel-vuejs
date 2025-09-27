<template>
  <AppLayout
    :company-profile="props.companyProfile"
    :sosmed-icons="props.sosmedIcons"
    :footer-contacts="props.footerContacts"
    :categories="props.categories"
    :most-populars="props.mostPopulars"
  >
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
          {{ props.post.title }}
        </h1>

        <!-- Meta -->
        <p class="text-sm text-gray-500 mb-5">
          By <span class="font-semibold">{{ props.post.author }}</span> •
          {{ props.post.date }}
        </p>

        <!-- Featured Image -->
        <img
          :src="props.post.image"
          alt="featured image"
          class="w-full rounded-lg shadow mb-6"
        />

        <!-- Content -->
        <div class="prose max-w-none mb-10" v-html="props.post.content"></div>

        <!-- Action Bar -->
        <div
          class="border border-blue-300 bg-gray-50 rounded-lg shadow-sm flex items-center gap-6 px-4 py-3 mb-6"
        >
          <!-- Like -->
          <button
            @click="likes++"
            class="flex items-center gap-1 text-gray-600 hover:text-yellow-600 transition"
          >
            <i class="fas fa-thumbs-up"></i> <span>{{ likes }}</span>
          </button>

          <!-- Share -->
          <button
            @click="sharePost"
            class="flex items-center gap-1 text-gray-600 hover:text-blue-600 transition cursor-pointer"
          >
            <i class="fas fa-share"></i> Share
          </button>

          <!-- Save / Favorite -->
          <button
            @click="toggleFavorite"
            class="flex items-center gap-1 text-gray-600 hover:text-yellow-500 transition"
          >
            <i class="fas fa-star"></i>
            <span>{{ isFavorite ? 'Favorit' : 'Save' }}</span>
          </button>

          <!-- Comments -->
          <span class="ml-auto flex items-center gap-1 text-sm text-gray-500">
            <i class="fas fa-comment"></i> {{ comments.length }} comments
          </span>
        </div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mb-10">
          <span
            v-for="(tag, i) in props.post.tags"
            :key="i"
            class="bg-gray-200 text-gray-700 text-xs px-3 py-1 rounded-full hover:bg-yellow-400 hover:text-black cursor-pointer"
          >
            #{{ tag }}
          </span>
        </div>

        <!-- Comments Section -->
        <div class="border-t pt-6">
          <h3 class="text-lg font-bold mb-4">
            Comment ({{ comments.length }})
          </h3>

          <!-- Input komentar -->
          <div class="flex items-start gap-3 mb-6">
            <img
              v-if="user"
              :src="user.avatar ?? 'https://i.pravatar.cc/40?img=2'"
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
              class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 cursor-pointer"
            >
              Kirim
            </button>
          </div>

          <!-- List komentar -->
          <div v-for="comment in visibleComments" :key="comment.id" class="flex items-start gap-3 mb-4">
            <img :src="comment.avatar ?? 'https://i.pravatar.cc/40?img=5'" alt="User" class="w-10 h-10 rounded-full" />
            <div class="flex-1 bg-gray-100 rounded-lg p-3">
              <p class="text-sm font-semibold">{{ comment.author }}</p>
              <p class="text-sm text-gray-700">{{ comment.content }}</p>
              <div class="flex gap-4 text-xs text-gray-500 mt-1">
                <button @click="toggleLike(comment)" class="flex items-center gap-1 cursor-pointer" :class="comment.liked_by_me ? 'text-blue-600' : 'text-gray-500'">
                  <i class="fas fa-thumbs-up"></i> {{ comment.likes_count }}
                </button>
                <span class="cursor-pointer hover:underline">Balas</span>
                <button v-if="user && comment.user_id === user.id" @click="deleteComment(comment)" class="text-gray-500 hover:underline ml-auto cursor-pointer"><i class="fa-solid fa-trash"></i></button>
              </div>
            </div>
          </div>

          <!-- Tombol lihat selengkapnya -->
          <button v-if="comments.length > 2 && !showAllComments" @click="showAllComments = true" class="text-blue-500 hover:underline mb-6 flex ml-auto cursor-pointer">
            Lihat Selengkapnya
          </button>

        </div>
      </div>

      <!-- Right Sidebar -->
      <div class="lg:col-span-1">
        <TrendingNews :trending-News="props.trendingNews" />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue"
import TrendingNews from "@/Pages/TrendingNews.vue"
import { ref, computed } from "vue"
import { usePage } from "@inertiajs/vue3"
import axios from "axios"

axios.defaults.withCredentials = true
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"
axios.defaults.headers.common["X-CSRF-TOKEN"] =
  document.querySelector('meta[name="csrf-token"]').getAttribute("content")

const page = usePage()
const user = computed(() => page.props.auth?.user ?? null)

const props = defineProps({
  post: Object,
  comments: { type: Array, default: () => [] },
  companyProfile: { type: Object, required: true },
  sosmedIcons: { type: Array, default: () => [] },
  footerContacts: { type: Array, default: () => [] },
  mostPopulars: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  trendingNews: { type: Array, default: () => [] },
})

// state interaksi
const likes = ref(8)
const isFavorite = ref(false)
function toggleFavorite() {
  isFavorite.value = !isFavorite.value
}

// komentar
const comments = ref(props.comments)
const newComment = ref("")

const showAllComments = ref(false)

// computed untuk menampilkan komentar terbatas
const visibleComments = computed(() => {
  if (showAllComments.value) return comments.value
  return comments.value.slice(0, 2) // tampilkan 2 komentar pertama
})

// add comment
async function addComment() {
  if (!user.value) {
    window.location.href = route("google.login")
    return
  }

  if (newComment.value.trim().length < 1) {
    alert("Tulis Komentar anda.")
    return
  }

  try {
    const res = await axios.post(route("comments.store", { post: props.post.id }), {
      content: newComment.value,
    })
    comments.value.unshift(res.data.comment)
    newComment.value = ""
  } catch (err) {
    console.error("Gagal kirim komentar", err)
  }
}

// toggle like
async function toggleLike(comment) {
  if (!user.value) {
    window.location.href = route("google.login")
    return
  }

  try {
    const res = await axios.post(route("comments.toggle-like", { comment: comment.id }))
    comment.liked_by_me = res.data.is_liked
    comment.likes_count = res.data.likes_count
  } catch (err) {
    console.error("Gagal toggle like", err)
  }
}

// delete comment
async function deleteComment(comment) {
  try {
   await axios.delete(route("comments.destroy", { id: comment.id }))
    comments.value = comments.value.filter(c => c.id !== comment.id)
  } catch (err) {
    console.error("Gagal hapus komentar", err)
  }
}
</script>
