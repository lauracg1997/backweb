<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $subject }}</title>
</head>
<body style="margin:0;padding:0;background:#f0f4f8;font-family:'Segoe UI',Helvetica,Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f4f8;padding:48px 16px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

          <!-- LOGO AREA -->
          <tr>
            <td style="padding:0 0 24px 0;text-align:center;">
              @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="TalentionHR" style="height:52px;width:auto;display:inline-block;" />
              @else
                <span style="font-size:26px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Talention<span style="color:#2563eb;">HR</span></span>
              @endif
            </td>
          </tr>

          <!-- MAIN CARD -->
          <tr>
            <td style="background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.07);">

              <!-- TOP ACCENT BAR -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="background:linear-gradient(135deg,#1d4ed8 0%,#2563eb 60%,#3b82f6 100%);height:6px;font-size:0;line-height:0;">&nbsp;</td>
                </tr>
              </table>

              <!-- HEADER -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:40px 48px 32px;border-bottom:1px solid #f1f5f9;">
                    <h1 style="margin:0;color:#0f172a;font-size:24px;font-weight:700;line-height:1.3;">
                      {{ $subject }}
                    </h1>
                  </td>
                </tr>
              </table>

              <!-- CONTENT -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:32px 48px 40px;">
                    <div style="color:#334155;font-size:15px;line-height:1.8;">
                      {!! $content !!}
                    </div>
                  </td>
                </tr>
              </table>

              <!-- CTA DIVIDER -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:0 48px 40px;">
                    <table cellpadding="0" cellspacing="0">
                      <tr>
                        <td style="background:#2563eb;border-radius:10px;padding:14px 32px;">
                          <a href="{{ config('app.frontend_url') }}" style="color:#ffffff;font-size:15px;font-weight:600;text-decoration:none;display:inline-block;">
                            Visitar TalentionHR &rarr;
                          </a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- FOOTER INSIDE CARD -->
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="background:#f8fafc;padding:24px 48px;border-top:1px solid #f1f5f9;">
                    <p style="margin:0 0 4px;color:#64748b;font-size:13px;font-weight:600;">TalentionHR</p>
                    <p style="margin:0;color:#94a3b8;font-size:12px;line-height:1.6;">
                      Soluciones de talento para empresas modernas.<br/>
                      Has recibido este email porque eres parte de nuestra red de contactos.
                    </p>
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- COPYRIGHT -->
          <tr>
            <td style="padding:24px 0;text-align:center;">
              <p style="margin:0;color:#94a3b8;font-size:11px;">
                &copy; {{ date('Y') }} TalentionHR &middot; Todos los derechos reservados.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
