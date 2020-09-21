@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Expene') }}</div>

			<div class="panel-body">
			<form method="post" class="validate" autocomplete="off" action="{{action('TransactionController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Trans Date') }}</label>						
					<input type="text" class="form-control datepicker" name="trans_date" value="{{ $transaction->trans_date }}" required>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Account') }}</label>
                    <select class="form-control select2" name="account_id" required>
						{{ create_option("bank_cash_accounts","id","account_name",$transaction->account_id) }}
					</select>					
				 </div>
				</div>


				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Amount')." ".get_option('currency_symbol') }}</label>						
					<input type="text" class="form-control float-field" name="amount" value="{{ $transaction->amount }}" required>
				 </div>
				</div>


				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Expene Type') }}</label>						
					<select class="form-control select2" name="chart_id" required>
						{{ create_option("chart_of_accounts","id","name",$transaction->chart_id,array("type="=>"expense")) }}
					</select>
				 </div>
				</div>
				
				<input type="hidden" name="trans_type" value="expense">
				<input type="hidden" name="dr_cr" value="dr">

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Payee') }}</label>	
                    <select class="form-control select2" name="payee_payer_id" required>
						{{ create_option("payee_payers","id","name",$transaction->payee_payer_id,array("type="=>"payee")) }}
					</select>					
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Payment Method') }}</label>						
					<select class="form-control select2" name="payment_method_id" required>
						{{ create_option("payment_methods","id","name",$transaction->payment_method_id) }}
					</select>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Reference') }}</label>						
					<input type="text" class="form-control" name="reference" value="{{ $transaction->reference }}">
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Attachment') }}</label>						
					<input type="file" class="form-control appsvan-file" data-value="{{ $transaction->attachment}}" name="attachment">
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Note') }}</label>						
					<textarea class="form-control" name="note">{{ $transaction->note }}</textarea>
				 </div>
				</div>

				
				<div class="col-md-12">
				  <div class="form-group">
					<button type="submit" class="btn btn-primary">{{ _lang('Update Expense') }}</button>
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection


