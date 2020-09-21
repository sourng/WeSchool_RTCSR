@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-6">
		<div class="panel panel-default">
		<div class="panel-heading">{{ _lang('Add Academic Year') }}</div>

		<div class="panel-body">
		  <form method="post" class="validate" autocomplete="off" action="{{url('academic_year')}}" enctype="multipart/form-data">
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


