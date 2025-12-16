/**
 * BFLUXCO Particle Logo Animation
 *
 * Creates a Three.js particle animation that forms the BFLUX logo shape.
 * Particles gently swirl and react to mouse movement.
 *
 * @package BFLUXCO
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize hero particle logo
        initParticleLogo('particle-logo-canvas');

        // Initialize featured product particle logo (with delay for layout)
        setTimeout(function() {
            initParticleLogo('featured-particle-canvas');
        }, 200);
    });

    function initParticleLogo(canvasId) {
        console.log('Particle Logo: Initializing...', canvasId);
        const canvas = document.getElementById(canvasId);

        if (!canvas) {
            console.log('Particle Logo: Canvas not found -', canvasId);
            return;
        }

        if (typeof THREE === 'undefined') {
            console.log('Particle Logo: THREE.js not loaded');
            return;
        }

        console.log('Particle Logo: Canvas and THREE.js found, starting...');

        // Get initial container dimensions FIRST
        // For overlay canvases, use the grandparent (the actual sized container)
        let container = canvas.parentElement;
        if (!container) {
            console.log('Particle Logo: Container not found');
            return;
        }

        // If parent is an overlay (absolutely positioned), use grandparent for dimensions
        if (container.classList.contains('particle-logo-overlay') && container.parentElement) {
            container = container.parentElement;
        }

        // Set canvas size to container size
        const initialWidth = container.clientWidth || container.offsetWidth || 800;
        const initialHeight = container.clientHeight || container.offsetHeight || 600;
        canvas.width = initialWidth;
        canvas.height = initialHeight;

        console.log('Particle Logo: Canvas size set to', initialWidth, 'x', initialHeight);

        // Scene setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, initialWidth / initialHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            antialias: true,
            alpha: true
        });

        renderer.setSize(initialWidth, initialHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setClearColor(0x000000, 0);

        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();
        const plane = new THREE.Plane(new THREE.Vector3(0, 0, 1), 0);

        // Utility functions
        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        // SDF for rounded rectangle
        function sdRoundedBox(px, py, bx, by, r) {
            const qx = Math.abs(px) - bx + r;
            const qy = Math.abs(py) - by + r;
            return Math.min(Math.max(qx, qy), 0) + Math.sqrt(Math.max(qx, 0) ** 2 + Math.max(qy, 0) ** 2) - r;
        }

        // SDF for rectangle (axis-aligned)
        function sdBox(px, py, bx, by) {
            const dx = Math.abs(px) - bx;
            const dy = Math.abs(py) - by;
            return Math.sqrt(Math.max(dx, 0) ** 2 + Math.max(dy, 0) ** 2) + Math.min(Math.max(dx, dy), 0);
        }

        // Distance to BFLUX logo shape
        // The logo is a folder-like shape with a notch and a document cutout
        function distToLogo(px, py) {
            // Normalize to logo space (centered, approximately -1 to 1)
            const scale = 0.8;
            const x = px / scale;
            const y = py / scale;

            // Main outer folder shape (large rounded rectangle)
            const outerWidth = 0.9;
            const outerHeight = 0.85;
            const cornerRadius = 0.12;
            let outer = sdRoundedBox(x, y, outerWidth, outerHeight, cornerRadius);

            // Top-right notch cutout
            // This creates the folder tab effect
            const notchX = x - 0.35;
            const notchY = y - 0.55;
            const notchWidth = 0.55;
            const notchHeight = 0.35;
            const notch = sdRoundedBox(notchX, notchY, notchWidth, notchHeight, 0.08);

            // Subtract notch from outer shape
            outer = Math.max(outer, -notch);

            // Inner document cutout (white area in logo)
            // Position slightly left and down from center
            const docX = x + 0.15;
            const docY = y + 0.1;
            const docWidth = 0.28;
            const docHeight = 0.35;
            const doc = sdRoundedBox(docX, docY, docWidth, docHeight, 0.06);

            // Document tab (small notch in document)
            const tabX = docX - 0.12;
            const tabY = docY - 0.22;
            const tab = sdRoundedBox(tabX, tabY, 0.12, 0.12, 0.03);

            // Combined document shape
            const docShape = Math.min(doc, tab);

            // Final shape: outer minus document cutout
            // We want particles INSIDE the teal area (between outer and inner)
            const inside = outer;
            const notInDoc = -docShape;

            // Return: negative means inside the teal logo area
            return Math.max(inside, notInDoc);
        }

        // Generate particles
        const numParticles = 10000;
        const thickness = 0.12;
        const positions = new Float32Array(numParticles * 3);
        const colors = new Float32Array(numParticles * 3);

        let i = 0;
        const maxAttempts = 1000000;
        let attempts = 0;

        while (i < numParticles && attempts < maxAttempts) {
            attempts++;
            const x = Math.random() * 2.4 - 1.2;
            const y = Math.random() * 2.4 - 1.2;
            const z = Math.random() * thickness - thickness / 2;

            if (distToLogo(x, y) <= 0) {
                positions[i * 3] = x;
                positions[i * 3 + 1] = y;
                positions[i * 3 + 2] = z;

                // Teal color matching logo (#1a7a7a approximately)
                colors[i * 3] = 0.1 + Math.random() * 0.1;      // R
                colors[i * 3 + 1] = 0.45 + Math.random() * 0.1;  // G
                colors[i * 3 + 2] = 0.5 + Math.random() * 0.1;   // B
                i++;
            }
        }

        const particleCount = i;
        const originalPositions = positions.slice();
        const phases = new Float32Array(particleCount);
        const velocities = new Float32Array(particleCount * 3);

        for (let j = 0; j < particleCount; j++) {
            phases[j] = Math.random() * Math.PI * 2;
        }

        // Create geometry and material
        const geometry = new THREE.BufferGeometry();
        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        const material = new THREE.PointsMaterial({
            size: 0.008,
            sizeAttenuation: true,
            vertexColors: true,
            transparent: true,
            opacity: 0.9
        });

        const points = new THREE.Points(geometry, material);
        scene.add(points);

        camera.position.set(0, 0, 2.2);

        // State
        let intersectionPoint = null;

        // Mouse handlers
        function handleMouseMove(event) {
            const rect = canvas.getBoundingClientRect();
            mouse.x = ((event.clientX - rect.left) / canvas.clientWidth) * 2 - 1;
            mouse.y = -((event.clientY - rect.top) / canvas.clientHeight) * 2 + 1;

            raycaster.setFromCamera(mouse, camera);
            const intersect = new THREE.Vector3();
            if (raycaster.ray.intersectPlane(plane, intersect)) {
                intersectionPoint = intersect;
            }
        }

        function handleMouseLeave() {
            intersectionPoint = null;
        }

        canvas.addEventListener('mousemove', handleMouseMove);
        canvas.addEventListener('mouseleave', handleMouseLeave);

        // Animation
        let animationId;
        let time = 0;

        function animate(timestamp) {
            time = timestamp * 0.001;

            const positionAttribute = geometry.getAttribute('position');
            const colorAttribute = geometry.getAttribute('color');

            const radiusSwirl = 0.006;
            const angularSpeed = 0.6;
            const effectRadius = 0.4;
            const repelStrength = 0.05;
            const attractStrength = 0.035;
            const damping = 0.92;

            // Gentle rotation
            points.rotation.y = Math.sin(time * 0.08) * 0.08;
            points.rotation.x = Math.sin(time * 0.12) * 0.05;

            const euler = new THREE.Euler(points.rotation.x, points.rotation.y, 0, 'XYZ');
            const inverseQuat = new THREE.Quaternion().setFromEuler(euler).invert();

            let localIntersection = null;
            if (intersectionPoint) {
                localIntersection = intersectionPoint.clone().applyQuaternion(inverseQuat);
            }

            for (let j = 0; j < particleCount; j++) {
                const idx = j * 3;

                const ox = originalPositions[idx];
                const oy = originalPositions[idx + 1];
                const oz = originalPositions[idx + 2];

                const theta = angularSpeed * time + phases[j];
                const targetX = ox + radiusSwirl * Math.cos(theta);
                const targetY = oy + radiusSwirl * Math.sin(theta);
                const targetZ = oz;

                let px = positionAttribute.getX(j);
                let py = positionAttribute.getY(j);
                let pz = positionAttribute.getZ(j);

                let vx = velocities[idx];
                let vy = velocities[idx + 1];
                let vz = velocities[idx + 2];

                // Mouse repel
                if (localIntersection) {
                    const dx = px - localIntersection.x;
                    const dy = py - localIntersection.y;
                    const dz = pz - localIntersection.z;
                    const distSq = dx * dx + dy * dy + dz * dz;
                    const dist = Math.sqrt(distSq);

                    if (distSq < effectRadius * effectRadius && distSq > 0.0001) {
                        const force = (1 - dist / effectRadius) * repelStrength;
                        vx += (dx / dist) * force;
                        vy += (dy / dist) * force;
                        vz += (dz / dist) * force;
                    }
                }

                // Attract to target
                vx += (targetX - px) * attractStrength;
                vy += (targetY - py) * attractStrength;
                vz += (targetZ - pz) * attractStrength;

                // Damping
                vx *= damping;
                vy *= damping;
                vz *= damping;

                // Update
                px += vx;
                py += vy;
                pz += vz;

                positionAttribute.setXYZ(j, px, py, pz);
                velocities[idx] = vx;
                velocities[idx + 1] = vy;
                velocities[idx + 2] = vz;

                // Base teal color
                let r = 0.1;
                let g = 0.48;
                let b = 0.48;

                // Highlight near mouse
                if (localIntersection) {
                    const dx = px - localIntersection.x;
                    const dy = py - localIntersection.y;
                    const dz = pz - localIntersection.z;
                    const distSq = dx * dx + dy * dy + dz * dz;

                    if (distSq < effectRadius * effectRadius) {
                        const intensity = 1 - Math.sqrt(distSq) / effectRadius;
                        // Brighten to lighter teal/cyan
                        r = 0.1 + intensity * 0.3;
                        g = 0.48 + intensity * 0.4;
                        b = 0.48 + intensity * 0.5;
                    }
                }

                colorAttribute.setXYZ(j, r, g, b);
            }

            positionAttribute.needsUpdate = true;
            colorAttribute.needsUpdate = true;

            renderer.render(scene, camera);
            animationId = requestAnimationFrame(animate);
        }

        animationId = requestAnimationFrame(animate);

        // Resize handler
        function handleResize() {
            if (!container) return;

            const width = container.clientWidth || window.innerWidth;
            const height = container.clientHeight || window.innerHeight * 0.6;

            if (width > 0 && height > 0) {
                canvas.width = width;
                canvas.height = height;

                camera.aspect = width / height;
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
                renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            }
        }

        window.addEventListener('resize', handleResize);
        // Delayed resize to ensure CSS has been applied
        setTimeout(handleResize, 100);
        setTimeout(handleResize, 500); // Extra delay for overlay canvases

        // Cleanup
        window.addEventListener('beforeunload', function() {
            cancelAnimationFrame(animationId);
            geometry.dispose();
            material.dispose();
            renderer.dispose();
        });
    }

})();
