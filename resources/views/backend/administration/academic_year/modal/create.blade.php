<form method="post" class="ajax-submit" autocomplete="off" action="{{route('academic_years.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Session Name') }}</label>						
		<input type="text" class="form-control" name="session" value="{{ old('session') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Academic Year') }}</label>						
		<input type="text" class="form-control year" name="year" value="{{ old('year') }}" required>
	  </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>
