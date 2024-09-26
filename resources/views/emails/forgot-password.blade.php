<!DOCTYPE html>
<html>

<body>
  <h1>Reset Your Password</h1>

  <p>You are receiving this email because we received a password reset request for your account.</p>

  <a href="{{ url('reset-password', $token) }}">Reset Password</a>

  <p>If you did not request a password reset, no further action is required.</p>
</body>

</html>