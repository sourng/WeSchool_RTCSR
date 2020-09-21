@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading panel-title">{{ _lang('Update Notice') }}</div>

			<div class="panel-body">
			<form method="post" class="validate" autocomplete="off" action="{{action('NoticeController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Heading') }}</label>						
					<input type="text" class="form-control" name="heading" value="{{ $notice->heading }}" required>
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Content') }}</label>						
					<textarea class="form-control summernote" name="content" required>{{ $notice->content }}</textarea>
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('User Type') }}</label>						
					<select class="form-control select2" name="user_type[]" id="user_type" multiple="multiple">		
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
					<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')

<script>
$("#user_type").val([{!! object_to_string($notice->user_type,'user_type',true) !!}]);

</script>
@endsection