<h1>New Order Received - {{ date('d/m/Y', strtotime($order->created_date)) }}</h1>

<div>
	<p>
		<span>Currency: {{ $order->currency_purchased}}</span>
	</p>
	<p>
		<span>Amount Purchased: {{ $order->purchased_amount}}</span>
	</p>
	<p>
		<span>Rate: {{ $order->exchange_rate}}</span>
	</p>
	<p>
		<span>Surcharge Amount: {{ $order->surcharge_amount}}</span>
	</p>
	<p>
		<span>Surcharge Percentage: {{ $order->surcharge_percentage}}</span>
	</p>
	<p>
		<span>Paid Amount: USD {{ $order->paid_amount}}</span>
	</p>
</div>