@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Post Category') }}</div>

	<div class="panel-body">
	  <form method="post" autocomplete="off" action="{{url('post_categories')}}" enctype="multipart/form-data">
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
			<select class="form-control select2" name="parent_id" id="parent_id">
			   <option value="">{{ _lang('Select One') }}</option>
			   {{ buildOptionTree("post_categories", 0) }}
			</select>
		  </div>
		</div>

		<input type="hidden" value="post" name="type">		
		
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