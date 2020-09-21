@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add New Event') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('events')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Start Date') }}</label>						
			<input type="text" class="form-control datetimepicker" name="start_date" value="{{ old('start_date') }}" required>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('End Date') }}</label>						
			<input type="text" class="form-control datetimepicker" name="end_date" value="{{ old('end_date') }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>						
			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Details') }}</label>						
			<textarea class="form-control summernote" name="details" required>{{ old('details') }}</textarea>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Location') }}</label>						
			<input type="text" class="form-control" name="location" value="{{ old('location') }}" required>
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


