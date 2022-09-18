<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function (Blueprint $table) {
			$table->id();
			$table->string('name')->nullable();
			$table->string('short_code')->nullable();
			$table->decimal('usd_exchange_rate', 10, 6)->nullable();
			$table->unsignedTinyInteger('surcharge_percentage')->nullable();
			$table->unsignedTinyInteger('discount_percentage')->nullable();
			$table->timestamps();
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('currencies');
	}
}
