<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const slug = route.params.slug as string
const project = ref<any>(null)
const loading = ref(true)
const error = ref<string | null>(null)

const fetchProject = async () => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/v1/projects/${slug}`)
    if (!response.ok) {
      if (response.status === 404) {
        throw new Error('Project not found')
      }
      throw new Error('Failed to fetch project details')
    }
    const data = await response.json()
    // Depending on Laravel resource, it might be wrapped in { data: ... }
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
  <main class="project-detail">
    <div v-if="loading" class="loading">Loading project details...</div>
    
    <div v-else-if="error" class="error">
      <h2>Error</h2>
      <p>{{ error }}</p>
      <NuxtLink to="/" class="back-link">← Back to My Space</NuxtLink>
    </div>

    <div v-else-if="project" class="project-content">
      <NuxtLink to="/" class="back-link">← Back to My Space</NuxtLink>
      
      <header class="project-header">
        <h1>{{ project.title }}</h1>
        <div class="project-meta">
          <span :class="['status-badge', project.status === 'active' ? 'active' : 'planned']">
            {{ project.status === 'active' ? 'Active' : 'Planned' }}
          </span>
          <span v-if="project.url" class="project-url">
            <a :href="project.url" target="_blank" rel="noopener noreferrer">Visit Project ↗</a>
          </span>
        </div>
      </header>

      <div class="project-body">
        <div class="project-image-container" v-if="project.image_url || project.image">
          <!-- Support both image field names depending on API response -->
          <img :src="project.image_url || project.image" :alt="project.title" class="project-image" />
        </div>
        
        <div class="project-description">
          <h3>About this project</h3>
          <p>{{ project.description }}</p>

          <template v-if="project.tech_stack && project.tech_stack.length">
            <h3>Tech Stack</h3>
            <ul class="tech-stack-list">
              <li v-for="tech in project.tech_stack" :key="tech" class="tech-item">{{ tech }}</li>
            </ul>
          </template>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.project-detail {
  max-width: 900px;
  margin: 0 auto;
  padding: 2rem;
  background: var(--glass-bg, rgba(255, 255, 255, 0.05));
  backdrop-filter: blur(12px);
  border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));
  border-radius: 20px;
  color: var(--text-primary, #f8fafc);
  margin-top: 4rem;
}

.loading, .error {
  text-align: center;
  padding: 4rem 2rem;
  font-size: 1.25rem;
}

.error {
  color: #ef4444;
}

.back-link {
  display: inline-block;
  color: var(--acc-primary, #3b82f6);
  text-decoration: none;
  margin-bottom: 2rem;
  font-weight: 600;
  transition: color 0.2s;
}

.back-link:hover {
  color: var(--acc-hover, #60a5fa);
}

.project-header h1 {
  font-size: 3rem;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, #e2e8f0 0%, #94a3b8 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.project-meta {
  display: flex;
  gap: 1.5rem;
  align-items: center;
  margin-bottom: 3rem;
}

.status-badge {
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 0.875rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.status-badge.active {
  background-color: rgba(34, 197, 94, 0.2);
  color: #4ade80;
  border: 1px solid rgba(34, 197, 94, 0.5);
}

.status-badge.planned {
  background-color: rgba(245, 158, 11, 0.2);
  color: #fbbf24;
  border: 1px solid rgba(245, 158, 11, 0.5);
}

.project-url a {
  color: var(--acc-primary, #3b82f6);
  text-decoration: none;
}

.project-url a:hover {
  text-decoration: underline;
}

.project-body {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.project-image-container {
  width: 100%;
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));
}

.project-image {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
}

.project-description h3 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  margin-top: 2rem;
  color: #e2e8f0;
}

.project-description p {
  line-height: 1.7;
  color: var(--text-secondary, #94a3b8);
  font-size: 1.125rem;
  white-space: pre-wrap;
}

.tech-stack-list {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.tech-item {
  background: rgba(255, 255, 255, 0.1);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-size: 0.875rem;
  color: #e2e8f0;
  border: 1px solid rgba(255, 255, 255, 0.05);
}
</style>
