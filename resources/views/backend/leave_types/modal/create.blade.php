<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('leave_types.store') }}" enctype="multipart/form-data">
	@csrf
	
	<div class="col-md-12">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Title') }}</label>
			<input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Off Type') }}</label>
			<select class="form-control select2" name="off_type" required>
				<option value="Full Day">{{ _lang('Full Day') }}</option>
				<option value="Half Day">{{ _lang('Half Day') }}</option>
			</select>
		</div>
	</div>

	<div class="col-md-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		</div>
	</div>
</form>



