<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCurrencyRatesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CurrencyUpdateRatesCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'currency:update-rates';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update currencies rates using Apilayer.com service';
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		try {
			UpdateCurrencyRatesJob::dispatch();
			$this->line('Update successful.');
		}
		catch (\Exception $e) {
			Log::error($e->getMessage());
		}
		
		return 1;
	}
}
