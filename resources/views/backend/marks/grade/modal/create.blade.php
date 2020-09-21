<form method="post" class="ajax-submit" autocomplete="off" action="{{route('grades.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Grade Name') }}</label>						
		<input type="text" class="form-control" name="grade_name" value="{{ old('grade_name') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Marks From') }}</label>						
		<input type="text" class="form-control float-field" name="marks_from" value="{{ old('marks_from') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Marks To') }}</label>						
		<input type="text" class="form-control float-field" name="marks_to" value="{{ old('marks_to') }}" required>
	  </div>
	</div>
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Point') }}</label>						
		<input type="text" class="form-control float-field" name="point" value="{{ old('point') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Note') }}</label>						
		<textarea class="form-control" name="note">{{ old('note') }}</textarea>
	  </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>
