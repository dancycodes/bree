import './bootstrap';
import { initAnimations, killAnimations, pageTransitionIn, pageTransitionOut, playHeroEntrance, gsap, ScrollTrigger, animateCounter, playConfetti } from './animations';

// Register Service Worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // SW registration failed silently
        });
    });
}

/**
 * Play GSAP entrance animation for the hero section.
 * Called on initial load and on Gale navigation back to home.
 */
function initHeroEntrance() {
    const hero = document.querySelector('[data-hero]');
    if (!hero) return;

    playHeroEntrance({
        image: hero.querySelector('[data-hero-image]'),
        tagline: hero.querySelector('[data-hero-tagline]'),
        subtitle: hero.querySelector('[data-hero-subtitle]'),
        ctas: hero.querySelectorAll('[data-hero-cta]'),
        scroll: hero.querySelector('[data-hero-scroll]'),
    });

    const badge = hero.querySelector('[data-hero-badge]');
    if (badge) {
        gsap.from(badge, { y: 15, opacity: 0, duration: 0.5, ease: 'power3.out', delay: 0.15 });
    }
}

/**
 * Initialize scroll-triggered counter animations.
 * Counters animate from 0 to their target value once, on first scroll-into-view.
 */
function initCounters() {
    document.querySelectorAll('[data-counter]').forEach(el => {
        const target = parseInt(el.getAttribute('data-counter'), 10);
        if (isNaN(target)) return;

        // Reset to 0 for Gale re-navigation
        el.textContent = '0';

        ScrollTrigger.create({
            trigger: el,
            start: 'top 90%',
            once: true,
            onEnter: () => animateCounter(el, target, 2),
        });
    });
}

/**
 * Trigger confetti burst if current page has [data-confetti] marker element.
 */
function initConfetti() {
    if (document.querySelector('[data-confetti]')) {
        playConfetti();
    }
}

// Initialize animations on first page load
document.addEventListener('DOMContentLoaded', () => {
    initAnimations();
    initHeroEntrance();
    initCounters();
    initConfetti();
});

// Hook into Gale navigation lifecycle
document.addEventListener('gale:navigated', () => {
    initAnimations();
    pageTransitionIn();
    initHeroEntrance();
    initCounters();
    initConfetti();
});

document.addEventListener('gale:navigating', () => {
    killAnimations();
    pageTransitionOut(() => {});
});
