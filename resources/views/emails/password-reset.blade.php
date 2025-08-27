{{-- resources/views/emails/password-reset.blade.php --}}
@component('mail::message')

{{-- Header con logo --}}
<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ asset('img/cacao.png') }}" alt="AgroFinca" width="80" style="border-radius: 8px;">
    <h1 style="color: #2d5016; font-size: 28px; margin: 15px 0 5px 0; font-weight: bold;">AgroFinca</h1>
    <p style="color: #666; font-size: 14px; margin: 0;">Tecnología para el campo</p>
</div>

{{-- Título principal --}}
# 🔐 Restablecimiento de Contraseña

---

Hola **{{ $user->name ?? 'estimado usuario' }}**,

Recibimos una solicitud para **restablecer la contraseña** de tu cuenta en AgroFinca.

{{-- Información de seguridad --}}
<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; margin: 20px 0;">
    <strong>📋 Detalles de la solicitud:</strong><br>
    • **Fecha y hora:** {{ now()->format('d/m/Y H:i') }}<br>
    • **Correo electrónico:** {{ $user->email }}<br>
    • **Validez del enlace:** 60 minutos
</div>

Para continuar con el proceso, haz clic en el siguiente botón:

@component('mail::button', ['url' => $url, 'color' => 'success'])
🔑 Restablecer mi Contraseña
@endcomponent

{{-- Información adicional --}}
<div style="background: #fff3cd; padding: 15px; border-radius: 6px; border: 1px solid #ffeaa7; margin: 25px 0;">
    <strong>⚠️ Importante:</strong><br>
    • Este enlace expirará en **60 minutos** ({{ $expirationTime ?? 'ver hora en el correo' }})<br>
    • Solo funciona **una vez**<br>
    • Si no fuiste tú quien solicitó este cambio, ignora este correo
</div>

{{-- Consejos de seguridad --}}
<div style="background: #e7f3ff; padding: 15px; border-radius: 6px; border: 1px solid #b3d9ff; margin: 25px 0;">
    <strong>💡 Consejos para una contraseña segura:</strong><br>
    ✓ Mínimo 8 caracteres<br>
    ✓ Incluye mayúsculas y minúsculas<br>
    ✓ Añade números y símbolos especiales<br>
    ✓ Evita información personal obvvia
</div>

---

**¿Problemas con el enlace?**

Si el botón no funciona, copia y pega este enlace en tu navegador:
{{ $url }}

---

**¿No solicitaste este cambio?**

Si no fuiste tú quien solicitó restablecer la contraseña, tu cuenta sigue siendo segura. Simplemente ignora este correo y tu contraseña actual no será modificada.

Si tienes dudas sobre la seguridad de tu cuenta, contacta con nuestro equipo de soporte.

---

Saludos cordiales,

**El equipo de AgroFinca** 🌱

<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #888;">
    <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
    <p>AgroFinca - Transformando la agricultura con tecnología</p>
    <p>© {{ date('Y') }} AgroFinca. Todos los derechos reservados.</p>
</div>

@endcomponent