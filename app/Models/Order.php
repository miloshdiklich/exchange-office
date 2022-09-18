<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
	use HasFactory, Notifiable;
	
	public $timestamps = false;
	
	/**
	 * @param $currency
	 * @param $amount
	 * @return float|int
	 */
	public function getBaseAmount($currency, $amount)
	{
		return $amount / $currency->usd_exchange_rate;
	}
	
	/**
	 * @param $surchargePerc
	 * @param $baseTotal
	 * @return float|int
	 */
	public function getSurchargeAmount($surchargePerc, $baseTotal)
	{
		return ($surchargePerc/100) * $baseTotal;
	}
	
	/**
	 * @param $discountPerc
	 * @param $total
	 * @return float|int
	 */
	public function getDiscountAmount($discountPerc, $total)
	{
		return ($discountPerc/100) * $total;
	}
	
	/**
	 * @param $currency
	 * @param $amount
	 * @return float|int
	 */
	public function getCurrencyQuote($currency, $amount)
	{
		$baseTotal = $this->getBaseAmount($currency, $amount);
		$surchargeAmount = $this->getSurchargeAmount($currency->surcharge_percentage, $baseTotal);
		
		return $baseTotal + $surchargeAmount;
	}
	
}
