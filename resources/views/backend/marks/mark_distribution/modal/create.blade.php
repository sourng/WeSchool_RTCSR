<form method="post" class="ajax-submit" autocomplete="off" action="{{route('mark_distributions.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Mark Distribution Type') }}</label>						
		<input type="text" class="form-control" name="mark_distribution_type" value="{{ old('mark_distribution_type') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Mark Percentage') }}</label>						
		<input type="text" class="form-control float-field" name="mark_percentage" value="{{ old('mark_percentage') }}" required>
	  </div>
	</div>
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Active') }}</label>						
		<select class="form-control" name="is_active" required>
		   <option value="yes">Yes</option>
		   <option value="no">No</option>
		</select>
	  </div>
	</div>
				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>
