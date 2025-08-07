<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to PCC Library</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9fafb;
      color: #333;
      line-height: 1.6;
    }
    .container {
      background-color: #ffffff;
      padding: 24px;
      max-width: 500px;
      margin: 40px auto;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    }
    .credentials {
      background-color: #f1f5f9;
      padding: 12px;
      border-radius: 6px;
      font-family: monospace;
    }
    .footer {
      margin-top: 32px;
      font-size: 12px;
      color: #999;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header with logo and title -->
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="vertical-align: middle;" align="left">
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td style="padding-right: 20px;">
                <img src="https://frijaaay.github.io/domain-test/assets/images/emails/pcclogo.png" alt="PCC LOGO" height="100" style="display: block;" />
              </td>
              <td valign="middle">
                <h1 style="margin: 0; font-size: 2rem; font-weight: bold; color: #DA0402; font-family: Arial, sans-serif;">PCC Library</h1>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Body Content -->
    <div style="margin-top: 40px;">
      <h2 style="margin: 0;">Welcome, {{ $name }}!</h2>

      <p>Your account has been successfully created in the PCC Library Portal.</p>

      <p>You can now log in using the following credentials:</p>

      <div class="credentials">
        <p><strong>Username:</strong> {{ $id_number }}</p>
        <p><strong>Temporary Password:</strong> {{ $plainPassword }}</p>
      </div>

      <p><strong>Please change your password</strong> immediately after logging in.</p>

      <p>Access the portal here: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>

      <p>Thank you,<br>
      Pasig Catholic College Library</p>

      <div class="footer">
          &copy; {{ now()->year }} Pamantasan ng Lungsod ng Pasig. All rights reserved.
          <p><i>This is a system-generated email. Do not reply.</i></p>
      </div>
    </div>
  </div>
</body>
</html>
