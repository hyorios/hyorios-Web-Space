<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useBackgroundAnimation } from '../composables/useBackgroundAnimation'

const bgContainer = ref<HTMLElement | null>(null)

if (typeof window !== 'undefined') {
  useBackgroundAnimation(bgContainer)
}
</script>

<template>
  <div ref="bgContainer" class="fixed inset-0 pointer-events-none -z-10 overflow-hidden"></div>
</template>
