<form method="post" class="ajax-submit" autocomplete="off" action="{{route('post_categories.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Category Name') }}</label>						
		<input type="text" class="form-control" name="category" value="{{ old('category') }}" required>
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Note') }}</label>						
		<input type="text" class="form-control" name="note" value="{{ old('note') }}">
	  </div>
	</div>

	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Parent Category') }}</label>						
		<select class="form-control" name="parent_id" id="parent_id">
		</select>
	  </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
	    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
		<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	  </div>
	</div>
</form>


<script type="text/javascript">
$(document).ready(function(){
	$('#parent_id').select2({
		placeholder: "{{ _lang('Select One') }}",

		ajax: {
			dataType: "json",
			url: "{{ url('post_categories/get_category') }}",
			delay: 400,
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function (data, page) {
			  return {
				results: data
			  };
			},
		}
    });
});
</script>
