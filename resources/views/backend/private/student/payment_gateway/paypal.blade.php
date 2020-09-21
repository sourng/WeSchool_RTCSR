<h5 class="text-center">{{ _lang('PayPal Charge') }} : ‎3.9%</h5>
<h5 class="text-center">{{ _lang('Payable Amount') }} : ‎{{ get_option('paypal_currency')." ".(((3.9 / 100)*($invoice->total-$invoice->paid))+($invoice->total-$invoice->paid)) }}</h5>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="{{ get_option('paypal_email') }}">
    <input type="hidden" name="item_name" value="{{ $invoice->title }}">
    <input type="hidden" name="item_number" value="{{ $invoice->id }}">
    <input type="hidden" name="amount" value="{{ ((3.9 / 100)*($invoice->total-$invoice->paid))+($invoice->total-$invoice->paid) }}">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="custom" value="{{ $invoice->id }}">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="{{ get_option('paypal_currency') }}">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
	
	<input type="hidden" name="return" value="{{ url('student/paypal/return') }}"/>
    <input type="hidden" name="cancel_return" value="{{ url('student/paypal/cancel') }}" />
    <!-- Where to send the PayPal IPN to. -->
    <input type="hidden" name="notify_url" value="{{ url('student/paypal_ipn') }}" />
	
    <input type="submit" name="submit" class="btn btn-primary btn-block" value="Pay Now" alt="PayPal - The safer, easier way to pay online.">
</form>