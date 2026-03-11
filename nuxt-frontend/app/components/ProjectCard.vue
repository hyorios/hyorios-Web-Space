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
    :class="[
      'group relative flex flex-col justify-end rounded-2xl border border-white/10 bg-zinc-900/50 backdrop-blur-md overflow-hidden min-h-[420px] shadow-lg transition-all duration-500 hover:border-white/25 hover:-translate-y-1.5 hover:shadow-2xl', 
      project.is_featured ? 'col-span-1 md:col-span-2' : 'col-span-1'
    ]"
  >
    <!-- Absolute Background Image for Zoom -->
    <div class="absolute inset-0 z-0 overflow-hidden rounded-2xl">
       <img 
         v-if="project.thumbnail || project.image_url || project.image" 
         :src="project.thumbnail || project.image_url || project.image" 
         :alt="t(project.title)" 
         class="w-full h-full object-cover opacity-40 transition-all duration-1000 ease-out group-hover:scale-110 group-hover:opacity-65"
       />
       <div v-else class="w-full h-full bg-gradient-to-br from-zinc-900 to-black opacity-80"></div>
    </div>
    
    <!-- Content Foreground Overlay -->
    <div class="relative z-10 p-8 bg-gradient-to-t from-black/90 via-black/60 to-transparent transition-transform duration-500 group-hover:-translate-y-2">
       <h2 class="text-3xl font-extrabold mb-3 text-white tracking-tight">{{ t(project.title) }}</h2>
       <p class="text-zinc-400 text-[1.05rem] leading-relaxed mb-6 line-clamp-2">{{ t(project.excerpt || project.description) }}</p>
       
       <!-- Tech Stack Hover & Stagger Effect -->
       <div class="flex flex-wrap gap-2.5" v-if="project.tech_stack && project.tech_stack.length">
         <span 
           v-for="(tech, index) in project.tech_stack" 
           :key="tech"
           :style="{ transitionDelay: `${index * 60}ms` }"
           class="bg-white/10 border border-white/20 backdrop-blur-lg px-3.5 py-1.5 rounded-full text-xs font-bold text-zinc-50 opacity-0 translate-y-5 transition-all duration-500 group-hover:opacity-100 group-hover:translate-y-0"
         >
           {{ tech }}
         </span>
       </div>
    </div>
  </NuxtLink>
</template>
