<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email Address</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .container {
            max-width: 480px;
            margin: 40px auto;
            padding: 32px;
        }

        .logo {
            margin-right: 9px;
            height: 35px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .description {
            font-size: 16px;
            color: #555;
            margin-bottom: 24px;
        }

        .button {
            display: inline-block;
            background-color: #222;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .button:hover {
            background-color: #000;
        }

        .footer {
            margin-top: 24px;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="margin-bottom: 24px">
            <tr>
                <th>
                    <img src="{{ asset(portal('logo')) }}" alt="{{ config('app.name') }}" class="logo">
                </th>
                <th style="font-size: 21px">
                    {{ config('app.name') }}
                </th>
            </tr>
        </table>

        <h1 class="title">Hello, {{ $name }}</h1>
        <p class="description">
            Please click the button below to verify your email address.
        </p>

        <a href="{{ $url }}" target="_blank" class="button">Verify Email Address</a>
        <p class="description" style="font-size:14px">
            If you did not create an account, no further action is required. <br>
            This link will expired in 2 hours
        </p>

        <p class="footer">

            If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your
            web browser : <br>
            <a href="{{ $url }}" target="_blank" style="word-break: break-all;margin-top: 10px;display: inline-block;">
                {{ $url }}
            </a>
        </p>
    </div>
</body>

</html>
