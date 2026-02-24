import './bootstrap';
import { initAnimations, killAnimations, pageTransitionIn } from './animations';

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
