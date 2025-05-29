<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Notification</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>You just logged in to your account on {{ config('app.name') }}.</p>
    <p>If this wasn't you, please reset your password immediately.</p>

    <p>Regards,<br>{{ config('app.name') }} Team</p>
</body>
</html>
