<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur serveur — Fondation BREE</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy:   #143c64;
            --navy-d: #002850;
            --magenta: #c80078;
            --gold:   #c8a03c;
            --offwhite: #f8f5f0;
            --muted:  #6b7a8e;
        }

        body {
            font-family: 'Inter', Georgia, 'Times New Roman', sans-serif;
            background-color: var(--offwhite);
            color: var(--navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.25rem;
            text-align: center;
            position: relative;
            overflow-x: hidden;
        }

        /* ── background decorative circles ── */
        body::before {
            content: '';
            position: fixed;
            top: -10%;
            right: -5%;
            width: clamp(280px, 45vw, 520px);
            height: clamp(280px, 45vw, 520px);
            border-radius: 50%;
            border: 1px solid rgba(200, 0, 120, 0.07);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -8%;
            left: -4%;
            width: clamp(200px, 32vw, 380px);
            height: clamp(200px, 32vw, 380px);
            border-radius: 50%;
            border: 1px solid rgba(200, 160, 60, 0.10);
            pointer-events: none;
            z-index: 0;
        }

        /* ── container ── */
        .page-container {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 600px;
        }

        /* ── logo ── */
        .logo-wrap {
            margin-bottom: 3rem;
            animation: bree-drop 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .logo {
            height: clamp(2.5rem, 6vw, 3.5rem);
            width: auto;
            object-fit: contain;
        }

        .logo-fallback {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.375rem;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: 0.02em;
        }

        /* ── error code display ── */
        .error-numeral {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(6.5rem, 22vw, 13rem);
            font-weight: 800;
            line-height: 1;
            color: var(--gold);
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
            animation: bree-fade-up 0.6s 0.1s cubic-bezier(0.22, 1, 0.36, 1) both;
            text-shadow: 2px 2px 0 rgba(200, 160, 60, 0.18);
        }

        /* ── gold divider ── */
        .divider {
            width: 3.5rem;
            height: 2px;
            background-color: var(--gold);
            margin: 1.25rem auto 1.75rem;
            animation: bree-scale-in 0.4s 0.25s ease both;
            transform-origin: center;
        }

        /* ── heading ── */
        .error-heading {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(1.375rem, 4vw, 2rem);
            font-weight: 700;
            color: var(--magenta);
            line-height: 1.25;
            margin-bottom: 1rem;
            animation: bree-fade-up 0.55s 0.3s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* ── body text ── */
        .error-body {
            font-size: clamp(0.9375rem, 2.5vw, 1.0625rem);
            font-weight: 400;
            color: var(--muted);
            line-height: 1.75;
            max-width: 440px;
            margin-bottom: 2.25rem;
            animation: bree-fade-up 0.55s 0.38s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* ── action buttons row ── */
        .btn-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.875rem;
            justify-content: center;
            align-items: center;
            animation: bree-fade-up 0.55s 0.46s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* ── primary CTA (reload) ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--magenta);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.875rem 2.125rem;
            border-radius: 0.5rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: background-color 0.18s ease, transform 0.15s ease;
        }

        .btn-primary:hover {
            background-color: #a30062;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary svg {
            flex-shrink: 0;
        }

        /* ── secondary link (home) ── */
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: transparent;
            color: var(--navy);
            font-family: 'Inter', sans-serif;
            font-size: 0.9375rem;
            font-weight: 500;
            padding: 0.875rem 1.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(20, 60, 100, 0.25);
            text-decoration: none;
            transition: border-color 0.18s, color 0.18s, transform 0.15s;
        }

        .btn-secondary:hover {
            border-color: rgba(20, 60, 100, 0.50);
            color: var(--navy-d);
            transform: translateY(-1px);
        }

        /* ── contact info ── */
        .contact-section {
            margin-top: 2.5rem;
            animation: bree-fade-up 0.55s 0.54s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .contact-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--navy);
            opacity: 0.45;
            margin-bottom: 0.625rem;
        }

        .contact-email {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--navy);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(20, 60, 100, 0.18);
            transition: color 0.18s, border-color 0.18s, background-color 0.18s;
        }

        .contact-email:hover {
            color: var(--magenta);
            border-color: rgba(200, 0, 120, 0.30);
            background-color: rgba(200, 0, 120, 0.04);
        }

        /* ── animation keyframes ── */
        @keyframes bree-drop {
            from { opacity: 0; transform: translateY(-14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes bree-fade-up {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes bree-scale-in {
            from { opacity: 0; transform: scaleX(0); }
            to   { opacity: 1; transform: scaleX(1); }
        }

        /* ── reduced motion ── */
        @media (prefers-reduced-motion: reduce) {
            .logo-wrap,
            .error-numeral,
            .divider,
            .error-heading,
            .error-body,
            .btn-row,
            .contact-section {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }

        /* ── responsive ── */
        @media (max-width: 480px) {
            body { padding: 2rem 1rem; }
            .btn-row { flex-direction: column; width: 100%; }
            .btn-primary, .btn-secondary { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="page-container">

        {{-- Logo — use absolute path, no asset() helper on 500 --}}
        <div class="logo-wrap">
            <a href="/">
                <img
                    src="/images/logo.png"
                    alt="Fondation BREE"
                    class="logo"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                >
                <span class="logo-fallback" style="display:none;">Fondation BREE</span>
            </a>
        </div>

        {{-- Large 500 numeral --}}
        <div class="error-numeral" aria-hidden="true">500</div>

        {{-- Gold divider --}}
        <div class="divider" role="presentation"></div>

        {{-- Heading --}}
        <h1 class="error-heading">Une erreur est survenue</h1>

        {{-- Explanation --}}
        <p class="error-body">
            Toutes nos excuses — quelque chose s'est mal passé de notre côté.
            Notre équipe a été informée et s'occupe du problème.
            Veuillez réessayer dans quelques instants.
        </p>

        {{-- Action buttons --}}
        <div class="btn-row">
            <button
                class="btn-primary"
                onclick="window.location.reload();"
                type="button"
            >
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Réessayer
            </button>

            <a href="/" class="btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Accueil
            </a>
        </div>

        {{-- Support contact --}}
        <div class="contact-section">
            <p class="contact-label">Besoin d'aide ?</p>
            <a href="mailto:contact@breefondation.org" class="contact-email">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                contact@breefondation.org
            </a>
        </div>

    </div>

</body>
</html>
