<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CentraDesk &middot; Password Reset Passcode</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    @media only screen and (max-width: 600px) {
      .email-container {
        width: 100% !important;
        margin: 0 !important;
        border-radius: 0 !important;
      }
      .email-content {
        padding: 28px 20px !important;
      }
      .otp-display {
        font-size: 30px !important;
        letter-spacing: 6px !important;
      }
    }
  </style>
</head>
<body style="margin: 0; padding: 40px 16px; background-color: #EEF2F6; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; color: #334155;">

  <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
    <tr>
      <td align="center">
        
        <table class="email-container" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 24px; border: 1px solid #CBD5E1; box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05); overflow: hidden;">
          
          <tr>
            <td class="email-content" style="padding: 40px 36px 20px 36px; text-align: center;">
              
              <div style="margin-bottom: 14px;">
                <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 1.2px;">
                  CentraDesk &bull; Enterprise Console
                </span>
              </div>

              <h1 style="margin: 0 0 10px 0; font-size: 24px; font-weight: 800; color: #0F172A; letter-spacing: -0.6px; line-height: 1.25;">
                Password Reset Passcode
              </h1>

              <p style="margin: 0 auto; font-size: 13px; color: #64748B; font-weight: 500; line-height: 1.6; max-width: 380px;">
                We received a request to access your terminal credentials. Please enter the verification code below to set a new password.
              </p>

            </td>
          </tr>

          <tr>
            <td class="email-content" style="padding: 10px 36px 36px 36px;">

              @if(!empty($otpCode))
                <div style="text-align: center; margin: 20px 0 24px 0;">
                  <span style="display: block; font-size: 11px; font-weight: 700; color: #94A3B8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">
                    Verification Code
                  </span>

                  <div style="background-color: #F8FAFC; border: 1.5px dashed #0071E3; border-radius: 18px; padding: 22px 16px; display: inline-block; width: 100%; box-sizing: border-box;">
                    <span class="otp-display" style="display: block; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', monospace; font-size: 36px; font-weight: 800; letter-spacing: 10px; color: #0071E3; text-indent: 10px;">
                      {{ $otpCode }}
                    </span>
                  </div>

                  <span style="display: block; font-size: 11px; font-weight: 600; color: #94A3B8; margin-top: 14px;">
                    Valid for 15 minutes &bull; Do not share this code with anyone
                  </span>
                </div>
              @else
                <div style="text-align: center; background-color: #F0F6FE; border: 1px solid #CBE0FB; border-radius: 16px; padding: 20px; margin: 16px 0 24px 0;">
                  <span style="display: block; font-size: 14px; font-weight: 700; color: #0071E3; margin-bottom: 4px;">
                    Password Successfully Updated
                  </span>
                  <span style="font-size: 12px; color: #475569; font-weight: 500;">
                    Your administrator access credentials have been changed.
                  </span>
                </div>
              @endif

              <div style="border-top: 1px solid #F1F5F9; padding-top: 22px;">
                <p style="margin: 0; font-size: 12px; color: #64748B; font-weight: 500; line-height: 1.6; text-align: center;">
                  If you did not make this request, you can safely ignore this email or review your terminal security logs.
                </p>
              </div>

            </td>
          </tr>

          <tr>
            <td style="background-color: #F8FAFC; border-top: 1px solid #EEF2F6; padding: 20px 36px; text-align: center;">
              <p style="margin: 0 0 4px 0; font-size: 11px; font-weight: 700; color: #475569;">
                CentraDesk Enterprise Console
              </p>
              <p style="margin: 0; font-size: 10px; font-weight: 500; color: #94A3B8;">
                NI Studio Technology &bull; Automated Security Protocol
              </p>
            </td>
          </tr>

        </table>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; margin-top: 16px;">
          <tr>
            <td align="center" style="font-size: 11px; color: #94A3B8; font-weight: 500;">
              This transmission is intended solely for administrative authentication.
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

</body>
</html>