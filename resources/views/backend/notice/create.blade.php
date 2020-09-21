@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('Add Notice') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('notices')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Heading') }}</label>						
			<input type="text" class="form-control" name="heading" value="{{ old('heading') }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Content') }}</label>						
			<textarea class="form-control summernote" name="content" required>{{ old('content') }}</textarea>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('User Type') }}</label>						
			<select class="form-control select2" name="user_type[]" multiple="multiple">		
				<option value="Website">{{ _lang('Website') }}</option>
				<option value="Student">{{ _lang('Student') }}</option>
				<option value="Parent">{{ _lang('Parent') }}</option>
				<option value="Teacher">{{ _lang('Teacher') }}</option>
				<option value="Accountant">{{ _lang('Accountant') }}</option>
				<option value="Librarian">{{ _lang('Librarian') }}</option>
				<option value="Employee">{{ _lang('Employee') }}</option>
				<option value="Admin">{{ _lang('Admin') }}</option>
		    </select>
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


