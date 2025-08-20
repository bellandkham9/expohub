<?php
namespace App\Notifications;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class NewSuggestionNotification extends Notification
{
    use Queueable;

    public $suggestion;

    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
    }

    public function via($notifiable)
    {
        return ['database']; // tu peux ajouter 'mail' ou 'broadcast' pour temps réel
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'   => $this->suggestion->title,
            'content' => $this->suggestion->content,
            'type'    => $this->suggestion->type,
        ];
    }
}
