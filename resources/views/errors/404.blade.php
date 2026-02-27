<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page introuvable — Fondation BREE</title>

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

        /* ── background decorative element ── */
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

        /* ── large 404 numeral ── */
        .error-numeral {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(6.5rem, 22vw, 13rem);
            font-weight: 800;
            line-height: 1;
            color: var(--gold);
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
            animation: bree-fade-up 0.6s 0.1s cubic-bezier(0.22, 1, 0.36, 1) both;
            /* subtle outline treatment for depth */
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

        /* ── primary CTA button ── */
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
            transition: background-color 0.18s ease, transform 0.15s ease;
            animation: bree-fade-up 0.55s 0.46s cubic-bezier(0.22, 1, 0.36, 1) both;
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
            transition: transform 0.15s ease;
        }

        .btn-primary:hover svg {
            transform: translateX(-3px);
        }

        /* ── secondary nav links ── */
        .nav-section {
            margin-top: 2.5rem;
            animation: bree-fade-up 0.55s 0.54s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .nav-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--navy);
            opacity: 0.45;
            margin-bottom: 0.875rem;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.375rem 0.75rem;
            justify-content: center;
        }

        .nav-link {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--navy);
            text-decoration: none;
            padding: 0.375rem 0.875rem;
            border: 1px solid rgba(20, 60, 100, 0.18);
            border-radius: 2rem;
            transition: border-color 0.18s, color 0.18s, background-color 0.18s;
        }

        .nav-link:hover {
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
            .btn-primary,
            .nav-section {
                animation: none;
                opacity: 1;
                transform: none;
            }
        }

        /* ── responsive ── */
        @media (max-width: 480px) {
            body { padding: 2rem 1rem; }
            .nav-links { gap: 0.375rem 0.5rem; }
        }
    </style>
</head>
<body>

    <div class="page-container">

        {{-- Logo --}}
        <div class="logo-wrap">
            <a href="{{ url('/') }}">
                <img
                    src="{{ vasset('images/logo.png') }}"
                    alt="Fondation BREE"
                    class="logo"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                >
                <span class="logo-fallback" style="display:none;">Fondation BREE</span>
            </a>
        </div>

        {{-- Large 404 numeral --}}
        <div class="error-numeral" aria-hidden="true">404</div>

        {{-- Gold divider --}}
        <div class="divider" role="presentation"></div>

        {{-- Heading --}}
        <h1 class="error-heading">Oops, cette page n'existe plus</h1>

        {{-- Explanation --}}
        <p class="error-body">
            Vous avez peut-être suivi un lien obsolète ou saisi une adresse incorrecte.
            Pas d'inquiétude — retournez à l'accueil et continuez votre navigation.
        </p>

        {{-- Primary CTA --}}
        <a href="{{ url('/') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour à l'accueil
        </a>

        {{-- Secondary navigation --}}
        <nav class="nav-section" aria-label="Liens utiles">
            <p class="nav-label">Explorer le site</p>
            <div class="nav-links">
                <a href="{{ url('/programmes') }}" class="nav-link">Programmes</a>
                <a href="{{ url('/actualites') }}" class="nav-link">Actualités</a>
                <a href="{{ url('/evenements') }}" class="nav-link">Événements</a>
                <a href="{{ url('/contact') }}" class="nav-link">Contact</a>
            </div>
        </nav>

    </div>

</body>
</html>
