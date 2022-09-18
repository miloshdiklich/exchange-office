<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Mailable
{
	use Queueable, SerializesModels;
	
	/**
	 * @var Order
	 */
	public Order $order;
	
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$emailToNotify = app()->environment() == 'local' ?
			env('NOTIFICATION_EMAIL_ADDRESS') :
			config('app.notifiable_email_address');
		
		return $this
			->to($emailToNotify)
			->view('emails.orders.order-received');
	}
}
