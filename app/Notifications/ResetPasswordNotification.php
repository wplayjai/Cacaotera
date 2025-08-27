<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expirationTime = Carbon::now()->addMinutes(60)->format('H:i');
        $userName = $notifiable->name ?? 'Estimado usuario';

        return (new MailMessage)
            ->subject('🔐 Solicitud de restablecimiento de contraseña - AgroFinca')
            ->greeting("¡Hola {$userName}!")
            ->line('Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en **AgroFinca**.')
            ->line('Para proceder con el restablecimiento, haz clic en el botón de abajo:')
            ->action('🔑 Restablecer mi contraseña', $url)
            ->line("⏰ **Importante:** Este enlace expirará hoy a las {$expirationTime} (60 minutos desde ahora).")
            ->line('🛡️ **Seguridad:** Si no solicitaste este cambio, puedes ignorar este correo de forma segura. Tu contraseña actual permanecerá sin cambios.')
            ->line('💡 **Tip:** Asegúrate de crear una contraseña segura que contenga al menos 8 caracteres, incluyendo letras, números y símbolos especiales.')
            ->salutation("Atentamente,\n**El equipo de AgroFinca**\n\n---\n*Este es un correo automático, por favor no respondas a este mensaje.*")
            ->markdown('emails.password-reset', [
                'url' => $url,
                'user' => $notifiable,
                'expirationTime' => $expirationTime
            ]);
    }
}