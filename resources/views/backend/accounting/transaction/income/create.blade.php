@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Income') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{ url('transactions') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="trans_date" value="{{ old('trans_date') }}" required>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Account') }}</label>						
			<select class="form-control select2" name="account_id" required>
				{{ create_option("bank_cash_accounts","id","account_name",old('account_id')) }}
			</select>
		  </div>
		</div>


		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Amount')." ".get_option('currency_symbol') }}</label>						
			<input type="text" class="form-control float-field" name="amount" value="{{ old('amount') }}" required>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Income Type') }}</label>						
			<select class="form-control select2" name="chart_id" required>
				{{ create_option("chart_of_accounts","id","name",old('chart_id'),array("type="=>"income")) }}
			</select>
		  </div>
		</div>
		
		<input type="hidden" name="trans_type" value="income">
		<input type="hidden" name="dr_cr" value="cr">

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Payer') }}</label>						
			<select class="form-control select2" name="payee_payer_id">
				{{ create_option("payee_payers","id","name",old('payee_payer_id'),array("type="=>"payer")) }}
			</select>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Payment Method') }}</label>						
			<select class="form-control select2" name="payment_method_id">
				{{ create_option("payment_methods","id","name",old('payment_method_id')) }}
			</select>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Reference') }}</label>						
			<input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Attachment') }}</label>						
			<input type="file" class="form-control appsvan-file" name="attachment" >
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ old('note') }}</textarea>
		  </div>
		</div>

				
		<div class="col-md-12">
		  <div class="form-group">
		    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save Income') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


