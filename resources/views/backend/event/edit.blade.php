@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Event') }}</div>

			<div class="panel-body">
			<form method="post" class="validate" autocomplete="off" action="{{action('EventController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Start Date') }}</label>						
					<input type="text" class="form-control datetimepicker" name="start_date" value="{{ $event->start_date }}" required>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('End Date') }}</label>						
					<input type="text" class="form-control datetimepicker" name="end_date" value="{{ $event->end_date }}" required>
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Name') }}</label>						
					<input type="text" class="form-control" name="name" value="{{ $event->name }}" required>
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Details') }}</label>						
					<textarea class="form-control summernote" name="details" required>{{ $event->details }}</textarea>
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Location') }}</label>						
					<input type="text" class="form-control" name="location" value="{{ $event->location }}" required>
				 </div>
				</div>

				
				<div class="form-group">
				  <div class="col-md-12">
					<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection


