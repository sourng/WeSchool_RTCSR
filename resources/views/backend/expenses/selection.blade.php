<form method="post" class="ajax-submit2" autocomplete="off" action="{{ url('expenses/status/' . $expense->id . '/1') }}">
	@csrf

	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Account') }}</label>						
			<select class="form-control select2" name="account_id" required>
				{{ create_option("bank_cash_accounts","id","account_name",old('account_id')) }}
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Amount')." ".get_option('currency_symbol') }}</label>
			<input type="text" class="form-control float-field" name="amount" value="{{ $expense->amount }}" readonly required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Expense Type') }}</label>						
			<select class="form-control select2" name="chart_id" required>
				{{ create_option("chart_of_accounts","id","name",old('chart_id'),array("type="=>"expense")) }}
			</select>
		</div>
	</div>
	<input type="hidden" name="trans_type" value="expense">
	<input type="hidden" name="dr_cr" value="dr">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Payment Method') }}</label>						
			<select class="form-control select2" name="payment_method_id">
				{{ create_option("payment_methods","id","name",old('payment_method_id')) }}
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Reference') }}</label>						
			<input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ old('note') }}</textarea>
		</div>
	</div>

	<div class="col-md-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-success">{{ _lang('Pay Now') }}</button>
		</div>
	</div>
</form>