<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pendaftaran User Baru - SonusHUB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #eaeaea;
        }

        .header {
            text-align: center;
            background-color: #0078d7;
            color: #ffffff;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }

        .content h2 {
            margin-top: 0;
            color: #0078d7;
        }

        .info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eaeaea;
            margin: 15px 0;
        }

        .info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666666;
            margin-top: 20px;
        }

        .footer a {
            color: #0078d7;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header Section -->
    <div class="header">
        <h1>Notifikasi Pendaftaran User Baru</h1>
        <p>SonusHUB</p>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>Kepada Yth. Tim SonusHUB,</h2>
        <p>
            Dengan ini kami informasikan bahwa telah terdaftar pengguna baru pada platform SonusHUB. Berikut adalah
            detail informasi pendaftaran:
        </p>
        <table class="info" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px; font-weight: bold;">Nama Lengkap</td>
                <td style="padding: 8px;">{{ $array['name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Nama Instansi</td>
                <td style="padding: 8px;">{{ $array['jenis'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Email Kantor</td>
                <td style="padding: 8px;">{{ $array['email'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Nomor HP</td>
                <td style="padding: 8px;">{{ $array['phone'] }}</td>
            </tr>
        </table>

        <p>
            Harap segera memproses pendaftaran ini sesuai dengan prosedur yang berlaku.
        </p>
        <p>Terima kasih atas perhatian dan kerjasamanya.</p>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 SonusHUB. All rights reserved.</p>
        <p><a href="https://hub.sonus.id/">Visit SonusHUB</a></p>
    </div>
</div>
</body>
</html>
