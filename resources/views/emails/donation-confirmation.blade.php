<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('donation.merci_heading_personalized', ['name' => $donation->donor_name]) }}</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    {{-- Header --}}
    <div style="background-color: #143c64; padding: 28px 40px; text-align: left;">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 44px; width: auto; margin-bottom: 16px; display: block;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700; line-height: 1.4;">
            {{ __('donation.merci_heading_personalized', ['name' => $donation->donor_name]) }}
        </h1>
        <p style="color: rgba(255,255,255,0.65); font-size: 13px; margin: 6px 0 0;">
            Fondation BREE
        </p>
    </div>

    {{-- Body --}}
    <div style="padding: 32px 40px;">

        <p style="color: #475569; font-size: 14px; margin: 0 0 28px; line-height: 1.6;">
            {{ __('donation.merci_sub') }}
        </p>

        @php
            $programmeName = match($donation->programme) {
                'bree-protege' => __('donation.programme_protege'),
                'bree-eleve'   => __('donation.programme_eleve'),
                'bree-respire' => __('donation.programme_respire'),
                default        => __('donation.programme_general'),
            };
        @endphp

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600; width: 45%;">
                    {{ __('donation.merci_amount') }}
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #c80078; font-weight: 700; font-size: 18px;">
                    {{ number_format((float) $donation->amount, 2, ',', ' ') }}&nbsp;€
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">
                    {{ __('donation.merci_programme') }}
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #143c64; font-weight: 600;">
                    {{ $programmeName }}
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #94a3b8; font-weight: 600;">
                    {{ __('donation.merci_reference') }}
                </td>
                <td style="padding: 12px 0; border-bottom: 1px solid #f1f5f9; color: #143c64; font-family: monospace; font-size: 13px;">
                    {{ $donation->tx_ref }}
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 0; color: #94a3b8; font-weight: 600;">
                    {{ __('donation.merci_status_label') }}
                </td>
                <td style="padding: 12px 0; color: #16a34a; font-weight: 600;">
                    {{ __('donation.merci_status_completed') }}
                </td>
            </tr>
        </table>

    </div>

    {{-- Footer --}}
    <div style="padding: 24px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
        <p style="color: #94a3b8; font-size: 12px; margin: 0 0 4px;">
            Fondation BREE &mdash; <a href="{{ config('app.url') }}" style="color: #c80078; text-decoration: none;">{{ config('app.url') }}</a>
        </p>
        <p style="color: #94a3b8; font-size: 12px; margin: 0;">
            <a href="mailto:contact@breefondation.org" style="color: #94a3b8; text-decoration: none;">contact@breefondation.org</a>
        </p>
    </div>

</div>
</body>
</html>
