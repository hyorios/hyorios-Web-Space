<script setup lang="ts">
defineProps<{
  locale: 'en' | 'de'
}>()
const emit = defineEmits<{
  (e: 'toggleLocale'): void
}>()
</script>

<template>
  <nav class="glass-nav">
    <div class="nav-brand">HYORIOS</div>
    <div class="nav-links">
      <NuxtLink to="/" class="nav-link">Home</NuxtLink>
      <NuxtLink to="#projects" class="nav-link">Projects</NuxtLink>
      <NuxtLink to="#about" class="nav-link">About</NuxtLink>
      <button @click="emit('toggleLocale')" class="lang-switch">
        {{ locale === 'en' ? 'EN' : 'DE' }}
      </button>
    </div>
  </nav>
</template>

<style scoped>
.glass-nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 50;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 3rem;
  background: rgba(10, 10, 10, 0.45);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  transition: all 0.3s ease;
}

.nav-brand {
  font-size: 1.5rem;
  font-weight: 800;
  letter-spacing: 0.15em;
  background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.nav-links {
  display: flex;
  gap: 2.5rem;
  align-items: center;
}

.nav-link {
  color: #a1a1aa;
  text-decoration: none;
  font-size: 0.95rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #fafafa;
}

.lang-switch {
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(8px);
  color: #fafafa;
  padding: 0.4rem 0.9rem;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.85rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  transition: all 0.3s ease;
}

.lang-switch:hover {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
  transform: translateY(-1px);
}
</style>
