<div class="panel panel-default">
<div class="panel-body">
  <table class="table table-bordered">
	 <tr><td>{{ _lang('Invoice Id') }}</td><td>{{ $studentpayment->invoice_id }}</td></tr>
	 <tr><td>{{ _lang('Date') }}</td><td>{{ date('d-M-Y', strtotime($studentpayment->date)) }}</td></tr>
	 <tr><td>{{ _lang('Amount') }}</td><td>{{ get_option('currency_symbol')." ".$studentpayment->amount }}</td></tr>
	 <tr><td>{{ _lang('Note') }}</td><td>{{ $studentpayment->note }}</td></tr>			
  </table>
</div>
</div>
