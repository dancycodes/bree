import './bootstrap';
import { initAnimations, killAnimations, pageTransitionIn } from './animations';

// Register Service Worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js').catch(() => {
            // SW registration failed silently
        });
    });
}

// Initialize animations on first page load
document.addEventListener('DOMContentLoaded', () => {
    initAnimations();
});

// Hook into Gale navigation lifecycle
document.addEventListener('gale:navigated', () => {
    initAnimations();
    pageTransitionIn();
});

document.addEventListener('gale:navigating', () => {
    killAnimations();
});
