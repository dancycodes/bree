<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouveau message de contact</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #143c64; padding: 32px 40px;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">
            Nouveau message de contact
        </h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin: 8px 0 0;">
            Fondation BREE — Panneau d'administration
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 24px;">
            Un nouveau message a été reçu depuis le formulaire de contact :
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 30%;">Nom</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{ $contactMessage->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Email</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b;">
                    <a href="mailto:{{ $contactMessage->email }}" style="color: #c80078; text-decoration: none;">{{ $contactMessage->email }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">Sujet</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #1e293b; font-weight: 500;">{{ $contactMessage->subject }}</td>
            </tr>
        </table>

        <div style="margin-top: 24px; padding: 20px; background-color: #f8fafc; border-radius: 12px; border-left: 3px solid #c80078;">
            <p style="color: #94a3b8; font-weight: 600; font-size: 12px; margin: 0 0 8px; text-transform: uppercase; letter-spacing: 0.05em;">Message</p>
            <p style="color: #475569; font-size: 14px; line-height: 1.7; margin: 0; white-space: pre-line;">{{ $contactMessage->message }}</p>
        </div>

        <div style="margin-top: 32px;">
            <a href="mailto:{{ $contactMessage->email }}"
               style="display: inline-block; background-color: #c80078; color: #ffffff; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none;">
                Répondre à {{ $contactMessage->name }} →
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
