<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouvelle promesse de don — Fondation BREE</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #c80078; padding: 32px 40px;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">
            Nouvelle promesse de don
        </h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 8px 0 0;">
            Fondation BREE — Espace Admin
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 24px;">
            Une nouvelle promesse de don a été soumise via le site web.
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 40%;">Nom</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64; font-weight: 700;">{{ $pledge->fullName() }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Email</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">
                    <a href="mailto:{{ $pledge->email }}" style="color: #c80078;">{{ $pledge->email }}</a>
                </td>
            </tr>
            @if ($pledge->phone)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Téléphone</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ $pledge->phone }}</td>
            </tr>
            @endif
            @if ($pledge->address)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Adresse</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ $pledge->address }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Nature</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">
                    {{ $pledge->nature === 'monetary' ? 'Monétaire' : 'En nature' }}
                </td>
            </tr>
            @if ($pledge->amount)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Montant</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #c80078; font-weight: 700; font-size: 18px;">
                    {{ number_format((float) $pledge->amount, 2, ',', ' ') }} €
                </td>
            </tr>
            @endif
            @if ($pledge->programme)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Programme</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ strtoupper(str_replace('-', ' ', $pledge->programme)) }}</td>
            </tr>
            @endif
            @if ($pledge->message)
            <tr>
                <td style="padding: 10px 0; color: #94a3b8; font-weight: 600; vertical-align: top;">Message</td>
                <td style="padding: 10px 0; color: #475569; font-style: italic;">{{ $pledge->message }}</td>
            </tr>
            @endif
        </table>

    </div>

    {{-- Footer --}}
    <div style="padding: 20px 40px; border-top: 1px solid #f1f5f9;">
        <p style="color: #94a3b8; font-size: 12px; margin: 0;">
            Fondation BREE — {{ config('app.url') }} — Reçu le {{ now()->format('d/m/Y à H:i') }}
        </p>
    </div>

</div>
</body>
</html>
