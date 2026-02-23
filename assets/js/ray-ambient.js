/**
 * Ray Butler Ambient Particle Animation
 * Subtle floating particles behind portrait in hero section
 *
 * @package BFLUXCO
 */

(function() {
    'use strict';

    // Respect reduced motion preference
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    function initRayAmbient() {
        const canvas = document.getElementById('ray-ambient');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationId = null;
        let isVisible = true;

        // Configuration
        const config = {
            particleCount: 40,
            colors: [
                'rgba(26, 132, 123, 0.4)',   // Teal primary
                'rgba(26, 132, 123, 0.2)',   // Teal light
                'rgba(20, 184, 166, 0.3)',   // Teal variant
            ],
            minSize: 2,
            maxSize: 6,
            minSpeed: 0.1,
            maxSpeed: 0.4
        };

        // Resize canvas to match container
        function resize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;
            canvas.width = rect.width * dpr;
            canvas.height = rect.height * dpr;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
            ctx.scale(dpr, dpr);
        }

        // Create particle
        function createParticle() {
            const rect = canvas.parentElement.getBoundingClientRect();
            return {
                x: Math.random() * rect.width,
                y: Math.random() * rect.height,
                size: config.minSize + Math.random() * (config.maxSize - config.minSize),
                speedX: (Math.random() - 0.5) * config.maxSpeed,
                speedY: (Math.random() - 0.5) * config.maxSpeed,
                color: config.colors[Math.floor(Math.random() * config.colors.length)],
                opacity: 0.3 + Math.random() * 0.5,
                pulse: Math.random() * Math.PI * 2,
                pulseSpeed: 0.01 + Math.random() * 0.02
            };
        }

        // Initialize particles
        function createParticles() {
            particles = [];
            for (let i = 0; i < config.particleCount; i++) {
                particles.push(createParticle());
            }
        }

        // Animation loop
        function animate() {
            if (!isVisible) {
                animationId = requestAnimationFrame(animate);
                return;
            }

            const rect = canvas.parentElement.getBoundingClientRect();
            ctx.clearRect(0, 0, rect.width, rect.height);

            particles.forEach(p => {
                // Update position
                p.x += p.speedX;
                p.y += p.speedY;

                // Wrap around edges
                if (p.x < -p.size) p.x = rect.width + p.size;
                if (p.x > rect.width + p.size) p.x = -p.size;
                if (p.y < -p.size) p.y = rect.height + p.size;
                if (p.y > rect.height + p.size) p.y = -p.size;

                // Pulse opacity
                p.pulse += p.pulseSpeed;
                const pulseOpacity = p.opacity * (0.7 + 0.3 * Math.sin(p.pulse));

                // Draw particle
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                ctx.fillStyle = p.color.replace(/[\d.]+\)$/, pulseOpacity + ')');
                ctx.fill();

                // Optional: Add subtle glow
                if (p.size > 4) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.size * 2, 0, Math.PI * 2);
                    ctx.fillStyle = p.color.replace(/[\d.]+\)$/, (pulseOpacity * 0.2) + ')');
                    ctx.fill();
                }
            });

            animationId = requestAnimationFrame(animate);
        }

        // Visibility change handler (pause when tab hidden)
        function handleVisibilityChange() {
            isVisible = !document.hidden;
        }

        // Initialize
        resize();
        createParticles();
        animate();

        // Event listeners
        window.addEventListener('resize', function() {
            resize();
            createParticles();
        });

        document.addEventListener('visibilitychange', handleVisibilityChange);

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (animationId) {
                cancelAnimationFrame(animationId);
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRayAmbient);
    } else {
        initRayAmbient();
    }

})();
