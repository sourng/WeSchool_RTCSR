
@extends('layouts.backend')

@section('content')
<div class="row">
<form method="post" class="validate" autocomplete="off" action="{{action('PageController@update', $id)}}" enctype="multipart/form-data">	
	<div class="col-md-8">
	<div class="panel panel-default">
	<div class="panel-heading">
		<span class="panel-title">{{ _lang('Update Page') }}</span>
	</div>
	<div class="panel-body">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Page Title') }}</label>						
			<input type="text" class="form-control" name="page_title[]" value="{{ $page->content[0]->page_title }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Page Content') }}</label>						
			<textarea class="form-control summernote" name="page_content[]">{{ $page->content[0]->page_content }}</textarea>
		  </div>
		</div>
		
		<input type="hidden" name="page_content_id[]" value="{{ $page->content[0]->id }}">				  
		<input type="hidden" name="language[]" value="english">	  
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Seo Meta Keywords') }}</label>						
			<textarea class="form-control" name="seo_meta_keywords[]">{{ $page->content[0]->seo_meta_keywords }}</textarea>
		  </div>
		</div>
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Seo Meta Description') }}</label>						
			<textarea class="form-control" name="seo_meta_description[]">{{ $page->content[0]->seo_meta_description }}</textarea>
		  </div>
		</div>

	
		<div class="form-group">
		  <div class="col-md-12">
			<button type="submit" class="btn btn-primary pull-right">{{ _lang('Update Page') }}</button>
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
				<input type="text" class="form-control" name="slug" value="{{ $page->slug }}">
			  </div>
		   </div>
		   
		   <div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Page Status') }}</label>						
				<select class="form-control select2" name="page_status">
				   <option value="publish" {{ $page->page_status == "publish" ? "selected" : "" }}>{{ _lang('Publish') }}</option>
				   <option value="draft" {{ $page->page_status == "draft" ? "selected" : "" }}>{{ _lang('Draft') }}</option>
				</select>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Page Template') }}</label>						
				<select class="form-control select2" id="page_template" name="page_template">
				   <option value="default">{{ _lang('Default ') }}</option>  
				   {!! load_custom_template() !!}
				</select>
			  </div>
			</div>
			

			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Featured Image') }}</label>						
				<input type="file" class="dropify" name="featured_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-show-remove="false" data-default-file="{{ asset('public/uploads/media/'.$page->featured_image) }}">
			  </div>
			</div>
		</div>
	</div>
</div>	
 
 
 </form>
</div>
@endsection

@section('js-script')
<script>
$("#page_category").val("{{ $page->category_id }}");
$("#page_template").val("{{ $page->page_template }}");
</script>
@endsection
