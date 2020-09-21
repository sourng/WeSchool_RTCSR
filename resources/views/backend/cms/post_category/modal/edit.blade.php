<form method="post" class="ajax-submit" autocomplete="off" action="{{action('PostCategoryController@update', $id)}}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
	
	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Category Name') }}</label>						
		<input type="text" class="form-control" name="category" value="{{ $postcategory->category }}" required>
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Note') }}</label>						
		<input type="text" class="form-control" name="note" value="{{ $postcategory->note }}">
	 </div>
	</div>

	<div class="col-md-12">
	 <div class="form-group">
		<label class="control-label">{{ _lang('Parent Category') }}</label>						
		<input type="text" class="form-control" name="parent_id" value="{{ $postcategory->parent_id }}">
	 </div>
	</div>

				
	<div class="form-group">
	  <div class="col-md-12">
		<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	  </div>
	</div>
</form>

