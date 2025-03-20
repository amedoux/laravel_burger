<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle commande reçue')
            ->line('Une nouvelle commande a été reçue.')
            ->line('Commande #' . $this->order->id)
            ->line('Client: ' . $this->order->name)
            ->line('Total: ' . number_format($this->order->price, 2) . ' €')
            ->action('Voir la commande', url('/orders'))
            ->line('Merci de traiter cette commande rapidement !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'customer_name' => $this->order->name,
            'price' => $this->order->price,
            'message' => 'Nouvelle commande reçue'
        ];
    }
}
