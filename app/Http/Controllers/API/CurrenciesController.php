<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Http\Resources\CurrencyResource;
use Illuminate\Support\Facades\Validator;
use App\Contracts\CurrencyRepositoryInterface;

class CurrenciesController extends ApiController
{
	/**
	 * @var CurrencyRepositoryInterface
	 */
	private CurrencyRepositoryInterface $currencyRepository;
	
	public function __construct(CurrencyRepositoryInterface $currencyRepository)
	{
		$this->currencyRepository = $currencyRepository;
	}
	
	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getCurrencyQuote(Request $request): JsonResponse
	{
		$data = [
			'currency' => $request->input('currency'),
			'amount' => $request->input('amount'),
		];
		
		$validator = Validator::make($data, [
			'currency' => 'required',
			'amount' => 'required|numeric'
		]);
		
		if( $validator->fails() )
			return $this->respondValidationError($validator->errors());
		
		$quote = $this->currencyRepository
			->getCurrencyQuote($data['currency'], $data['amount']);
		
		if( !$quote )
			return $this->respondNotFound('Currency not found.');
		
		return $this->respondSuccess($quote);
	}
	
	/**
	 * @return JsonResponse
	 */
	public function getAvailableCurrencies(): JsonResponse
	{
		$currencies = $this->currencyRepository->getAllCurrencies();
		$currencies = CurrencyResource::collection($currencies);
		
		if(!$currencies) return $this->respondInternalError();
		
		return $this->respondSuccess($currencies);
	}
}
