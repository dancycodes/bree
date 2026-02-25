<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de partenariat</title>
</head>
<body style="margin:0; padding:0; background-color:#f8f5f0; font-family: Inter, Arial, sans-serif;">
    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <div style="background-color:#143c64; padding:32px 40px;">
            <p style="margin:0; font-size:20px; font-weight:700; color:#ffffff; font-family: 'Playfair Display', Georgia, serif;">
                Fondation BREE
            </p>
            <p style="margin:8px 0 0; font-size:13px; color:rgba(255,255,255,0.7);">
                Nouvelle demande de partenariat
            </p>
        </div>

        {{-- Body --}}
        <div style="padding:32px 40px;">
            <h2 style="margin:0 0 20px; font-size:18px; font-weight:700; color:#143c64;">
                {{ $application->organization_name }}
            </h2>

            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; width:40%; font-size:13px; font-weight:600; color:#64748b; vertical-align:top;">
                        Contact
                    </td>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#1e293b; vertical-align:top;">
                        {{ $application->contact_name }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; font-weight:600; color:#64748b; vertical-align:top;">
                        Email
                    </td>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#1e293b; vertical-align:top;">
                        <a href="mailto:{{ $application->email }}" style="color:#c80078; text-decoration:none;">{{ $application->email }}</a>
                    </td>
                </tr>
                @if($application->phone)
                <tr>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; font-weight:600; color:#64748b; vertical-align:top;">
                        Téléphone
                    </td>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#1e293b; vertical-align:top;">
                        {{ $application->phone }}
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; font-weight:600; color:#64748b; vertical-align:top;">
                        Type d'organisation
                    </td>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#1e293b; vertical-align:top;">
                        {{ ucfirst($application->organization_type) }}
                    </td>
                </tr>
                @if($application->heard_about)
                <tr>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; font-weight:600; color:#64748b; vertical-align:top;">
                        Comment nous a trouvé
                    </td>
                    <td style="padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#1e293b; vertical-align:top;">
                        {{ $application->heard_about }}
                    </td>
                </tr>
                @endif
            </table>

            <div style="margin-top:24px; padding:16px 20px; background-color:#f8f5f0; border-radius:8px; border-left:4px solid #c8a03c;">
                <p style="margin:0 0 8px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#64748b;">
                    Proposition de partenariat
                </p>
                <p style="margin:0; font-size:13px; color:#334155; line-height:1.7;">
                    {{ $application->proposal }}
                </p>
            </div>

            <div style="margin-top:28px; text-align:center;">
                <a href="{{ config('app.url') }}/admin/dashboard"
                   style="display:inline-block; padding:12px 28px; background-color:#c80078; color:#ffffff; text-decoration:none; border-radius:10px; font-size:13px; font-weight:700;">
                    Accéder au tableau de bord
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:20px 40px; border-top:1px solid #f1f5f9; text-align:center;">
            <p style="margin:0; font-size:11px; color:#94a3b8;">
                © {{ date('Y') }} Fondation BREE — Notification automatique
            </p>
        </div>
    </div>
</body>
</html>
