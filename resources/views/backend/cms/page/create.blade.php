@extends('layouts.backend')

@section('content')
<div class="row">
<form method="post" class="validate" autocomplete="off" action="{{url('pages')}}" enctype="multipart/form-data">
	<div class="col-md-8">
	<div class="panel panel-default">
	<div class="panel-heading">
		<span class="panel-title">{{ _lang('Add New Page') }}</span>
	</div>
	<div class="panel-body">
		{{ csrf_field() }}
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Page Title') }}</label>						
			<input type="text" class="form-control" name="page_title[]" value="{{ old('page_title.0') }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Page Content') }}</label>						
			<textarea class="form-control summernote" name="page_content[]">{{ old('page_content.0') }}</textarea>
		  </div>
		</div>
			  
		<input type="hidden" name="language[]" value="english">	  
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Seo Meta Keywords') }}</label>						
			<textarea class="form-control" name="seo_meta_keywords[]"></textarea>
		  </div>
		</div>
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Seo Meta Description') }}</label>						
			<textarea class="form-control" name="seo_meta_description[]"></textarea>
		  </div>
		</div>
	
	
		<div class="form-group">
		  <div class="col-md-12">
			<button type="submit" class="btn btn-primary pull-right">{{ _lang('Save Page') }}</button>
		  </div>
		</div>

	</div>
  </div>
 </div><!--End Col-9-->
 
 <div class="col-md-4">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Page Setting') }}</div>

		<div class="panel-body">
		   <div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('URL Slug') }}</label>						
				<input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
			  </div>
		   </div>
		   
		   <div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Page Status') }}</label>						
				<select class="form-control select2" name="page_status">
				   <option value="publish">{{ _lang('Publish') }}</option>
				   <option value="draft">{{ _lang('Draft') }}</option>
				</select>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Page Template') }}</label>						
				<select class="form-control select2" name="page_template">
				   <option value="default">{{ _lang('Default ') }}</option>  
				   {!! load_custom_template() !!}
				</select>
			  </div>
			</div>

			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Featured Image') }}</label>						
				<input type="file" class="dropify" name="featured_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
			  </div>
			</div>
		</div>
	</div>
</div>	
 
 
 </form>
</div>
@endsection


