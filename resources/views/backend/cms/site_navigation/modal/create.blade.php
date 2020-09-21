<form method="post" class="ajax-submit" autocomplete="off" action="{{route('site_navigations.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-12">
		<pre>main_menu and footer_menu is mandatory</pre>
	</div>
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Menu Name') }}</label>						
		<input type="text" class="form-control" name="menu_name" value="{{ old('menu_name') }}" required>
	  </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>
