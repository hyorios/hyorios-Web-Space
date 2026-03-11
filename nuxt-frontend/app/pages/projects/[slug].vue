<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import AppNavbar from '../../components/AppNavbar.vue'
import AmbientBackground from '../../components/AmbientBackground.vue'

const route = useRoute()
const slug = route.params.slug as string
const project = ref<any>(null)
const loading = ref(true)
const error = ref<string | null>(null)
const locale = ref<'en' | 'de'>('en')

// Simple translation helper
const t = (field: any) => {
  if (typeof field === 'string') return field
  if (field && typeof field === 'object') {
    return field[locale.value] || field['en'] || field['de'] || ''
  }
  return field
}

const toggleLocale = () => {
  locale.value = locale.value === 'en' ? 'de' : 'en'
}

const config = useRuntimeConfig()

const fetchProject = async () => {
  try {
    const response = await fetch(`${config.public.apiBase}/projects/${slug}`)
    if (!response.ok) {
      if (response.status === 404) {
        throw new Error('Project not found')
      }
      throw new Error('Failed to fetch project details')
    }
    const data = await response.json()
    project.value = data.data || data
  } catch (err: any) {
    error.value = err.message
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchProject()
})
</script>

<template>
  <div class="font-sans text-zinc-50 min-h-screen relative overflow-hidden bg-zinc-950">
    <!-- Ambient Floating System -->
    <AmbientBackground />

    <!-- Glassmorphic Navigation -->
    <AppNavbar :locale="locale" @toggle-locale="toggleLocale" />

    <main class="relative z-10 pt-44 pb-24 px-8 max-w-4xl mx-auto">
      <div v-if="loading" class="text-center py-16 text-zinc-400 text-xl">
        {{ locale === 'en' ? 'Loading project details...' : 'Projektdetails werden geladen...' }}
      </div>
      
      <div v-else-if="error" class="text-center py-16">
        <h2 class="text-3xl font-bold text-rose-500 mb-4">Error</h2>
        <p class="text-zinc-400 mb-8">{{ error }}</p>
        <NuxtLink to="/" class="text-white hover:text-zinc-300 font-semibold underline decoration-zinc-500 underline-offset-4 transition-colors">
          &larr; {{ locale === 'en' ? 'Back to My Space' : 'Zurück zur Übersicht' }}
        </NuxtLink>
      </div>

      <div v-else-if="project" class="bg-zinc-900/60 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 shadow-2xl">
        <NuxtLink to="/" class="inline-block text-zinc-400 hover:text-white font-semibold mb-10 transition-colors uppercase tracking-wider text-sm">
          &larr; {{ locale === 'en' ? 'Back to My Space' : 'Zurück zur Übersicht' }}
        </NuxtLink>
        
        <header class="mb-12">
          <h1 class="text-4xl md:text-6xl font-black mb-6 tracking-tight leading-tight bg-gradient-to-br from-white to-zinc-400 bg-clip-text text-transparent">
            {{ t(project.title) }}
          </h1>
          <div class="flex flex-wrap gap-4 items-center">
            <a v-if="project.live_url" :href="project.live_url" target="_blank" rel="noopener noreferrer" class="bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md px-5 py-2 rounded-full text-sm font-bold text-white transition-all transform hover:-translate-y-0.5 inline-flex items-center gap-2">
              <span>{{ locale === 'en' ? 'Live Demo' : 'Live Vorschau' }}</span>
              <span class="text-lg leading-none">&nearr;</span>
            </a>
            <a v-if="project.repo_url" :href="project.repo_url" target="_blank" rel="noopener noreferrer" class="bg-transparent hover:bg-white/5 border border-zinc-600 hover:border-zinc-400 px-5 py-2 rounded-full text-sm font-bold text-zinc-300 transition-all transform hover:-translate-y-0.5 inline-flex items-center gap-2">
              <span>GitHub</span>
              <span class="text-lg leading-none">&nearr;</span>
            </a>
          </div>
        </header>

        <div class="space-y-12">
          <div class="w-full rounded-2xl overflow-hidden border border-white/10 shadow-2xl bg-black/50" v-if="project.thumbnail">
            <img :src="project.thumbnail" :alt="t(project.title)" class="w-full h-auto object-cover max-h-[600px]" />
          </div>
          
          <div class="space-y-8">
            <div>
              <h3 class="text-2xl font-bold mb-4 text-white">
                {{ locale === 'en' ? 'About this project' : 'Über das Projekt' }}
              </h3>
              <div class="text-zinc-400 text-lg leading-relaxed whitespace-pre-wrap">
                {{ t(project.description) }}
              </div>
            </div>

            <div v-if="project.tech_stack && project.tech_stack.length">
              <h3 class="text-2xl font-bold mb-4 text-white">
                 {{ locale === 'en' ? 'Tech Stack' : 'Technologien' }}
              </h3>
              <ul class="flex flex-wrap gap-3">
                <li v-for="tech in project.tech_stack" :key="tech" class="bg-white/5 border border-white/10 px-4 py-2 rounded-xl text-sm font-medium text-zinc-300 backdrop-blur-sm">
                  {{ tech }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
