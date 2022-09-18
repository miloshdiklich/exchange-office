<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Contracts\OrderRepositoryInterface;
use App\Contracts\CurrencyRepositoryInterface;

class OrdersController extends ApiController
{
	/**
	 * @var OrderRepositoryInterface
	 */
	private OrderRepositoryInterface $orderRepository;
	
	/**
	 * @var CurrencyRepositoryInterface
	 */
	private CurrencyRepositoryInterface $currencyRepository;
	
	public function __construct(
		OrderRepositoryInterface $orderRepository,
		CurrencyRepositoryInterface $currencyRepository
	)
	{
		$this->orderRepository = $orderRepository;
		$this->currencyRepository = $currencyRepository;
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public function postOrder(Request $request)
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
		
		$currency = $this->currencyRepository
			->getCurrency($data['currency']);
		
		if( !$currency ) return $this->respondNotFound('Currency not found.');
		
		$order = $this->orderRepository->createOrder($currency, $data['amount']);
		
		if( !$order )
			return $this->respondInternalError();
		
		return $this->respondCreated($order, 'Order created successfully.');
		
	}
}
