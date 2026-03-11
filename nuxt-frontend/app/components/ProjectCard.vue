<script setup lang="ts">
export interface ProjectProp {
  id: number | string;
  slug?: string;
  title: any;
  description?: any;
  excerpt?: any;
  tech_stack?: string[];
  thumbnail?: string;
  image_url?: string;
  image?: string;
  is_featured?: boolean;
}

const props = defineProps<{
  project: ProjectProp;
  locale: 'en' | 'de';
}>()

const t = (field: any) => {
  if (typeof field === 'string') return field
  if (field && typeof field === 'object') {
    return field[props.locale] || field['en'] || field['de'] || ''
  }
  return field
}
</script>

<template>
  <NuxtLink 
    :to="`/projects/${project.slug || project.id}`"
    :class="['project-card group', project.is_featured ? 'col-span-2' : 'col-span-1']"
  >
    <!-- Absolute Background Image for Zoom -->
    <div class="card-bg">
       <img 
         v-if="project.thumbnail || project.image_url || project.image" 
         :src="project.thumbnail || project.image_url || project.image" 
         :alt="t(project.title)" 
       />
       <div v-else class="fallback-bg"></div>
    </div>
    
    <!-- Content Foreground Overlay -->
    <div class="card-content">
       <h2 class="project-title">{{ t(project.title) }}</h2>
       <p class="project-excerpt">{{ t(project.excerpt || project.description) }}</p>
       
       <!-- Tech Stack Hover & Stagger Effect -->
       <div class="tech-stack" v-if="project.tech_stack && project.tech_stack.length">
         <span 
           v-for="(tech, index) in project.tech_stack" 
           :key="tech"
           :style="{ transitionDelay: `${index * 60}ms` }"
           class="tech-badge"
         >
           {{ tech }}
         </span>
       </div>
    </div>
  </NuxtLink>
</template>

<style scoped>
/* Interactive Bento Card */
.project-card {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  border-radius: 1.5rem;
  border: 1px solid rgba(255, 255, 255, 0.08);
  background: rgba(255, 255, 255, 0.02);
  backdrop-filter: blur(10px);
  overflow: hidden;
  text-decoration: none;
  min-height: 420px;
  color: inherit;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
  transition: border-color 0.4s ease, transform 0.4s ease, box-shadow 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.col-span-1 {
  grid-column: span 1 / span 1;
}

.col-span-2 {
  grid-column: span 2 / span 2;  /* Featured projects take two blocks */
}

.project-card:hover {
  border-color: rgba(255, 255, 255, 0.25);
  transform: translateY(-6px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
}

.card-bg {
  position: absolute;
  inset: 0;
  z-index: 0;
  overflow: hidden; /* Ensures zoom doesn't break radius */
}

.fallback-bg {
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
  opacity: 0.8;
}

.card-bg img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0.4;
  transition: transform 0.9s cubic-bezier(0.2, 0.8, 0.2, 1), opacity 0.5s ease;
}

/* Background image slightly zooms */
.project-card:hover .card-bg img {
  transform: scale(1.08); 
  opacity: 0.65;
}

.card-content {
  position: relative;
  z-index: 10;
  padding: 2.5rem;
  background: linear-gradient(to top, rgba(10, 10, 10, 0.98) 0%, rgba(10, 10, 10, 0.6) 60%, transparent 100%);
  transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.project-card:hover .card-content {
  transform: translateY(-8px);
}

.project-title {
  font-size: 2rem;
  font-weight: 800;
  margin: 0 0 0.8rem 0;
  color: #ffffff;
  letter-spacing: -0.02em;
}

.project-excerpt {
  color: #a1a1aa;
  font-size: 1.05rem;
  line-height: 1.6;
  margin: 0 0 1.5rem 0;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.tech-stack {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
}

.tech-badge {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  padding: 0.4rem 0.9rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
  color: #fafafa;
  
  /* Initial state: translated down and invisible */
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), 
              transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

/* Icons stagger effect on hover */
.project-card:hover .tech-badge {
  opacity: 1;
  transform: translateY(0);
}
</style>
