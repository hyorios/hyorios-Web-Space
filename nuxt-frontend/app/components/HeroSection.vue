<script setup lang="ts">
defineProps<{
  locale: 'en' | 'de'
}>()
</script>

<template>
  <header class="text-center mb-28">
    <h1 class="text-5xl md:text-7xl font-black mb-6 tracking-tight leading-tight bg-gradient-to-br from-white to-zinc-400 bg-clip-text text-transparent">
      {{ locale === 'en' ? 'Digital Playground' : 'Digitale Spielwiese' }}
    </h1>
    <p class="text-zinc-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
      {{ locale === 'en' 
        ? 'Engineering intuitive interfaces & scalable backends for a connected world.' 
        : 'Entwicklung intuitiver Interfaces & skalierbarer Backends für eine vernetzte Welt.' }}
    </p>
  </header>
</template>
