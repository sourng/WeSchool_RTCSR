@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Grade') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('grades')}}" enctype="multipart/form-data">
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
			<input type="text" class="form-control" name="marks_from" value="{{ old('marks_from') }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Marks To') }}</label>						
			<input type="text" class="form-control" name="marks_to" value="{{ old('marks_to') }}" required>
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

				
		<div class="form-group">
		  <div class="col-md-12">
		    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


