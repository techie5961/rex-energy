/**
 * 🎊 Confetti Celebration System
 * ==============================
 * A lightweight, zero-dependency confetti animation library
 * that works in any JavaScript project.
 * 
 * ─── Features ──────────────────────────────────────────────────────────
 * • Zero dependencies - Pure vanilla JavaScript
 * • Canvas-based rendering for optimal performance
 * • Multiple color palettes (gold, rainbow, pastel, christmas)
 * • Custom colors support
 * • Auto-cleanup - Removes itself when done
 * • Responsive - Adapts to window resize
 * • Reusable - Call as many times as you want
 * • Callback support - Know when animation completes
 * • Manual stop control
 * • Shape variety (rectangles, circles, diamonds)
 * 
 * ─── Installation ────────────────────────────────────────────────────
 * 
 * Browser (script tag):
 *   <script src="confetti.js"></script>
 * 
 * Browser (ES Module):
 *   import createConfetti from './confetti.js';
 * 
 * Node.js / npm:
 *   const createConfetti = require('./confetti.js');
 * 
 * ─── Quick Start ─────────────────────────────────────────────────────
 * 
 * // Basic usage - gold confetti for 4 seconds
 * createConfetti();
 * 
 * // With custom options
 * createConfetti({
 *   duration: 5000,
 *   count: 200,
 *   colors: 'rainbow'
 * });
 * 
 * ─── API Reference ──────────────────────────────────────────────────
 * 
 * createConfetti(options)
 * 
 * ── Options ──
 * 
 * @param {Object} options - Configuration object
 * 
 * @param {number} options.duration - Duration in milliseconds
 *        Default: 4000
 *        Example: 3000 (3 seconds)
 * 
 * @param {number} options.count - Number of confetti pieces
 *        Default: 150
 *        Example: 200 (more dense)
 * 
 * @param {string|Array} options.colors - Color palette or custom colors
 *        Default: 'gold'
 *        Options: 'gold', 'rainbow', 'pastel', 'christmas'
 *        Custom: ['#FF0000', '#00FF00', '#0000FF']
 * 
 * @param {number} options.gravity - Gravity acceleration (fall speed increase per frame)
 *        Default: 0.02
 *        Example: 0.05 (faster fall)
 * 
 * @param {Object} options.fallSpeed - Speed range for falling
 *        Default: { min: 2, max: 5 }
 *        Example: { min: 3, max: 7 } (faster)
 * 
 * @param {HTMLElement} options.container - Container element to render canvas in
 *        Default: document.body
 *        Example: document.getElementById('myDiv')
 * 
 * @param {Function} options.onComplete - Callback when confetti finishes
 *        Default: null
 *        Example: () => console.log('🎊 Celebration complete!')
 * 
 * ── Return Value ──
 * 
 * Returns an object with control methods:
 * {
 *   stop: Function   // Stops the confetti early
 *   isActive: Function // Returns boolean if still active
 *   canvas: HTMLElement // The canvas element
 *   particles: Array // Array of particle objects
 * }
 * 
 * ─── Usage Examples ──────────────────────────────────────────────────
 * 
 * ── Example 1: Basic gold confetti ──
 * createConfetti();
 * 
 * ── Example 2: Rainbow confetti with more pieces ──
 * createConfetti({
 *   duration: 5000,
 *   count: 200,
 *   colors: 'rainbow'
 * });
 * 
 * ── Example 3: Custom colors ──
 * createConfetti({
 *   colors: ['#FF6B6B', '#FFD93D', '#6BCB77', '#4D96FF'],
 *   count: 100,
 *   duration: 3000
 * });
 * 
 * ── Example 4: Fast falling confetti ──
 * createConfetti({
 *   gravity: 0.05,
 *   fallSpeed: { min: 4, max: 8 },
 *   duration: 2500
 * });
 * 
 * ── Example 5: With completion callback ──
 * createConfetti({
 *   duration: 3000,
 *   onComplete: () => {
 *     console.log('🎊 Confetti done!');
 *     // Trigger next action
 *   }
 * });
 * 
 * ── Example 6: Manual stop ──
 * const confetti = createConfetti({ duration: 10000 });
 * 
 * // Stop it early after 2 seconds
 * setTimeout(() => {
 *   confetti.stop();
 *   console.log('🛑 Stopped early!');
 * }, 2000);
 * 
 * ── Example 7: Multiple waves ──
 * // Wave 1
 * createConfetti({ colors: 'gold', duration: 2000 });
 * 
 * // Wave 2 after delay
 * setTimeout(() => {
 *   createConfetti({ colors: 'rainbow', count: 100 });
 * }, 1000);
 * 
 * ── Example 8: Container-specific ──
 * const container = document.getElementById('celebration-area');
 * createConfetti({
 *   container: container,
 *   colors: 'pastel',
 *   count: 120
 * });
 * 
 * ── Example 9: Button click trigger ──
 * document.getElementById('celebrateBtn').addEventListener('click', () => {
 *   createConfetti({
 *     duration: 4000,
 *     colors: 'rainbow',
 *     count: 200
 *   });
 * });
 * 
 * ── Example 10: Form submission celebration ──
 * document.getElementById('myForm').addEventListener('submit', (e) => {
 *   e.preventDefault();
 *   createConfetti({
 *     duration: 3000,
 *     colors: ['#FFD700', '#FF6B6B', '#4ECDC4'],
 *     onComplete: () => {
 *       alert('🎉 Form submitted successfully!');
 *     }
 *   });
 * });
 * 
 * ─── Color Palettes ──────────────────────────────────────────────────
 * 
 * 'gold'     - Warm gold and orange tones (default)
 * 'rainbow'  - Full spectrum of bright colors
 * 'pastel'   - Soft, gentle colors
 * 'christmas'- Red, green, gold, white
 * 
 * ─── Performance Tips ───────────────────────────────────────────────
 * 
 * 1. Keep count under 300 for smooth animations
 * 2. Shorter durations (2-5 seconds) work best
 * 3. Use container to limit rendering area if needed
 * 4. Stop early with .stop() if no longer needed
 * 
 * ─── Browser Support ─────────────────────────────────────────────────
 * 
 * • Chrome 60+
 * • Firefox 55+
 * • Safari 12+
 * • Edge 79+
 * • Opera 47+
 * 
 * ─── License ─────────────────────────────────────────────────────────
 * 
 * MIT License - Free to use in personal and commercial projects
 * 
 * ─── Author ──────────────────────────────────────────────────────────
 * 
 * Created with ❤️ for celebration purposes
 * 
 * =========================================================================
 */

function createConfetti(options = {}) {
  // ── Defaults ──
  const defaults = {
    duration: 4000,
    count: 150,
    colors: 'gold',
    gravity: 0.02,
    fallSpeed: { min: 2, max: 5 },
    container: document.body,
    onComplete: null
  };

  const config = { ...defaults, ...options };

  // ── Color palettes ──
  const colorPalettes = {
    gold: [
      '#FFD700', '#FFC107', '#FFB300', '#FFA000', '#FF8F00',
      '#F9A825', '#F57F17', '#FBC02D', '#FFF176', '#FFEE58'
    ],
    rainbow: [
      '#FF6B6B', '#FF9F43', '#FECA57', '#48DBFB', '#0ABDE3',
      '#10AC84', '#EE5A24', '#5F27CD', '#FF6B81', '#F368E0'
    ],
    pastel: [
      '#FFB3BA', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#BAE1FF',
      '#E8BAFF', '#FFB3D9', '#B3FFE5', '#FFE5B3', '#D4B3FF'
    ],
    christmas: [
      '#FF0000', '#00FF00', '#FF0000', '#00FF00', '#FFFFFF',
      '#FF0000', '#00FF00', '#FFD700', '#FF0000', '#00FF00'
    ]
  };

  // Get colors array
  let colorArray;
  if (Array.isArray(config.colors)) {
    colorArray = config.colors;
  } else if (colorPalettes[config.colors]) {
    colorArray = colorPalettes[config.colors];
  } else {
    colorArray = colorPalettes.gold;
  }

  // ── Setup Canvas ──
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');
  
  canvas.style.position = 'fixed';
  canvas.style.top = '0';
  canvas.style.left = '0';
  canvas.style.width = '100%';
  canvas.style.height = '100%';
  canvas.style.pointerEvents = 'none';
  canvas.style.zIndex = '9999';
  
  config.container.appendChild(canvas);

  // ── Resize handler ──
  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  // ── Confetti Particle ──
  class ConfettiPiece {
    constructor() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height - canvas.height;
      this.size = Math.random() * 8 + 4;
      this.width = this.size;
      this.height = this.size * (Math.random() * 0.6 + 0.4);
      this.color = colorArray[Math.floor(Math.random() * colorArray.length)];
      this.vy = Math.random() * (config.fallSpeed.max - config.fallSpeed.min) + config.fallSpeed.min;
      this.vx = (Math.random() - 0.5) * 2;
      this.rotation = Math.random() * 360;
      this.rotationSpeed = (Math.random() - 0.5) * 10;
      this.opacity = 1;
      this.deceleration = 0.99;
    }

    update() {
      this.vy += config.gravity;
      this.vx *= this.deceleration;
      this.y += this.vy;
      this.x += this.vx;
      this.rotation += this.rotationSpeed;

      if (this.y > canvas.height * 0.8) {
        this.opacity = Math.max(0, this.opacity - 0.02);
      }

      if (this.y > canvas.height + 50) {
        this.y = -50;
        this.x = Math.random() * canvas.width;
        this.vy = Math.random() * (config.fallSpeed.max - config.fallSpeed.min) + config.fallSpeed.min;
        this.vx = (Math.random() - 0.5) * 2;
        this.opacity = 1;
      }

      if (this.x < -20) this.x = canvas.width + 20;
      if (this.x > canvas.width + 20) this.x = -20;
    }

    draw() {
      ctx.save();
      ctx.translate(this.x, this.y);
      ctx.rotate((this.rotation * Math.PI) / 180);
      ctx.globalAlpha = this.opacity;
      ctx.fillStyle = this.color;
      
      if (Math.random() > 0.7) {
        ctx.beginPath();
        ctx.arc(0, 0, this.size / 2, 0, Math.PI * 2);
        ctx.fill();
      } else if (Math.random() > 0.5) {
        ctx.translate(0, 0);
        ctx.rotate(Math.PI / 4);
        ctx.fillRect(-this.width/2, -this.height/2, this.width, this.height);
      } else {
        ctx.fillRect(-this.width/2, -this.height/2, this.width, this.height);
      }
      
      ctx.restore();
    }
  }

  // ── Create particles ──
  const particles = [];
  for (let i = 0; i < config.count; i++) {
    particles.push(new ConfettiPiece());
  }

  // ── Animation loop ──
  let animationId = null;
  let startTime = Date.now();
  let isActive = true;

  function animate() {
    const elapsed = Date.now() - startTime;
    
    if (elapsed >= config.duration) {
      particles.forEach(p => p.opacity *= 0.95);
      
      const allInvisible = particles.every(p => p.opacity < 0.01);
      if (allInvisible) {
        stopConfetti();
        return;
      }
    }

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
      p.update();
      p.draw();
    });

    animationId = requestAnimationFrame(animate);
  }

  // ── Stop confetti ──
  function stopConfetti() {
    isActive = false;
    if (animationId) {
      cancelAnimationFrame(animationId);
      animationId = null;
    }
    
    if (canvas.parentNode) {
      canvas.parentNode.removeChild(canvas);
    }
    
    window.removeEventListener('resize', resizeCanvas);
    
    if (config.onComplete && typeof config.onComplete === 'function') {
      config.onComplete();
    }
  }

  // ── Start animation ──
  animate();

  // ── Return control functions ──
  return {
    stop: stopConfetti,
    isActive: () => isActive,
    canvas: canvas,
    particles: particles
  };
}

// ── Export for different environments ──
if (typeof module !== 'undefined' && module.exports) {
  module.exports = createConfetti;
}

if (typeof window !== 'undefined') {
  window.createConfetti = createConfetti;
}