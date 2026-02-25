<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre don récurrent a été annulé</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px;">
<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">

    <div style="background-color: #143c64; padding: 28px 40px; text-align: left;">
        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" style="height: 44px; width: auto; margin-bottom: 16px; display: block;">
        <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 700; line-height: 1.4;">
            Annulation de votre don récurrent
        </h1>
        <p style="color: rgba(255,255,255,0.65); font-size: 13px; margin: 6px 0 0;">Fondation BREE</p>
    </div>

    <div style="padding: 32px 40px;">
        <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
            Bonjour {{ $donation->donor_name }},
        </p>
        <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
            Nous vous confirmons l'annulation de votre don récurrent de
            <strong>{{ number_format((float) $donation->amount, 0, ',', ' ') }} {{ $donation->currency }}</strong>
            ({{ $donation->frequency }}) en faveur de la Fondation BREE.
        </p>
        <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0 0 20px;">
            Votre soutien passé a été précieux pour nous. Si vous souhaitez reprendre votre contribution ou en savoir plus sur nos programmes, n'hésitez pas à nous contacter.
        </p>
        <p style="color: #374151; font-size: 15px; line-height: 1.6; margin: 0;">
            Avec gratitude,<br>
            <strong>L'équipe de la Fondation BREE</strong>
        </p>
    </div>

    <div style="background-color: #f8fafc; padding: 20px 40px; border-top: 1px solid #e2e8f0;">
        <p style="color: #94a3b8; font-size: 12px; margin: 0; line-height: 1.5;">
            Fondation BREE · contact@breefondation.org<br>
            Si vous avez des questions, répondez à cet email.
        </p>
    </div>
</div>
</body>
</html>
