<template>
  <div class="min-h-screen">
    <!-- Header -->
    <Header 
    :company-profile="companyProfile" 
    :sosmed-icons="sosmedIcons"  
    :footer-contatcs="sosmedIcons"  
    />

    <!-- Main Content -->
    <main class="flex-grow max-w-screen-xl mx-auto px-4 py-6">
      <slot />
    </main>

    <!-- Footer -->
    <Footer
    :sosmed-icons="sosmedIcons"
    :footer-contacts="props.footerContacts"
    :categories="props.categories"
    :most-populars="props.mostPopulars"  />
  </div>
</template>

<script setup>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'

const props = defineProps({
  companyProfile: { type: Object, required: true },
  sosmedIcons: { type: Array, default: () => [] },
  footerContacts: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  mostPopulars: { type: Array, default: () => [] },
})
</script>
