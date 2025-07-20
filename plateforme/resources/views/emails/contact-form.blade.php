<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 0;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #0051a8;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-height: 60px;
        }
        .content {
            padding: 30px;
            color: #333333;
        }
        .content h2 {
            color: #0051a8;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 15px;
            font-size: 12px;
            text-align: center;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- HEADER with logo -->
        <div class="header">
        </div>

        <!-- MAIN CONTENT -->
        <div class="content">
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom :</strong> {{ $name }}</p>
            <p><strong>Email :</strong> {{ $phone  }}</p>
            <p><strong>Téléphone :</strong> {{ $email}}</p>
            <p><strong>Message :</strong></p>
            <p>{{ $messageContent }}</p>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            Ce message vous a été envoyé depuis le formulaire de contact de ExpoHub Academy.
        </div>
    </div>
</body>
</html>
