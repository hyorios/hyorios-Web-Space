<script setup lang="ts">
defineProps<{
  locale: 'en' | 'de'
}>()
</script>

<template>
  <header class="hero">
    <h1>{{ locale === 'en' ? 'Digital Playground' : 'Digitale Spielwiese' }}</h1>
    <p>{{ locale === 'en' 
        ? 'Engineering intuitive interfaces & scalable backends for a connected world.' 
        : 'Entwicklung intuitiver Interfaces & skalierbarer Backends für eine vernetzte Welt.' }}</p>
  </header>
</template>

<style scoped>
.hero {
  text-align: center;
  margin-bottom: 7rem;
}

.hero h1 {
  font-size: clamp(3rem, 6vw, 5rem);
  font-weight: 900;
  margin-bottom: 1.5rem;
  letter-spacing: -0.04em;
  line-height: 1.1;
  background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero p {
  color: #a1a1aa;
  font-size: clamp(1.1rem, 2vw, 1.35rem);
  max-width: 650px;
  margin: 0 auto;
  line-height: 1.7;
}
</style>
