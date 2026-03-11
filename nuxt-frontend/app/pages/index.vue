<script setup lang="ts">
import { ref, computed } from 'vue'
import AppNavbar from '../components/AppNavbar.vue'
import HeroSection from '../components/HeroSection.vue'
import AmbientBackground from '../components/AmbientBackground.vue'
import ProjectCard from '../components/ProjectCard.vue'

const locale = ref<'en' | 'de'>('en')

// Data fetching
const config = useRuntimeConfig()
const { data: response, pending } = useFetch<any>(`${config.public.apiBase}/projects`)

// Fallback logic for potentially wrapped JSON payload (data.data) in typical Laravel APIs
const projects = computed(() => {
  const payload = response.value?.data || response.value || []
  return Array.isArray(payload) ? payload : []
})

const toggleLocale = () => {
  locale.value = locale.value === 'en' ? 'de' : 'en'
}
</script>

<template>
  <div class="font-sans text-zinc-50 min-h-screen relative overflow-hidden bg-zinc-950">
    
    <!-- Ambient Floating System -->
    <AmbientBackground />

    <!-- Glassmorphic Navigation -->
    <AppNavbar :locale="locale" @toggle-locale="toggleLocale" />

    <!-- Content Area -->
    <main class="relative z-10 pt-44 pb-24 px-8 max-w-7xl mx-auto">
      <HeroSection :locale="locale" />

      <!-- Bento Grid structure -->
      <section id="projects" class="grid gap-6 grid-cols-1 md:grid-cols-3">
        <div v-if="pending" class="col-span-full text-center py-16 text-zinc-400 text-xl">
          {{ locale === 'en' ? 'Loading projects...' : 'Projekte werden geladen...' }}
        </div>
        
        <ProjectCard 
          v-else
          v-for="project in projects" 
          :key="project.slug || project.id"
          :project="project"
          :locale="locale"
        />
      </section>
    </main>
  </div>
</template>
