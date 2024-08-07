<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <p>Click the link below to reset your password:</p>
    <a href="{{ route('password.reset', $token) }}">Reset Password</a>
</body>
</html>
