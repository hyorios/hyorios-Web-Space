<script setup lang="ts">
import { ref, computed } from 'vue'
import AppNavbar from '../components/AppNavbar.vue'
import HeroSection from '../components/HeroSection.vue'
import AmbientBackground from '../components/AmbientBackground.vue'
import ProjectCard from '../components/ProjectCard.vue'

const locale = ref<'en' | 'de'>('en')

// Data fetching
const { data: response, pending } = useFetch<any>('http://127.0.0.1:8000/api/v1/projects')

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
  <div class="portfolio-container font-sans text-white min-h-screen relative overflow-hidden">
    
    <!-- Ambient Floating System -->
    <AmbientBackground />

    <!-- Glassmorphic Navigation -->
    <AppNavbar :locale="locale" @toggle-locale="toggleLocale" />

    <!-- Content Area -->
    <main class="main-content">
      <HeroSection :locale="locale" />

      <!-- Bento Grid structure -->
      <section id="projects" class="projects-grid">
        <div v-if="pending" class="col-span-full loading-state">
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

<style scoped>
.portfolio-container {
  background-color: #0a0a0a;
  color: #fafafa;
  min-height: 100vh;
  position: relative;
  overflow-x: hidden;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

/* Layout Content */
.main-content {
  position: relative;
  z-index: 10;
  padding: 11rem 2rem 6rem;
  max-width: 1300px;
  margin: 0 auto;
}

/* Grid mimics utility classes (grid-cols-1 md:grid-cols-3) */
.projects-grid {
  display: grid;
  gap: 1.5rem;
  grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 768px) {
  .projects-grid {
    grid-template-columns: repeat(3, minmax(0, 1fr)); /* Equivalent to md:grid-cols-3 */
  }
}

.col-span-full {
  grid-column: 1 / -1;
}

.loading-state {
  text-align: center;
  padding: 4rem;
  color: #a1a1aa;
  font-size: 1.25rem;
}
</style>
