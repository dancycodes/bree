/**
 * Fondation BREE — Animation System
 * Powered by GSAP + ScrollTrigger
 *
 * Usage:
 *   - Add data-animate="fade-up" to elements for scroll-triggered entrance
 *   - Add data-stagger to parent to stagger-animate children with data-animate
 *   - Call initAnimations() after page load / Gale navigation
 *   - Call killAnimations() before Gale navigation
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Respect prefers-reduced-motion
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Initialize all scroll-triggered animations.
 * Called on page load and after each Gale navigation.
 */
export function initAnimations() {
    if (prefersReducedMotion) {
        // Remove opacity:0 from all animate targets so content is visible
        document.querySelectorAll('[data-animate]').forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    // Scroll-triggered entrance animations
    document.querySelectorAll('[data-animate]').forEach(el => {
        const type = el.getAttribute('data-animate') || 'fade-up';
        const delay = parseFloat(el.getAttribute('data-delay') || '0');

        const fromVars = getFromVars(type);
        const toVars = {
            opacity: 1,
            x: 0,
            y: 0,
            scale: 1,
            duration: 0.7,
            ease: 'power2.out',
            delay,
        };

        gsap.set(el, { opacity: 0, ...fromVars });

        ScrollTrigger.create({
            trigger: el,
            start: 'top 88%',
            onEnter: () => gsap.to(el, toVars),
            once: true,
        });
    });

    // Stagger groups — animate children with data-animate inside data-stagger
    document.querySelectorAll('[data-stagger]').forEach(parent => {
        const children = parent.querySelectorAll('[data-animate]');
        if (!children.length) return;

        const staggerDelay = parseFloat(parent.getAttribute('data-stagger') || '0.1');

        children.forEach((child, i) => {
            const type = child.getAttribute('data-animate') || 'fade-up';
            const fromVars = getFromVars(type);

            gsap.set(child, { opacity: 0, ...fromVars });

            ScrollTrigger.create({
                trigger: parent,
                start: 'top 85%',
                onEnter: () => {
                    gsap.to(child, {
                        opacity: 1,
                        x: 0,
                        y: 0,
                        scale: 1,
                        duration: 0.6,
                        ease: 'power2.out',
                        delay: i * staggerDelay,
                    });
                },
                once: true,
            });
        });
    });
}

/**
 * Kill all ScrollTrigger instances.
 * Call before Gale navigation to avoid memory leaks.
 */
export function killAnimations() {
    ScrollTrigger.getAll().forEach(st => st.kill());
}

/**
 * Animate a counter from 0 to target value.
 * Used for impact statistics section.
 */
export function animateCounter(element, target, duration = 2) {
    if (prefersReducedMotion) {
        element.textContent = formatNumber(target);
        return;
    }

    const obj = { value: 0 };
    gsap.to(obj, {
        value: target,
        duration,
        ease: 'power2.out',
        onUpdate: () => {
            element.textContent = formatNumber(Math.round(obj.value));
        },
    });
}

/**
 * Hero entrance timeline — called once on first page load.
 */
export function playHeroEntrance(elements) {
    if (prefersReducedMotion || !elements) return;

    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    if (elements.image) {
        tl.from(elements.image, { scale: 1.08, duration: 1.4, ease: 'power2.out' }, 0);
    }
    if (elements.tagline) {
        tl.from(elements.tagline, { y: 40, opacity: 0, duration: 0.8 }, 0.3);
    }
    if (elements.subtitle) {
        tl.from(elements.subtitle, { y: 20, opacity: 0, duration: 0.6 }, 0.55);
    }
    if (elements.ctas) {
        tl.from(elements.ctas, { y: 20, opacity: 0, duration: 0.5, stagger: 0.12 }, 0.75);
    }
    if (elements.scroll) {
        tl.from(elements.scroll, { opacity: 0, duration: 0.4 }, 1.1);
    }

    return tl;
}

/**
 * Page transition — fade out before Gale navigation.
 */
export function pageTransitionOut(callback) {
    if (prefersReducedMotion) {
        callback();
        return;
    }

    gsap.to('#main-content', {
        opacity: 0,
        y: -8,
        duration: 0.2,
        ease: 'power2.in',
        onComplete: callback,
    });
}

/**
 * Page transition — fade in after Gale navigation.
 */
export function pageTransitionIn() {
    if (prefersReducedMotion) return;

    gsap.fromTo('#main-content',
        { opacity: 0, y: 10 },
        { opacity: 1, y: 0, duration: 0.35, ease: 'power2.out' }
    );
}

// ─── Helpers ────────────────────────────────────────────────────────────────

function getFromVars(type) {
    const map = {
        'fade-up':    { y: 30 },
        'fade-down':  { y: -30 },
        'fade-left':  { x: -30 },
        'fade-right': { x: 30 },
        'fade-in':    {},
        'scale-in':   { scale: 0.92 },
        'zoom-in':    { scale: 0.85 },
    };
    return map[type] || { y: 30 };
}

function formatNumber(n) {
    return n.toLocaleString('fr-FR');
}

/**
 * Confetti burst — one-time celebratory animation on donation success page.
 * Creates coloured dots that shoot upward and fade out.
 */
export function playConfetti() {
    if (prefersReducedMotion) return;

    const colors = ['#c80078', '#143c64', '#c8a03c', '#e0a0cc', '#a0c0e8'];
    const container = document.createElement('div');
    container.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:9999;overflow:hidden;';
    document.body.appendChild(container);

    for (let i = 0; i < 70; i++) {
        const dot = document.createElement('div');
        const color = colors[Math.floor(Math.random() * colors.length)];
        const size = Math.random() * 10 + 5;
        const isCircle = Math.random() > 0.4;
        dot.style.cssText = `position:absolute;width:${size}px;height:${size}px;background:${color};border-radius:${isCircle ? '50%' : '2px'};left:${Math.random() * 100}%;top:110%;opacity:1;`;
        container.appendChild(dot);

        gsap.to(dot, {
            y: -(window.innerHeight * (Math.random() * 0.65 + 0.35)),
            x: (Math.random() - 0.5) * 350,
            rotation: Math.random() * 720 - 360,
            opacity: 0,
            duration: Math.random() * 1.4 + 0.8,
            delay: Math.random() * 0.6,
            ease: 'power2.out',
            onComplete: () => dot.remove(),
        });
    }

    gsap.delayedCall(3.5, () => {
        if (container.parentNode) {
            container.remove();
        }
    });
}

export { gsap, ScrollTrigger };
