/**
 * Fondation BREE — Service Worker
 * Caches static assets for offline support.
 */

const CACHE_NAME = 'bree-foundation-v1';

const STATIC_ASSETS = [
    '/images/logo.png',
    '/images/sections/hero.jpg',
];

// Install — cache static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(STATIC_ASSETS).catch(() => {
                // Ignore cache failures silently
            });
        })
    );
    self.skipWaiting();
});

// Activate — clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            )
        )
    );
    self.clients.claim();
});

// Fetch — network-first, fallback to cache for images
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Only handle same-origin requests
    if (url.origin !== location.origin) return;

    // Cache-first for images and static assets
    if (
        event.request.destination === 'image' ||
        event.request.url.includes('/build/')
    ) {
        event.respondWith(
            caches.match(event.request).then(cached => {
                if (cached) return cached;
                return fetch(event.request).then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                    return response;
                }).catch(() => cached);
            })
        );
        return;
    }

    // Network-first for HTML pages
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match('/offline') || new Response(
                    `<!DOCTYPE html>
<html lang="fr">
<head><meta charset="utf-8"><title>Hors ligne — Fondation BREE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
  body { font-family: Inter, sans-serif; background: #002850; color: white;
         display: flex; align-items: center; justify-content: center;
         min-height: 100vh; margin: 0; text-align: center; padding: 2rem; }
  h1 { font-size: 1.5rem; margin-bottom: 0.5rem; }
  p { color: rgba(255,255,255,0.6); font-size: 0.875rem; }
</style>
</head>
<body>
  <div>
    <h1>Vous êtes hors ligne</h1>
    <p>Vérifiez votre connexion internet et réessayez.</p>
  </div>
</body>
</html>`,
                    { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
                );
            })
        );
    }
});
