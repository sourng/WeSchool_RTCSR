@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Picklist') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('picklists')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<div class="col-md-12">
		  <div class="form-group">
			    <label class="control-label">{{ _lang('Type') }}</label>	
				<select name="type" class="form-control select2" required>
				    <option value="">{{ _lang('Select Type') }}</option>
					<option>{{ _lang('Source') }}</option>
					<option>{{ _lang('Reference') }}</option>
					<option>{{ _lang('Purpose') }}</option>
					<option>{{ _lang('Complain') }}</option>
				</select>
		   </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Value') }}</label>						
			<input type="text" class="form-control" name="value" value="{{ old('value') }}" required>
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


