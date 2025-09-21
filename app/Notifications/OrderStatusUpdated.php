<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $previousStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $previousStatus = null)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'pending' => 'Your order has been received and is being processed.',
            'processing' => 'Your order is currently being prepared for shipment.',
            'shipped' => 'Great news! Your order has been shipped and is on its way to you.',
            'delivered' => 'Your order has been successfully delivered. Thank you for your purchase!',
            'cancelled' => 'Your order has been cancelled. If you have any questions, please contact us.'
        ];

        $statusColors = [
            'pending' => '#ffc107',
            'processing' => '#17a2b8',
            'shipped' => '#007bff',
            'delivered' => '#28a745',
            'cancelled' => '#dc3545'
        ];

        $message = $statusMessages[$this->order->status] ?? 'Your order status has been updated.';
        $color = $statusColors[$this->order->status] ?? '#6c757d';

        return (new MailMessage)
            ->subject('Order Status Update - ' . $this->order->order_number)
            ->greeting('Hello ' . $this->order->customer_name . '!')
            ->line($message)
            ->line('**Order Details:**')
            ->line('Order Number: **' . $this->order->order_number . '**')
            ->line('Status: **' . ucfirst($this->order->status) . '**')
            ->line('Total Amount: **$' . $this->order->getFormattedTotalAmount() . '**')
            ->action('View Order Details', route('order.details', $this->order->order_number))
            ->line('If you have any questions about your order, please don\'t hesitate to contact us.')
            ->line('Thank you for choosing us!')
            ->with([
                'order' => $this->order,
                'statusColor' => $color
            ]);
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
            'order_number' => $this->order->order_number,
            'status' => $this->order->status,
            'previous_status' => $this->previousStatus,
            'customer_name' => $this->order->customer_name,
            'total_amount' => $this->order->total_amount,
        ];
    }
}
