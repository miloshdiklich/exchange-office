<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\OrderReceived as OrderReceiveMailable;

class OrderReceivedNotification extends Notification
{
	use Queueable;
	
	/**
	 * @var Order
	 */
	public Order $order;
	
	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}
	
	/**
	 * Get the mail representation of the notification.
	 *
	 * @param $notifiable
	 * @return Mailable
	 */
	public function toMail($notifiable)
	{
		return (new OrderReceiveMailable($this->order));
	}
	
	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
