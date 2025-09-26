<template>
  <header>
    <!-- Topbar -->
    <div class="bg-[#0b132b] text-gray-300 text-sm">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-2">
        <!-- Left: date + menu -->
        <div class="flex items-center space-x-4">
          <span class="text-gray-400 hidden sm:inline">{{ formattedDate }}</span>
          <nav class="hidden sm:flex space-x-4 border-l border-gray-700 pl-4">
            <Link :href="route('contact')" class="hover:text-blue-400 transition">Contact</Link>

            <a :href="route('google.login')" v-if="!isLoggedIn" class="hover:text-blue-400 transition">Login</a>
          </nav>
        </div>

        <!-- Right: social icons -->
        <div class="flex space-x-4 text-gray-400 text-lg">
          <template v-if="props.sosmedIcons && props.sosmedIcons.length > 0">
          <a 
            v-for="(item, i) in props.sosmedIcons" 
            :key="i" 
            :href="item.value ? (item.value.startsWith('http') ? item.value : `https://${item.value}`) : '#'"
            class="hover:text-blue-400"
            target="_blank"
            v-html="item.icon"
          ></a>
        </template>

        <!-- Fallback default kalau sosmedIcons kosong -->
        <template v-else>
          <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-blue-400"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-blue-400"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="hover:text-blue-400"><i class="fab fa-instagram"></i></a>
          <a href="#" class="hover:text-blue-400"><i class="fab fa-youtube"></i></a>
        </template>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="bg-white border-b">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-4">
        <!-- Logo -->
        <Link :href="route('home')">
          <h1 class="text-2xl md:text-3xl font-extrabold cursor-pointer">
            <span class="text-blue-500 uppercase">{{ firstWord }}</span>
            <span v-if="restWords" class="text-gray-800 uppercase"> {{ restWords }}</span>
          </h1>
        </Link>

        <!-- Search + Login (desktop) -->
        <div class="hidden md:flex items-center space-x-4">
          <!-- Search Form -->
          <form class="relative w-80">
            <input
              type="text"
              placeholder="Search..."
              class="w-full border rounded-full px-4 py-2 pr-10 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
            />
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-blue-500">
              <i class="fas fa-search"></i>
            </button>
          </form>

           <div class="relative" ref="dropdownRef">
            <!-- Icon User -->
            <button
              @click="userDropdown = !userDropdown"
              class="text-gray-600 hover:text-blue-500 focus:outline-none"
            >
              <!-- <i class="fas fa-user-circle text-5xl cursor-pointer"></i> -->
               <!-- Belum login → icon default -->
              <i v-if="!user" class="fas fa-user-circle text-5xl cursor-pointer"></i>

              <!-- Sudah login dan ada avatar -->
              <img
                v-else-if="user?.avatar"
                :src="user.avatar"
                alt="User Avatar"
                class="w-12 h-12 object-cover rounded-full cursor-pointer"
              />

              <!-- Sudah login tapi tanpa avatar → inisial -->
              <span
                v-else
                class="flex items-center justify-center w-12 h-12 font-bold text-lg text-gray-600 rounded-full bg-blue-300"
              >
                {{ initials }}
              </span>
            </button>

            <!-- Dropdown Card -->
            <div
              v-if="userDropdown"
              class="absolute right-0 mt-2 w-72 bg-white shadow-lg rounded-lg border border-gray-200 z-50"
            >
              <div class="p-4">
                <!-- 📝 Aktivitas -->
                <div>
                  <h4 class="text-gray-400 uppercase text-xs tracking-wide mb-2">Aktivitas</h4>
                  <Link href="/saved" class="flex items-center px-2 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                    <i class="fas fa-bookmark w-5"></i>
                    <span class="ml-2">Konten yang Disimpan</span>
                  </Link>
                  <Link href="/liked" class="flex items-center px-2 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                    <i class="fas fa-heart w-5"></i>
                    <span class="ml-2">Konten yang Disukai</span>
                  </Link>
                </div>

                <!-- 👤 Kondisional: login atau user info -->
                <div class="mt-3 border-t pt-3">
                  <div v-if="!isLoggedIn">
                    <a
                      :href="route('google.login')"
                      class="block w-full text-center bg-blue-500 text-black py-2 rounded-lg hover:bg-blue-600 font-semibold"
                    >
                      Login
                    </a>
                  </div>

                  <div v-else class="flex items-center gap-3">
                    <img
                        v-if="user?.avatar"
                        :src="user.avatar"
                        alt="User Avatar"
                        class="w-12 h-12 object-cover rounded-full cursor-pointer"
                      />
                    <span
                      v-else
                      class="flex items-center justify-center w-10 h-10 font-bold text-lg text-gray-600 rounded-full bg-blue-300"
                    >
                      {{ initials }}
                    </span>
                    <div class="flex-1">
                      <p class="text-sm font-semibold capitalize">{{ user.name }}</p>
                      <Link href="/profile" class="text-xs text-gray-400 hover:text-blue-500">
                        Lihat Profil
                      </Link>
                    </div>
                    <Link
                      :href="route('logout')"
                      method="post"
                      as="button"
                      class="text-sm text-red-400 hover:text-red-500 font-medium cursor-pointer"
                    >
                      Logout
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
          <li>
            <Link
              :href="route('posts')"
              class="block py-3 px-4"
              :class="isActive('/news') ? 'bg-blue-500 text-black' : 'hover:bg-blue-500 hover:text-black'"
            >NEWS</Link></li>
          <li class="relative group">
            <button class="block py-3 px-4 hover:bg-blue-500 flex items-center"
            :class="isActive('/category') ? 'bg-blue-500 text-black' : 'hover:bg-blue-500 hover:text-black'">
              CATEGORY <i class="fas fa-chevron-down ml-2 text-sm"></i>
            </button>
            <ul
              class="absolute left-0 hidden group-hover:block bg-white shadow-md text-gray-800 min-w-[150px] z-50"
            >
              <li
                v-for="cat in categories"
                :key="cat.id"
              >
                <Link
                  :href="route('category.show', cat.slug)"
                  class="block px-4 py-2 hover:bg-blue-100 rounded"
                  :class="isActive('/category/' + cat.slug) ? 'bg-blue-100 text-black' : 'hover:bg-blue-100 hover:text-black'"
                >
                  {{ cat.name }}
                </Link>
              </li>
            </ul>
          </li>
          <li>
            <Link :href="route('contact')" class="block py-3 px-4"
            :class="isActive('/contact') ? 'bg-blue-500 text-black' : 'hover:bg-blue-500 hover:text-black'">CONTACT</Link>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Mobile menu -->
    <transition name="fade">
      <div v-if="mobileOpen" class="bg-[#0b132b] md:hidden">
        <div class="px-2 py-3 space-y-5 text-white font-medium">

          <!-- 🔍 Search bar (paling atas) -->
          <form class="relative px-2">
            <input
              type="text"
              placeholder="Search..."
              class="w-full border rounded-full px-4 py-2 pr-10 text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
            />
            <button type="submit" class="absolute right-5 top-2.5 text-gray-500 hover:text-blue-500">
              <i class="fas fa-search"></i>
            </button>
          </form>

          <!--  Navigasi utama -->
          <div class="space-y-2 px-2">
            <Link :href="route('posts')" 
            class="block px-2 py-2 hover:bg-blue-100 rounded"
            :class="isActive('/news') ? 'bg-blue-500 text-white' : 'hover:text-blue-400'">NEWS</Link>
            <!-- Category Dropdown Mobile -->
            <div>
              <button
                @click="mobileCategoryOpen = !mobileCategoryOpen"
                class="w-full flex justify-between items-center block px-2 py-2 hover:bg-blue-100 rounded"
                :class="isActive('/category') ? 'bg-blue-500 text-white' : 'hover:text-blue-400'"
              >
                CATEGORY
                <i class="fas" :class="mobileCategoryOpen ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
              </button>
              <ul v-if="mobileCategoryOpen" class="pl-4 mt-2 space-y-1">
                <li v-for="cat in props.categories" :key="cat.id">
                  <Link
                    :href="route('category.show', cat.slug)"
                    class="block px-1 py-1 hover:bg-blue-100 rounded"
                    :class="isActive('/category/' + cat.slug) ? 'bg-blue-100 text-black' : 'hover:bg-blue-100 hover:text-black'"
                    
                  >
                    {{ cat.name }}
                  </Link>
                </li>
              </ul>
            </div>
            <Link :href="route('contact')"  class="block px-2 py-2 hover:bg-blue-100 rounded"
            :class="isActive('/contact') ? 'bg-blue-500 text-white' : 'hover:text-blue-400'">CONTACT</Link>
          </div>

          <!-- 📝 Aktivitas (di atas login) -->
          <div class="pt-4 border-t border-gray-700 px-2">
            <h4 class="text-gray-300 uppercase text-xs tracking-wide mb-2 px-1">Aktivitas</h4>
            <div class="space-y-2">
              <Link href="/saved" class="block hover:text-blue-400">
                <i class="fas fa-bookmark mr-2"></i> Konten yang Disimpan
              </Link>
              <Link href="/liked" class="block hover:text-blue-400">
                <i class="fas fa-heart mr-2"></i> Konten yang Disukai
              </Link>
            </div>
          </div>

          <!-- 👤 Kondisional: login atau user info -->
          <div class="pt-4 border-t border-gray-700">
            <!-- Jika belum login -->
            <div v-if="!isLoggedIn">
              <a
                :href="route('google.login')"
                class="block w-full text-center bg-blue-500 text-black py-2 rounded-lg hover:bg-blue-600 font-semibold"
              >
                Login
              </a>
            </div>

            <!-- Jika sudah login -->
            <div v-else class="flex items-center gap-3">
              <!-- Avatar user -->
              <img
                v-if="user?.avatar"
                :src="user.avatar"
                alt="User Avatar"
                class="w-12 h-12 object-cover rounded-full cursor-pointer"
              />
              <span
                v-else
                class="flex items-center justify-center w-10 h-10 font-bold text-lg text-gray-600 rounded-full bg-blue-300"
              >
                {{ initials }}
              </span>
              <div class="flex-1">
                <p class="text-sm font-semibold">{{ user.name }}</p>
                <Link href="/profile" class="text-xs text-gray-400 hover:text-blue-400">
                  Lihat Profil
                </Link>
              </div>
              <!-- Logout -->
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="text-sm text-red-400 hover:text-red-500 font-medium cursor-pointer"
              >Logout
              </Link>
            </div>
          </div>

        </div>
      </div>
    </transition>

  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const props = defineProps({
  companyProfile: { type: Object, required: true },
  categories: { type: Array, default: () => [] },
  sosmedIcons: { type: Array, default: () => [] },
})

// Fungsi untuk ngecek URL saat ini
const isActive = (path) => {
  // path bisa string atau array
  if (Array.isArray(path)) {
    return path.some(p => page.url.startsWith(p))
  }
  return page.url.startsWith(path)
}

const nameWords = computed(() => (props.companyProfile?.name || '').split(' '))
const firstWord = computed(() => nameWords.value[0])
const restWords = computed(() => nameWords.value.slice(1).join(' '))


const today = ref(new Date())

const formattedDate = computed(() => {
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
  return today.value.toLocaleDateString('en-US', options)
})

function handleClickOutside(e) {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    userDropdown.value = false
  }
}

const mobileOpen = ref(false)
const mobileCategoryOpen = ref(false)
const isLoggedIn = computed(() => !!page.props.auth.user)

const user = computed(() => page.props.auth?.user ?? null)

// Ambil inisial dari nama user
const initials = computed(() => {
  if (!user.value?.name) return "?"
  return user.value.name
    .split(" ")                // pisah nama
    .map(word => word[0])      // ambil huruf depan
    .join("")                  // gabung
    .toUpperCase()             // kapital
})

const userDropdown = ref(false)
const dropdownRef = ref(null)


onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
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
