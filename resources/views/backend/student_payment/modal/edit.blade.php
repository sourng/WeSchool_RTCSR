<form method="post" class="ajax-submit" autocomplete="off" action="{{action('StudentPaymentController@update', $id)}}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">										
	<input type="hidden" class="form-control" name="invoice_id" value="{{ $studentpayment->invoice_id }}" required>
	
	@php $currency = get_option('currency_symbol'); @endphp
	
	@if(!empty($history))
	<div class="col-md-12">	
		<table class="table table-bordered">
			<thead>
			   <th colspan="3" class="text-center">{{ _lang('Payment History') }}</th>
			</thead>
			<thead>
			   <th>{{ _lang('Date') }}</th>
			   <th>{{ _lang('Amount') }}</th>
			   <th>{{ _lang('Note') }}</th>
			</thead>
			<tbody>
			@foreach($history as $payment)
			   <tr>
			     <td>{{ $payment->date }}</td>
			     <td>{{ $currency." ".$payment->amount }}</td>
			     <td>{{ $payment->note }}</td>
			   </tr>
			@endforeach
			</tbody>
		</table>
	</div>	
	@endif

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Date') }}</label>						
		<input type="text" class="form-control datepicker" name="date" value="{{ $studentpayment->date }}" required>
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Amount')." ".$currency }}</label>						
		<input type="text" class="form-control" name="amount" value="{{ $studentpayment->amount }}" required>
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Note') }}</label>						
		<textarea class="form-control" name="note">{{ $studentpayment->note }}</textarea>
	 </div>
	</div>

				
	<div class="form-group">
	  <div class="col-md-12">
		<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	  </div>
	</div>
</form>

