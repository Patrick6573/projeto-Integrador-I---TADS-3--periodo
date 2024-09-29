namespace App\Notifications;

use App\Models\Visita;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitaSolicitada extends Notification
{
    use Queueable;

    protected $visita;

    public function __construct(Visita $visita)
    {
        $this->visita = $visita;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Pode incluir outras formas de notificação
    }

    public function toDatabase($notifiable)
    {
        return [
            'visita_id' => $this->visita->id,
            'data_visita' => $this->visita->data_visita,
            'hora_visita' => $this->visita->hora_visita,
            'message' => 'Nova solicitação de visita de ' . $this->visita->user->name,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nova Solicitação de Visita')
                    ->line('Você recebeu uma nova solicitação de visita.')
                    ->action('Ver Solicitações', url('/minhas-visitas'));
    }
}
