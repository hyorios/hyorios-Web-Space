<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const projects = ref<{ id: number; title: string; description: string; status: string }[]>([])
const connectionStatus = ref('Pinging backend...')
const connectionColor = ref('var(--text-secondary)')

const fetchProjects = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/projects')
    if (!response.ok) throw new Error('Network response was not ok')
    projects.value = await response.json()
    connectionStatus.value = '✅ Connected to the Matrix'
    connectionColor.value = '#22c55e'
  } catch (error) {
    console.error('Failed to fetch projects', error)
    connectionStatus.value = '❌ Backend connection failed'
    connectionColor.value = '#dc3545'
  }
}

// Ensure the fetch happens client-side directly
onMounted(() => {
  fetchProjects()
})

// Define quotes directly here
const quotes = [
  "“The unexamined life is not worth living.” – Socrates",
  "“To be, or not to be, that is the question.” – William Shakespeare",
  "“I think, therefore I am.” – René Descartes",
  "“Knowledge is power.” – Sir Francis Bacon",
  "“The only true wisdom is in knowing you know nothing.” – Socrates",
  "“Patience is bitter, but its fruit is sweet.” – Aristotle",
  "“He who has a why to live for can bear almost any how.” – Friedrich Nietzsche",
  "“The mind is everything. What you think you become.” – Buddha",
  "“You have power over your mind - not outside events. Realize this, and you will find strength.” – Marcus Aurelius",
  "“If you know the enemy and know yourself, you need not fear the result of a hundred battles.” – Sun Tzu",
  "“The impediment to action advances action. What stands in the way becomes the way.” – Marcus Aurelius",
  "“No man ever steps in the same river twice.” – Heraclitus",
  "“Man is the measure of all things.” – Protagoras",
  "“In the midst of chaos, there is also opportunity.” – Sun Tzu",
  "“It is not because things are difficult that we do not dare; it is because we do not dare that they are difficult.” – Seneca",
  "“We suffer more often in imagination than in reality.” – Seneca",
  "“Waste no more time arguing about what a good man should be. Be one.” – Marcus Aurelius",
  "“All warfare is based on deception.” – Sun Tzu",
  "“Opportunities multiply as they are seized.” – Sun Tzu",
  "“First learn the meaning of what you say, and then speak.” – Epictetus",
  "“Fate leads the willing, and drags along the reluctant.” – Seneca",
  "“He who fears death will never do anything worthy of a man who is alive.” – Seneca",
  "“Even from the depths of hell, Odin's raven sees the truth.” – Norse Proverb",
  "“The brave man is not he who does not feel afraid, but he who conquers that fear.” – Nelson Mandela",
  "“A journey of a thousand miles begins with a single step.” – Lao Tzu"
]

const MIN_DURATION = 35
const MAX_DURATION = 60
const SPAWN_INTERVAL = 4000

// Reactive array holding currently active quotes on screen
const activeQuotes = ref<{ id: number; text: string; top: number; size: number; duration: number }[]>([])
let quoteIdCounter = 0
let spawnIntervalId: ReturnType<typeof setInterval>

const spawnQuote = () => {
  const rawQuote = quotes[Math.floor(Math.random() * quotes.length)]
  const topPos = Math.random() * 80 + 10 // 10vh to 90vh
  const baseSize = 1.2
  const extraSize = Math.random() * 0.8
  const duration = Math.random() * (MAX_DURATION - MIN_DURATION) + MIN_DURATION
  const id = quoteIdCounter++

  activeQuotes.value.push({
    id,
    text: rawQuote,
    top: topPos,
    size: baseSize + extraSize,
    duration
  })

  // Remove quote from state once animation completes
  setTimeout(() => {
    activeQuotes.value = activeQuotes.value.filter(q => q.id !== id)
  }, duration * 1000)
}

const handleMouseMove = (e: MouseEvent, cardElement: HTMLElement) => {
  const rect = cardElement.getBoundingClientRect()
  const x = e.clientX - rect.left
  const y = e.clientY - rect.top
  cardElement.style.setProperty('--mouse-x', `${x}px`)
  cardElement.style.setProperty('--mouse-y', `${y}px`)
}

onMounted(() => {
  // Initial quotes
  spawnQuote()
  setTimeout(spawnQuote, 1500)
  setTimeout(spawnQuote, 3000)
  // Continuous spawn
  spawnIntervalId = setInterval(spawnQuote, SPAWN_INTERVAL)
})

onUnmounted(() => {
  clearInterval(spawnIntervalId)
})
</script>

<template>
  <div class="dashboard-root">
    <!-- Decorative background elements -->
    <div class="orb orb-1" />
    <div class="orb orb-2" />

    <!-- Quotes container -->
    <div id="quote-container">
      <div 
        v-for="quote in activeQuotes" 
        :key="quote.id" 
        class="gliding-quote"
        :style="{ top: `${quote.top}vh`, fontSize: `${quote.size}rem`, animationDuration: `${quote.duration}s` }"
      >
        {{ quote.text }}
      </div>
    </div>

    <!-- Main Content -->
    <main>
      <header>
        <h1>My Space</h1>
        <p>A canvas for creativity, projects, and exploration.</p>
      </header>

      <section class="dashboard-grid">
        <a 
          v-for="project in projects" 
          :key="project.id" 
          href="#" 
          class="project-card"
          @mousemove="(e) => handleMouseMove(e, e.currentTarget as HTMLElement)"
        >
          <div class="card-title">{{ project.title }}</div>
          <div class="card-desc">{{ project.description }}</div>
          <div class="status">
            <span :class="['status-dot', project.status === 'active' ? 'active' : 'planned']" />
            {{ project.status === 'active' ? 'Active' : 'Planned' }}
          </div>
        </a>

        <!-- System Status Box -->
        <a 
          href="#" 
          class="project-card" 
          @click.prevent="fetchProjects"
          @mousemove="(e) => handleMouseMove(e, e.currentTarget as HTMLElement)"
        >
          <div class="card-title">System Status</div>
          <div class="card-desc">{{ connectionStatus }}</div>
          <div class="status" style="cursor: pointer;">
            <span class="status-dot" :style="{ backgroundColor: connectionColor, boxShadow: `0 0 8px ${connectionColor}` }" />
            Ping Backend
          </div>
        </a>
      </section>
    </main>
  </div>
</template>

<style>
/* Global CSS injected into the component, but could also be generic */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');

:root {
  --bg-dark: #0f172a;
  --text-primary: #f8fafc;
  --text-secondary: #94a3b8;
  --acc-primary: #3b82f6;
  --acc-hover: #60a5fa;

  --glass-bg: rgba(255, 255, 255, 0.05);
  --glass-border: rgba(255, 255, 255, 0.1);
  --glass-blur: 12px;
}

html, body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
  background-color: var(--bg-dark);
  color: var(--text-primary);
  min-height: 100vh;
  overflow-x: hidden;
}

/* Dashboard Root */
.dashboard-root {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
  background: radial-gradient(circle at top right, #1e293b, #0f172a);
}

/* Quote Layer */
#quote-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

.gliding-quote {
  position: absolute;
  white-space: nowrap;
  opacity: 0.15;
  font-style: italic;
  color: #cbd5e1;
  font-weight: 300;
  animation-name: glideLeft;
  animation-timing-function: linear;
  animation-fill-mode: forwards;
}

@keyframes glideLeft {
  from { transform: translateX(110vw); }
  to { transform: translateX(-110vw); }
}

/* Main Layout */
main {
  z-index: 10;
  width: 100%;
  max-width: 1200px;
  padding: 4rem 2rem;
  display: flex;
  flex-direction: column;
  gap: 3rem;
}

header {
  text-align: left;
}

header h1 {
  font-size: 3.5rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  margin-bottom: 0.5rem;
  background: linear-gradient(135deg, #e2e8f0 0%, #94a3b8 100%);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

header p {
  font-size: 1.25rem;
  color: var(--text-secondary);
}

.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

/* Glassmorphism Cards */
.project-card {
  background: var(--glass-bg);
  backdrop-filter: blur(var(--glass-blur));
  -webkit-backdrop-filter: blur(var(--glass-blur));
  border: 1px solid var(--glass-border);
  border-radius: 20px;
  padding: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  position: relative;
  overflow: hidden;
  text-decoration: none;
  color: inherit;
  --mouse-x: 50%;
  --mouse-y: 50%;
}

.project-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
  border-color: rgba(255, 255, 255, 0.2);
}

.project-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(255, 255, 255, 0.06), transparent 40%);
  opacity: 0;
  transition: opacity 0.5s;
  z-index: -1;
}

.project-card:hover::before {
  opacity: 1;
}

.card-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--text-primary);
}

.card-desc {
  color: var(--text-secondary);
  font-size: 1rem;
  line-height: 1.5;
  flex-grow: 1;
}

/* Card Status */
.status {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.875rem;
  color: var(--text-secondary);
}

.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
}
.status-dot.active { background-color: #22c55e; box-shadow: 0 0 8px #22c55e; }
.status-dot.planned { background-color: #f59e0b; box-shadow: 0 0 8px #f59e0b; }

/* Orbs */
.orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  z-index: 1;
  pointer-events: none;
}
.orb-1 {
  top: -100px;
  right: 10%;
  width: 300px;
  height: 300px;
  background: rgba(59, 130, 246, 0.15);
}
.orb-2 {
  bottom: -100px;
  left: 10%;
  width: 400px;
  height: 400px;
  background: rgba(139, 92, 246, 0.15);
}
</style>
