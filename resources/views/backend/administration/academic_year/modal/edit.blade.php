<form method="post" class="ajax-submit" autocomplete="off" action="{{action('AcademicYearController@update', $id)}}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
	
	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Session Name') }}</label>						
		<input type="text" class="form-control" name="session" value="{{ $academicyear->session }}" required>
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Academic Year') }}</label>						
		<input type="text" class="form-control" name="year" value="{{ $academicyear->year }}" required>
	 </div>
	</div>

				
	<div class="form-group">
	  <div class="col-md-12">
		<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	  </div>
	</div>
</form>

