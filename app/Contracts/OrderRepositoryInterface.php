<?php

namespace App\Contracts;

use App\Models\Currency;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
	/**
	 * @return Collection
	 */
	public function getOrders(): Collection;
	
	/**
	 * @param Currency $currency
	 * @param int $amount
	 * @return mixed
	 */
	public function createOrder(Currency $currency, int $amount);
}