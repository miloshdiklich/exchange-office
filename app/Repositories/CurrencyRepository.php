<?php


namespace App\Repositories;


use App\Models\Currency;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use \App\Contracts\CurrencyRepositoryInterface;

class CurrencyRepository implements CurrencyRepositoryInterface
{
	/**
	 * @var Currency
	 */
	private Currency $currency;
	
	/**
	 * @var Order
	 */
	private Order $order;
	
	public function __construct(Currency $currency, Order $order)
	{
		$this->currency = $currency;
		$this->order = $order;
	}
	
	/**
	 * @param string $shortCode
	 * @return mixed
	 */
	public function getCurrency(string $shortCode)
	{
		return $this->currency
			->where('short_code', $shortCode)
			->first();
	}
	
	/**
	 * @param string $shortCode
	 * @param int $amount
	 * @return array|false
	 */
	public function getCurrencyQuote(string $shortCode, int $amount)
	{
		$currency = $this->getCurrency($shortCode);
		
		if(!$currency) return false;
		
		$totalAmount = $this->order->getCurrencyQuote($currency, $amount);
		
		return [
			'currency' => $shortCode,
			'amount' => $amount,
			'rate' => $currency->usd_exchange_rate,
			'total_amount_usd' => round($totalAmount,2)
		];
	}
	
	
	/**
	 * @return Collection
	 */
	public function getAllCurrencies(): Collection
	{
		return $this->currency->all();
	}
}