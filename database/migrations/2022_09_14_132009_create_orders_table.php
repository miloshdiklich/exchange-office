<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->string('currency_purchased')->nullable();
			$table->decimal('exchange_rate', 10, 6)->nullable();
			$table->unsignedTinyInteger('surcharge_percentage')->nullable();
			$table->unsignedInteger('surcharge_amount')->nullable();
			$table->unsignedInteger('purchased_amount')->nullable();
			$table->unsignedInteger('paid_amount')->nullable();
			$table->unsignedTinyInteger('discount_percentage')->nullable();
			$table->unsignedInteger('discount_amount')->nullable();
			
			$table->date('created_date');
		});
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('orders');
	}
}
