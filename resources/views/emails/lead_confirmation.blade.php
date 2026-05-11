<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hemos recibido tu solicitud</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9;padding:40px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

          <!-- HEADER -->
          <tr>
            <td style="background:#ffffff;border-radius:16px 16px 0 0;padding:32px 40px;text-align:center;border-bottom:3px solid #2563eb;">
              <span style="font-size:24px;font-weight:800;color:#1e2535;letter-spacing:-0.5px;">
                Talention<span style="color:#2563eb;">HR</span>
              </span>
            </td>
          </tr>

          <!-- FRANJA AZUL -->
          <tr>
            <td style="background:#2563eb;padding:24px 40px;">
              <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:700;line-height:1.3;">
                Hemos recibido tu solicitud
              </h1>
            </td>
          </tr>

          <!-- CONTENIDO -->
          <tr>
            <td style="background:#ffffff;padding:36px 40px;">
              <div style="color:#374151;font-size:15px;line-height:1.7;">
                <p style="margin:0 0 16px;">Hola, <strong>{{ $lead->name }}</strong>,</p>
                <p style="margin:0 0 16px;">Gracias por ponerte en contacto con nosotros. Hemos recibido tu solicitud correctamente y nos pondremos en contacto contigo a la mayor brevedad posible.</p>
                @if($lead->company)
                  <p style="margin:0 0 16px;">Datos registrados: <strong>{{ $lead->name }}</strong>{{ $lead->company ? ' · ' . $lead->company : '' }}</p>
                @endif
                <p style="margin:0;">Un saludo,<br/><strong>El equipo de TalentionHR</strong></p>
              </div>
            </td>
          </tr>

          <!-- SEPARADOR -->
          <tr>
            <td style="background:#ffffff;padding:0 40px;">
              <hr style="border:none;border-top:1px solid #e2e8f0;margin:0;" />
            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="background:#ffffff;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;">
              <p style="margin:0 0 4px;color:#6b7280;font-size:13px;">
                TalentionHR · Soluciones de talento para empresas modernas
              </p>
              <p style="margin:0;color:#9ca3af;font-size:12px;">
                Este email es una confirmación automática de recepción de tu solicitud.
              </p>
            </td>
          </tr>

          <!-- ESPACIO INFERIOR -->
          <tr>
            <td style="padding:24px;text-align:center;">
              <p style="margin:0;color:#9ca3af;font-size:11px;">
                © {{ date('Y') }} TalentionHR. Todos los derechos reservados.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
