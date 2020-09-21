@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading title">{{ _lang('Add New Language') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{ url('languages') }}">
		{{ csrf_field() }}
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Language Name') }}</label>						
			<input type="text" class="form-control" name="language_name" value="{{ old('language_name') }}" required>
		  </div>
		</div>

		
		<div class="form-group">
		  <div class="col-md-12">
			<button type="submit" class="btn btn-primary">{{ _lang('Create Language') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


