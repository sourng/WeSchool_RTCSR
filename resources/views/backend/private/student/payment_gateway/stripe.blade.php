<style>
.stripe-button-el{width: 100% !important;}
</style>
<h5 class="text-center">{{ _lang('Payable Amount') }} : ‎{{ get_option('stripe_currency')." ".($invoice->total-$invoice->paid) }}</h5>
<form action="{{ url('student/stripe_payment/'.$invoice->id) }}" method="POST">
	{{ csrf_field() }}
	<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="{{ get_option('stripe_publishable_key') }}"
		data-amount="{{ $invoice->total-$invoice->paid }}00"
		data-name="{{ $invoice->title }}"
		data-description="{{ $invoice->title }}"
		data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		data-locale="auto">
	</script>
</form>