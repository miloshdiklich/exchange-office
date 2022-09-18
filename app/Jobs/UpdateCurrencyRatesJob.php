<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Models\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateCurrencyRatesJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * @return int
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function handle()
	{
		$apiKey = app()->environment() == 'local' ?
			env('API_LAYER_KEY') :
			config('app.api_layer_key');
		
		$currencies = Currency::all(['short_code', 'usd_exchange_rate']);
		
		foreach($currencies as $currency) {
			$client = new Client([
				"headers" => [
					"Content-Type" => "text/plain",
					"apikey" => "$apiKey"
				]
			]);
			
			$response = $client->get("https://api.apilayer.com/currency_data/convert?to=$currency->short_code&from=USD&amount=1")
				->getBody();
			
			$response = json_decode($response, true);
			
			if( $response['success'] ) {
				$currency->usd_exchange_rate =  $response['result'];
				$currency->save();
			}
		}
		
		Log::info('Rates updated successfully.');
		
		return 1;
	}
}
