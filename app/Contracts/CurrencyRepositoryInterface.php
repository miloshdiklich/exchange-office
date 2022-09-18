<?php

namespace App\Contracts;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface
{
	/**
	 * @param string $shortCode
	 * @return mixed
	 */
	public function getCurrency(string $shortCode);
	
	/**
	 * @return Collection
	 */
	public function getAllCurrencies(): Collection;
}