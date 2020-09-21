<form method="post" class="ajax-submit2" autocomplete="off" action="{{ route('awards.store') }}">
	@csrf
	
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Award') }}</label>
			<select class="form-control select2" name="types_of_award_id" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option('types_of_awards', 'id', 'title', old('types_of_award_id')) }}
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Employee') }}</label>
			<select class="form-control select2" name="user_id" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_employee_option() }}
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Gift Item') }}</label>
			<input type="text" name="gift_item" class="form-control" value="{{ old('gift_item') }}" required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Cash Price') }} ({{ get_option('currency_symbol') }})</label>
			<input type="number" name="cash_price" class="form-control" value="{{ old('cash_price') }}">
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Month And Year') }}</label>
			<input type="text" name="month_year" class="form-control monthpicker" value="{{ old('month_year') }}" required>
		</div>
	</div>

	<div class="col-md-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		</div>
	</div>
</form>


