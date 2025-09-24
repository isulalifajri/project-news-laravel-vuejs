<template>
  <header>
    <!-- Topbar -->
    <div class="bg-[#0b132b] text-gray-300 text-sm">
      <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4 py-2">
        <!-- Left: date + menu -->
        <div class="flex items-center space-x-4">
          <span class="text-gray-400 hidden sm:inline">{{ formattedDate }}</span>
          <nav class="hidden sm:flex space-x-4 border-l border-gray-700 pl-4">
            <Link href="/contact" class="hover:text-blue-400 transition">Contact</Link>
            <Link href="/login" class="hover:text-blue-400 transition">Login</Link>
          </nav>
        </div>

        <!-- Right: social icons -->
        <div class="flex space-x-4 text-gray-400 text-lg">
          <template v-if="props.footerContacts && props.footerContacts.length > 0">
          <a 
            v-for="(item, i) in props.footerContacts" 
            :key="i" 
            :href="item.value || '#'" 
            class="hover:text-blue-400"
            target="_blank"
            v-html="item.icon"
          ></a>
        </template>

        <!-- Fallback default kalau footerContacts kosong -->
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
            <span class="text-blue-500">{{ firstWord }}</span>
            <span v-if="restWords" class="text-gray-800"> {{ restWords }}</span>
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
              <i class="fas fa-user-circle text-5xl"></i>
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
                    <Link
                      href="/login"
                      class="block w-full text-center bg-blue-500 text-black py-2 rounded-lg hover:bg-blue-600 font-semibold"
                    >
                      Login
                    </Link>
                  </div>

                  <div v-else class="flex items-center gap-3">
                    <img
                      src="https://i.pravatar.cc/40?img=12"
                      alt="User"
                      class="w-10 h-10 rounded-full border border-gray-600"
                    />
                    <div class="flex-1">
                      <p class="text-sm font-semibold">John Doe</p>
                      <Link href="/profile" class="text-xs text-gray-400 hover:text-blue-500">
                        Lihat Profil
                      </Link>
                    </div>
                    <button
                      @click="logout"
                      class="text-sm text-red-400 hover:text-red-500 font-medium"
                    >
                      Logout
                    </button>
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
          <li><Link :href="route('home')" class="block py-3 px-4 hover:bg-blue-500 hover:text-black">NEWS</Link></li>
          <li><Link :href="route('category')" class="block py-3 px-4 hover:bg-blue-500 hover:text-black">CATEGORY</Link></li>
          <li><Link :href="route('show')" class="block py-3 px-4 hover:bg-blue-500 hover:text-black">SINGLE NEWS</Link></li>
          <li class="relative group">
            <button class="block py-3 px-4 hover:bg-blue-500 hover:text-black flex items-center">
              DROPDOWN <i class="fas fa-chevron-down ml-2 text-sm"></i>
            </button>
            <ul class="absolute left-0 hidden group-hover:block bg-white shadow-md text-gray-800 min-w-[150px]">
              <li><Link href="/submenu1" class="block px-4 py-2 hover:bg-gray-100">Submenu 1</Link></li>
              <li><Link href="/submenu2" class="block px-4 py-2 hover:bg-gray-100">Submenu 2</Link></li>
            </ul>
          </li>
          <li><Link href="/contact" class="block py-3 px-4 hover:bg-blue-500 hover:text-black">CONTACT</Link></li>
        </ul>
      </div>
    </nav>

    <!-- Mobile menu -->
    <transition name="fade">
      <div v-if="mobileOpen" class="bg-[#0b132b] md:hidden">
        <div class="px-4 py-3 space-y-5 text-white font-medium">

          <!-- 🔍 Search bar (paling atas) -->
          <form class="relative">
            <input
              type="text"
              placeholder="Search..."
              class="w-full border rounded-full px-4 py-2 pr-10 text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
            />
            <button type="submit" class="absolute right-3 top-2.5 text-gray-500 hover:text-blue-500">
              <i class="fas fa-search"></i>
            </button>
          </form>

          <!-- 📌 Navigasi utama -->
          <div class="space-y-2">
            <Link href="/" class="block hover:text-blue-400">HOME</Link>
            <Link href="/category" class="block hover:text-blue-400">CATEGORY</Link>
            <Link href="/single-news" class="block hover:text-blue-400">SINGLE NEWS</Link>
            <Link href="/contact" class="block hover:text-blue-400">CONTACT</Link>
          </div>

          <!-- 📝 Aktivitas (di atas login) -->
          <div class="pt-4 border-t border-gray-700">
            <h4 class="text-gray-300 uppercase text-xs tracking-wide mb-2">Aktivitas</h4>
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
              <Link
                href="/login"
                class="block w-full text-center bg-blue-500 text-black py-2 rounded-lg hover:bg-blue-600 font-semibold"
              >
                Login
              </Link>
            </div>

            <!-- Jika sudah login -->
            <div v-else class="flex items-center gap-3">
              <!-- Avatar user -->
              <img
                src="https://i.pravatar.cc/40?img=12"
                alt="User"
                class="w-10 h-10 rounded-full border border-gray-600"
              />
              <div class="flex-1">
                <p class="text-sm font-semibold">John Doe</p>
                <Link href="/profile" class="text-xs text-gray-400 hover:text-blue-400">
                  Lihat Profil
                </Link>
              </div>
              <!-- Logout -->
              <button
                @click="logout"
                class="text-sm text-red-400 hover:text-red-500 font-medium"
              >
                Logout
              </button>
            </div>
          </div>

        </div>
      </div>
    </transition>

  </header>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  companyProfile: { type: Object, required: true },
  footerContacts: { type: Array, default: () => [] }
})

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
const isLoggedIn = ref(false)

function logout() {
  isLoggedIn.value = false
  console.log("User logged out")
}

const userDropdown = ref(false)
const dropdownRef = ref(null)

function toggleDropdown() {
  userDropdown.value = !userDropdown.value
}

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
