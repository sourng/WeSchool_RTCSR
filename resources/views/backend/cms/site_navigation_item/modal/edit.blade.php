<form method="post" class="ajax-submit" autocomplete="off" action="{{action('NavigationItemController@update', $id)}}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
						
	<input type="hidden" name="navigation_id" value="{{ $navigationitem->navigation_id }}" required>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Menu Label') }}</label>						
		<input type="text" class="form-control" name="menu_label" value="{{ $navigationitem->menu_label }}" required>
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Link') }}</label>						
		<input type="text" class="form-control" name="link" value="{{ $navigationitem->link }}">
	 </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Select Page') }}</label>						
		<select class="form-control select2" name="page_id">
		   <option value="">{{ _lang('Select One') }}</option>
		     @foreach($pages as $page)
				<option value="{{ $page->id }}" {{ $navigationitem->page_id==$page->id ? "selected" : "" }}>{{ $page->content[0]->page_title }}</option>
			 @endforeach
		</select>
	  </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Parent Menu') }}</label>						
		<select class="form-control select2" name="parent_id">
		   <option value="">{{ _lang('Select One') }}</option>
		   {{ create_option("site_navigation_items","id","menu_label",$navigationitem->parent_id,array("id !=" =>$navigationitem->id, "AND IFNULL(parent_id,0) !="=>$navigationitem->id, "AND navigation_id="=>$navigationitem->navigation_id)) }}
		</select>
	 </div>
	</div>

				
	<div class="form-group">
	  <div class="col-md-12">
		<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button> 	
	  </div>
	</div>
</form>