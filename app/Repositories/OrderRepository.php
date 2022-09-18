<?php


namespace App\Repositories;


use Carbon\Carbon;
use App\Models\Order;
use App\Models\Currency;
use Illuminate\Support\Collection;
use \App\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
	/**
	 * @var Order
	 */
	private Order $order;
	
	public function __construct(Order $order)
	{
		$this->order = $order;
	}
	
	/**
	 * @return Collection
	 */
	public function getOrders(): Collection
	{
		return $this->order->all();
	}
	
	/**
	 * @param Currency $currency
	 * @param int $amount
	 * @return false|object
	 */
	public function createOrder(Currency $currency, int $amount)
	{
		$order = new $this->order;
		$order = $this->fillOrderObject($order, $currency, $amount);
		
		return $order->save() ? $order : false;
	}
	
	/**
	 * @param object $object
	 * @param Currency $currency
	 * @param int $amount
	 * @return object
	 */
	private function fillOrderObject(object $object, Currency $currency, int $amount): object
	{
		$baseTotal = $this->order->getBaseAmount($currency, $amount);
		$surchargeAmount = $this->order->getSurchargeAmount($currency->surcharge_percentage, $baseTotal);
		$totalAmount = $baseTotal + $surchargeAmount;
		
		$object->currency_purchased = $currency->short_code;
		$object->purchased_amount = $amount;
		$object->exchange_rate = $currency->usd_exchange_rate;
		$object->surcharge_percentage = $currency->surcharge_percentage;
		$object->surcharge_amount = round($surchargeAmount, 2);
		$object->paid_amount = round($totalAmount, 2);
		
		$object->created_date = Carbon::now()->format('Y-m-d');
		
		return $object;
	}
}