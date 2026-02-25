<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouvelle candidature bénévole</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #143c64; padding: 32px 40px;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">
            Nouvelle candidature bénévole
        </h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin: 8px 0 0;">
            Fondation BREE — Panneau d'administration
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 24px;">
            Une nouvelle candidature bénévole a été reçue :
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 40%;">Nom complet</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{ $application->fullName() }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Email</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">{{ $application->email }}</td>
            </tr>
            @if ($application->phone)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Téléphone</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">{{ $application->phone }}</td>
            </tr>
            @endif
            @if ($application->city_country)
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Ville / Pays</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">{{ $application->city_country }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Programmes</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                    @php
                        $labels = ['protege' => 'BREE PROTÈGE', 'eleve' => 'BREE ÉLÈVE', 'respire' => 'BREE RESPIRE'];
                    @endphp
                    {{ implode(', ', array_map(fn($a) => $labels[$a] ?? $a, $application->areas_of_interest)) }}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Disponibilité</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                    @php
                        $avail = ['weekends' => 'Week-ends', 'weekdays' => 'Jours ouvrables', 'flexible' => 'Flexible'];
                    @endphp
                    {{ $avail[$application->availability] ?? $application->availability }}
                </td>
            </tr>
        </table>

        @if ($application->motivation)
        <div style="margin-top: 24px; padding: 20px; background-color: #f8fafc; border-radius: 12px; border-left: 3px solid #c80078;">
            <p style="color: #94a3b8; font-weight: 600; font-size: 12px; margin: 0 0 8px; text-transform: uppercase; letter-spacing: 0.05em;">Message de motivation</p>
            <p style="color: #475569; font-size: 14px; line-height: 1.7; margin: 0;">{{ $application->motivation }}</p>
        </div>
        @endif

        <div style="margin-top: 32px;">
            <a href="{{ url('/admin/candidatures-benevoles') }}"
               style="display: inline-block; background-color: #c80078; color: #ffffff; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none;">
                Voir dans l'administration →
            </a>
        </div>

    </div>

    {{-- Footer --}}
    <div style="padding: 20px 40px; border-top: 1px solid #f1f5f9;">
        <p style="color: #94a3b8; font-size: 12px; margin: 0;">
            Fondation BREE — {{ config('app.url') }}
        </p>
    </div>

</div>
</body>
</html>
