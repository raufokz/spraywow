<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    public function __construct(protected Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("SprayWow order {$this->order->order_number} confirmed")
            ->greeting("Thanks for your order, {$this->order->billing_name}!")
            ->line("We've received your order {$this->order->order_number}.")
            ->line('Order total: $'.number_format((float) $this->order->total, 2))
            ->action('Track your order', route('account.orders.show', $this->order))
            ->line('We will email you again when the order status changes.');
    }
}
