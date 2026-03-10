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
];

const container = document.getElementById('quote-container');

// Settings
const MIN_DURATION = 35; // Shortest animation time in seconds (faster)
const MAX_DURATION = 60; // Longest animation time in seconds (slower)
const SPAWN_INTERVAL = 4000; // ms between each new quote

function spawnQuote() {
    // 1. Pick a random quote
    const rawQuote = quotes[Math.floor(Math.random() * quotes.length)];
    
    // 2. Create the element
    const quoteEl = document.createElement('div');
    quoteEl.classList.add('gliding-quote');
    quoteEl.textContent = rawQuote;

    // 3. Randomize vertical position (10% to 90% of screen height)
    const topPos = Math.random() * 80 + 10;
    quoteEl.style.top = `${topPos}vh`;

    // 4. Randomize font size slightly for depth
    const baseSize = 1.2;
    const extraSize = Math.random() * 0.8; // 1.2 to 2.0 rem
    quoteEl.style.fontSize = `${baseSize + extraSize}rem`;

    // 5. Randomize animation duration
    const duration = Math.random() * (MAX_DURATION - MIN_DURATION) + MIN_DURATION;
    quoteEl.style.animationDuration = `${duration}s`;

    // 6. Append to DOM
    container.appendChild(quoteEl);

    // 7. Remove from DOM after animation finishes to prevent memory leaks
    setTimeout(() => {
        if(quoteEl.parentNode) {
            quoteEl.parentNode.removeChild(quoteEl);
        }
    }, duration * 1000);
}

// Start spawning quotes
// Initial burst so screen isn't empty
spawnQuote();
setTimeout(spawnQuote, 1500);
setTimeout(spawnQuote, 3000);

// Continuous spawning
setInterval(spawnQuote, SPAWN_INTERVAL);

// Optional: Dynamic mouse lighting effect for cards
document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
    });
});
