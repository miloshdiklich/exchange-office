<?php

namespace Database\Seeders;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('currencies')->truncate();
		
		Currency::insert([
			[
				'name' => 'Japanese Yen',
				'short_code' => 'JPY',
				'usd_exchange_rate' => 107.17,
				'surcharge_percentage' => 7.5,
				'discount_percentage' => null,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'British Pound',
				'short_code' => 'GBP',
				'usd_exchange_rate' => 0.711178,
				'surcharge_percentage' => 5,
				'discount_percentage' => null,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Euro',
				'short_code' => 'EUR',
				'usd_exchange_rate' => 0.884872,
				'surcharge_percentage' => 5,
				'discount_percentage' => 2,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		]);
	}
}
