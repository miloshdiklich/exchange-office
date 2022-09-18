<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;
use App\Notifications\OrderReceivedNotification;

class OrderObserver
{
	/**
	 * Handle the Order "created" event.
	 *
	 * @param \App\Models\Order $order
	 * @return void
	 */
	public function created(Order $order)
	{
		if( $order->currency_purchased == 'GBP' ) {
			try {
				$order->notify( new OrderReceivedNotification($order) );
			}
			catch(\Exception $e) {
				Log::error( $e->getMessage() );
			}
		}
		
		if( $order->currency_purchased == 'EUR' ) {
			$currency = Currency::where('short_code', $order->currency_purchased)->first();
			$totalAmount = $order->paid_amount;
			
			$discountAmount = $order->getDiscountAmount($currency->discount_percentage, $totalAmount);

			$newTotal = $order->paid_amount - $discountAmount;

			$order->discount_percentage = $currency->discount_percentage;
			$order->discount_amount = $discountAmount;
			$order->paid_amount = $newTotal;
			$order->save();
		}
	}
	
	/**
	 * Handle the Order "updated" event.
	 *
	 * @param \App\Models\Order $order
	 * @return void
	 */
	public function updated(Order $order)
	{
		//
	}
	
	/**
	 * Handle the Order "deleted" event.
	 *
	 * @param \App\Models\Order $order
	 * @return void
	 */
	public function deleted(Order $order)
	{
		//
	}
	
	/**
	 * Handle the Order "restored" event.
	 *
	 * @param \App\Models\Order $order
	 * @return void
	 */
	public function restored(Order $order)
	{
		//
	}
	
	/**
	 * Handle the Order "force deleted" event.
	 *
	 * @param \App\Models\Order $order
	 * @return void
	 */
	public function forceDeleted(Order $order)
	{
		//
	}
}
