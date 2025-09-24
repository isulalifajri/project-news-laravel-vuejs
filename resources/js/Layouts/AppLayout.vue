<template>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
    <Header 
    :company-profile="companyProfile" 
    :footer-contacts="footerContacts"  
    />

    <!-- Main Content -->
    <main class="flex-grow max-w-screen-xl mx-auto px-4 py-6">
      <slot />
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'

const props = defineProps({
  companyProfile: { type: Object, required: true },
  footerContacts: { type: Array, default: () => [] },
})
</script>
