<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ __('donation.merci_heading') }}</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #143c64; padding: 32px 40px;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700;">
            {{ __('donation.merci_heading') }}
        </h1>
        <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin: 8px 0 0;">
            Fondation BREE
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 24px;">
            {{ __('donation.merci_sub') }}
        </p>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 40%;">{{ __('donation.merci_amount') }}</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #c80078; font-weight: 700; font-size: 18px;">
                    {{ number_format((float) $donation->amount, 2, ',', ' ') }} €
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">{{ __('donation.merci_reference') }}</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #f1f5f9; color: #143c64; font-family: monospace;">{{ $donation->tx_ref }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #94a3b8; font-weight: 600;">Statut</td>
                <td style="padding: 10px 0; color: #16a34a; font-weight: 600;">{{ __('donation.merci_status_completed') }}</td>
            </tr>
        </table>

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
