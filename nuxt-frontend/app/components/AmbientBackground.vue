<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useBackgroundAnimation } from '../composables/useBackgroundAnimation'

const bgContainer = ref<HTMLElement | null>(null)

if (typeof window !== 'undefined') {
  useBackgroundAnimation(bgContainer)
}
</script>

<template>
  <div ref="bgContainer" class="ambient-system"></div>
</template>

<style scoped>
/* Ambient Background Elements */
.ambient-system {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

:deep(.ambient-quote) {
  position: absolute;
  color: rgba(255, 255, 255, 0.4);
  font-style: italic;
  font-size: clamp(1rem, 2vw, 1.6rem);
  font-family: 'Georgia', serif;
  white-space: nowrap;
  letter-spacing: 0.02em;
}

:deep(.ambient-image) {
  position: absolute;
  border-radius: 16px;
  width: 300px;
  height: auto;
  object-fit: contain;
  filter: grayscale(85%) opacity(0.6);
  box-shadow: 0 15px 35px rgba(0,0,0,0.5);
}
</style>
