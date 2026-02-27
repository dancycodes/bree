<?php

/**
 * Versioned asset URL for cache busting.
 *
 * Appends ?v=VERSION to force browsers to fetch fresh files after each deploy.
 */
function vasset(string $path): string
{
    return asset($path).'?v='.config('app.asset_version', '1');
}
