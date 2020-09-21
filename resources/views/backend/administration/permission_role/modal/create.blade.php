<form method="post" class="ajax-submit" autocomplete="off" action="{{route('permission_roles.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Role Name') }}</label>						
					<input type="text" class="form-control" name="role_name" value="{{ old('role_name') }}" required>
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
