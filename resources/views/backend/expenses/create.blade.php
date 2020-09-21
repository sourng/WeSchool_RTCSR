@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					{{ _lang('Add New') }}
				</h2>
			</header>
			<div class="panel-body">
				<form method="post" autocomplete="off" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Item Name') }}</label>
							<input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Purchase From') }}</label>
							<input type="text" name="purchase_from" class="form-control" value="{{ old('purchase_from') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
							<input type="text" name="amount" class="form-control" value="{{ old('amount') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Date') }}</label>
							<input type="text" name="date" class="form-control datepicker" value="{{ old('date') }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Attach Bill') }}</label>
							<input type="file" class="form-control dropify" name="bill" data-allowed-file-extensions="doc docx pdf">
						</div>
					</div>
					@if(Auth::user()->user_type == 'Admin')
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Expense By') }}</label>
								<select class="form-control select2" name="expense_by" required>
									<option>{{ _lang('Select One') }}</option>
									{{ create_employee_option(old('expense_by'), ['status' => 1]) }}
								</select>
							</div>
						</div>
					@endif
					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection



