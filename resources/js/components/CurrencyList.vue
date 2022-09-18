<template>
    <div class="container">
        <div class="row justify-content-center">
	
	        <select v-model="selectedCurrency" @change="getQuoteOption(selectedCurrency)">
		        <option disabled value="default">Please Select Currency</option>
		        <option v-for="currency in currencies" :value="currency.code">{{ currency.name }} [{{currency.code}}]</option>
	        </select>
			
	        <div v-if="showGetQuoteBtn" style="margin-top: 5px;">
		        <input  v-if="showGetQuoteBtn" type="text" placeholder="Type amount" v-model="selectedAmount">
		        <button @click="getQuote(selectedCurrency)">Get Quote</button>
	        </div>
	        
	        <div v-if="quote" style="display: block;max-width: 250px;border: 1px solid #000;padding: 10px;
   margin-top: 20px;">
		        <p>Currency: {{ quote.currency }}</p>
		        <p>Rate: {{ quote.rate }}</p>
		        <p>Amount: {{ quote.amount }}</p>
		        <hr>
		        <p><b>Total</b>: {{ quote.total_amount_usd }} USD</p>
		        
		        <button @click="placeOrder" style="margin-bottom: 15px">Order Now</button>
	        </div>
	        
	        <div v-if="loading">Working...</div>
	        <div ref="alert" style="background: green;color: white;max-width: 250px;padding: 11px;margin-top: 10px;">{{ serverMsg }}</div>
	        
        </div>
    </div>
</template>

<script>
    export default {
		data: () => {
			return {
				selectedCurrency: 'default',
				selectedAmount: '',
				showGetQuoteBtn: false,
				currencies: [],
				quote: null,
				loading: false,
				serverMsg: ''
			}
        },
        mounted() {
            this.fetchCurrencies();
        },
	    methods: {
			async fetchCurrencies() {
				axios.get('/api/v1/currencies')
					.then(res => {
						console.log(res);
						if(res.status === 200) {
							this.currencies = res.data.data;
						}
					})
			},
		    getQuoteOption() {
				this.selectedAmount = '';
				this.quote = null;
			    this.showGetQuoteBtn = true;
		    },
		    async getQuote() {
				axios.get('/api/v1/currencies/quote', {
					params: {
						'currency': this.selectedCurrency,
						'amount': this.selectedAmount
					}
				})
			    .then(res => {
					if(res.status === 200) {
						this.quote = res.data.data;
					}
			    })
		    },
		    async placeOrder() {
				this.loading = true;
				axios.post('/api/v1/orders', {
					'currency': this.selectedCurrency,
					'amount': this.selectedAmount
				})
				.then(res => {
					if(res.status === 201) {
						this.loading = false;
						this.serverMsg = res.data.message;
						this.$forceUpdate();
					}
					if(res.status === 500) {
						this.loading = false;
						this.serverMsg = res.data.message;
						this.$forceUpdate();
					}
				})
		    },
	    },
	    
    }
</script>
