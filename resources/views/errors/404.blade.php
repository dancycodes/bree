<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page introuvable — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #1a1a2e;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .logo { height: 3.5rem; width: auto; object-fit: contain; margin-bottom: 3rem; }
        .error-number {
            font-family: 'Playfair Display', serif;
            font-size: clamp(6rem, 20vw, 12rem);
            font-weight: 800;
            color: #c8a03c;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .error-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            color: #c80078;
            margin-bottom: 1rem;
            text-align: center;
        }
        .error-message {
            font-size: 1rem;
            color: #64748b;
            text-align: center;
            max-width: 480px;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #c80078;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.9375rem;
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .btn-home:hover { opacity: 0.88; }
        .nav-links {
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem 1.5rem;
            justify-content: center;
        }
        .nav-link {
            font-size: 0.875rem;
            color: #143c64;
            text-decoration: none;
            font-weight: 500;
        }
        .nav-link:hover { color: #c80078; }
        .divider {
            width: 3rem;
            height: 2px;
            background-color: #c8a03c;
            margin: 0 auto 2rem;
        }
    </style>
</head>
<body>

    <a href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
    </a>

    <div class="error-number">404</div>

    <div class="divider"></div>

    <h1 class="error-heading">Cette page n'existe pas</h1>

    <p class="error-message">
        Vous avez peut-être suivi un lien obsolète ou saisi une adresse incorrecte.
        Pas d'inquiétude — retournez à l'accueil et continuez votre navigation.
    </p>

    <a href="{{ url('/') }}" class="btn-home">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Retour à l'accueil
    </a>

    <nav class="nav-links">
        <a href="{{ url('/a-propos') }}" class="nav-link">À Propos</a>
        <a href="{{ url('/programmes') }}" class="nav-link">Programmes</a>
        <a href="{{ url('/actualites') }}" class="nav-link">Actualités</a>
        <a href="{{ url('/evenements') }}" class="nav-link">Événements</a>
        <a href="{{ url('/faire-un-don') }}" class="nav-link">Faire un don</a>
        <a href="{{ url('/contact') }}" class="nav-link">Contact</a>
    </nav>

</body>
</html>
