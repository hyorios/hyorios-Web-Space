<script setup lang="ts">
defineProps<{
  locale: 'en' | 'de'
}>()
const emit = defineEmits<{
  (e: 'toggleLocale'): void
}>()
</script>

<template>
  <nav class="fixed top-0 left-0 right-0 z-50 flex justify-between items-center py-5 px-12 bg-black/45 backdrop-blur-md border-b border-white/10 transition-all duration-300">
    <div class="text-2xl font-extrabold tracking-widest bg-gradient-to-br from-white to-zinc-400 bg-clip-text text-transparent">HYORIOS</div>
    <div class="flex gap-10 items-center">
      <NuxtLink to="/" class="text-zinc-400 no-underline text-[0.95rem] font-semibold uppercase tracking-wider transition-colors duration-300 hover:text-zinc-50">Home</NuxtLink>
      <NuxtLink to="#projects" class="text-zinc-400 no-underline text-[0.95rem] font-semibold uppercase tracking-wider transition-colors duration-300 hover:text-zinc-50">Projects</NuxtLink>
      <NuxtLink to="#about" class="text-zinc-400 no-underline text-[0.95rem] font-semibold uppercase tracking-wider transition-colors duration-300 hover:text-zinc-50">About</NuxtLink>
      <button @click="emit('toggleLocale')" class="bg-white/5 border border-white/10 backdrop-blur-sm text-zinc-50 py-1.5 px-3.5 rounded-md cursor-pointer text-[0.85rem] font-bold tracking-wider transition-all duration-300 hover:bg-white/15 hover:border-white/30 hover:-translate-y-[1px]">
        {{ locale === 'en' ? 'EN' : 'DE' }}
      </button>
    </div>
  </nav>
</template>
