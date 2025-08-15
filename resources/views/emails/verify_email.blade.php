@extends('emails.base.base_email')

@section('content')
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
      <h2 style="margin: 0;">Verify your email</h2>

      <p>Please verify your email address by clicking the link below.</p>

      <div class="credentials">
        <p><a href="{{ config('app.url') }}/api/v1/users/email/verify/{{ $id }}/{{ $email_token }}">Click here to confirm your email address.</a></p>
      </div>

      <p>Thank you,<br>
      Pasig Catholic College Library</p>

      <div class="footer">
          &copy; {{ now()->year }} Pamantasan ng Lungsod ng Pasig. All rights reserved.
          <p><i>This is a system-generated email. Do not reply.</i></p>
      </div>
    </div>
  </div>
@endsection
