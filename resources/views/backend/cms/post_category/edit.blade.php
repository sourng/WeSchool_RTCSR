@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
			<span class="panel-title">{{ _lang('Update Post Category') }}</span>			
				<form action="{{action('PostCategoryController@destroy', $postcategory->id)}}" method="post">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button style="margin-top:-25px;" class="btn btn-danger pull-right btn-remove" type="submit"><i class="fa fa-trash"></i> {{ _lang('Delete') }}</button>
				</form>
			</div>
			<div class="panel-body">
			<form method="post" autocomplete="off" action="{{action('PostCategoryController@update', $id)}}" enctype="multipart/form-data">
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
					<select class="form-control select2" name="parent_id" id="parent_id">
					 <option value="">{{ _lang('Select One') }}</option>
					 {{ create_option("post_categories","id","category",$postcategory->parent_id,array("id !=" =>$postcategory->id, "AND IFNULL(parent_id,0) !="=>$postcategory->id)) }}
					</select>
				  </div>
				</div>

				<input type="hidden" value="post" name="type">	
				
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


