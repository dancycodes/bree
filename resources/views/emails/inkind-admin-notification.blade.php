<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouveau don en nature — Fondation BREE</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #16a34a; padding: 32px 40px;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">
            Nouveau don en nature
        </h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 14px; margin: 8px 0 0;">
            Fondation BREE — Espace Admin
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 24px;">
            Une nouvelle proposition de don en nature a été soumise via le site web.
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 40%;">Donateur</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64; font-weight: 700;">{{ $donation->donor_name }}</td>
            </tr>
            @if ($donation->organization)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Organisation</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ $donation->organization }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Email</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">
                    <a href="mailto:{{ $donation->email }}" style="color: #c80078;">{{ $donation->email }}</a>
                </td>
            </tr>
            @if ($donation->phone)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Téléphone</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ $donation->phone }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Type de don</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #16a34a; font-weight: 700;">
                    {{ match($donation->donation_type) {
                        'goods' => 'Biens / Matériel',
                        'services' => 'Services',
                        'expertise' => 'Expertise / Compétences',
                        default => 'Autre'
                    } }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; vertical-align: top;">Description</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #475569;">{{ $donation->description }}</td>
            </tr>
            @if ($donation->estimated_value)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Valeur estimée</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #c80078; font-weight: 700; font-size: 18px;">
                    {{ number_format((float) $donation->estimated_value, 2, ',', ' ') }} €
                </td>
            </tr>
            @endif
            @if ($donation->programme)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Programme</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64;">{{ strtoupper(str_replace('-', ' ', $donation->programme)) }}</td>
            </tr>
            @endif
            @if ($donation->availability)
            <tr>
                <td style="padding: 10px 0; color: #94a3b8; font-weight: 600; vertical-align: top;">Disponibilité</td>
                <td style="padding: 10px 0; color: #475569;">{{ $donation->availability }}</td>
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
