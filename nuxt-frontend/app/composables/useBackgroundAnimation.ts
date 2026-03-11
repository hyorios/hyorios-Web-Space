import { onMounted, onUnmounted, type Ref } from 'vue'
import gsap from 'gsap'

const quotes = [
  "“The unexamined life is not worth living.” – Socrates",
  "“To be, or not to be, that is the question.” – William Shakespeare",
  "“I think, therefore I am.” – René Descartes",
  "“Knowledge is power.” – Sir Francis Bacon",
  "“Patience is bitter, but its fruit is sweet.” – Aristotle",
  "“Die Grenzen meiner Sprache bedeuten die Grenzen meiner Welt.” – Ludwig Wittgenstein",
  "“Der Weg ist das Ziel.” – Konfuzius"
]

const unsplashImages = [
  "https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=800&h=800&fit=crop&q=80",
  "https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=800&fit=crop&q=80",
  "https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&h=800&fit=crop&q=80",
  "https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=800&h=800&fit=crop&q=80",
  "https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=800&h=800&fit=crop&q=80",
  "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&h=800&fit=crop&q=80"
]

export function useBackgroundAnimation(containerRef: Ref<HTMLElement | null>) {
  let ctx: gsap.Context | undefined
  let spawnInterval: any

  const spawnElement = () => {
    if (!containerRef.value) return
    
    // Choose randomly between an image and a quote
    const isImage = Math.random() > 0.65
    const el = document.createElement(isImage ? 'img' : 'div')
    
    if (isImage) {
      (el as HTMLImageElement).src = unsplashImages[Math.floor(Math.random() * unsplashImages.length)]
      el.className = 'ambient-image'
    } else {
      el.innerText = quotes[Math.floor(Math.random() * quotes.length)]
      el.className = 'ambient-quote'
    }

    containerRef.value.appendChild(el)

    // Positional setup outside the visible boundaries
    const side = Math.floor(Math.random() * 4) // 0: Top, 1: Right, 2: Bottom, 3: Left
    const w = window.innerWidth
    const h = window.innerHeight
    const margin = 400

    let startX = 0, startY = 0, endX = 0, endY = 0

    if (side === 0) {
      startX = Math.random() * w
      startY = -margin
      endX = startX + (Math.random() * 800 - 400)
      endY = h + margin
    } else if (side === 1) {
      startX = w + margin
      startY = Math.random() * h
      endX = -margin
      endY = startY + (Math.random() * 800 - 400)
    } else if (side === 2) {
      startX = Math.random() * w
      startY = h + margin
      endX = startX + (Math.random() * 800 - 400)
      endY = -margin
    } else {
      startX = -margin
      startY = Math.random() * h
      endX = w + margin
      endY = startY + (Math.random() * 800 - 400)
    }

    // Individual duration and physics
    const duration = Math.random() * 30 + 30 
    const targetScale = isImage ? (Math.random() * 0.5 + 0.8) : (Math.random() * 0.4 + 0.8)
    const rotationStart = Math.random() * 30 - 15
    const rotationEnd = rotationStart + (Math.random() * 60 - 30)

    gsap.set(el, { 
      x: startX, 
      y: startY, 
      opacity: 0, 
      scale: targetScale * 0.6,
      rotation: rotationStart
    })

    const tl = gsap.timeline({
      onComplete: () => {
        if (el && el.parentNode) {
          el.parentNode.removeChild(el)
        }
      }
    })

    // Fade in, move across and rotate, fade out
    tl.to(el, { 
        opacity: isImage ? (Math.random() * 0.08 + 0.04) : (Math.random() * 0.15 + 0.1), 
        scale: targetScale,
        duration: 8, 
        ease: 'power2.out' 
      })
      .to(el, { 
        x: endX, 
        y: endY, 
        rotation: rotationEnd,
        duration: duration, 
        ease: 'none' 
      }, 0)
      .to(el, { 
        opacity: 0, 
        duration: 8, 
        ease: 'power2.in' 
      }, duration - 8)
  }

  onMounted(() => {
    ctx = gsap.context(() => {
      // Warmup phase (spawn several immediately)
      for (let i = 0; i < 7; i++) {
        setTimeout(spawnElement, i * 700)
      }
      // Continuous loop
      spawnInterval = setInterval(spawnElement, 4500)
    }, containerRef.value || undefined)
  })

  onUnmounted(() => {
    if (ctx) ctx.revert()
    if (spawnInterval) clearInterval(spawnInterval)
  })
}
