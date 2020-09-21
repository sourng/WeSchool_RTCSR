<form method="post" class="ajax-submit" autocomplete="off" action="{{action('SiteNavigationController@update', $id)}}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
	
	<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Menu Name') }}</label>						
					<input type="text" class="form-control" name="menu_name" value="{{ $sitenavigation->menu_name }}" required>
				 </div>
				</div>

				
	<div class="form-group">
	  <div class="col-md-12">
		<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	  </div>
	</div>
</form>

