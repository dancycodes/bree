import './bootstrap';
import { initAnimations, killAnimations, pageTransitionIn, playHeroEntrance, gsap } from './animations';

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

// Initialize animations on first page load
document.addEventListener('DOMContentLoaded', () => {
    initAnimations();
    initHeroEntrance();
});

// Hook into Gale navigation lifecycle
document.addEventListener('gale:navigated', () => {
    initAnimations();
    pageTransitionIn();
    initHeroEntrance();
});

document.addEventListener('gale:navigating', () => {
    killAnimations();
});
