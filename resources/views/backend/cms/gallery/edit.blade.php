
@extends('layouts.backend')

@section('content')
<div class="row">
<form method="post" class="validate" autocomplete="off" action="{{action('PostController@update', $id)}}" enctype="multipart/form-data">	
	<div class="col-md-8">
	<div class="panel panel-default">
	<div class="panel-heading">
		<span class="panel-title">{{ _lang('Update Post') }}</span>
	</div>
	<div class="panel-body">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Post Title') }}</label>						
			<input type="text" class="form-control" name="post_title[]" value="{{ $post->content[0]->post_title }}" required>
		  </div>
		</div>

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Post Content') }}</label>						
			<textarea class="form-control summernote" name="post_content[]">{{ $post->content[0]->post_content }}</textarea>
		  </div>
		</div>
		
		<input type="hidden" name="post_content_id[]" value="{{ $post->content[0]->id }}">				
		<input type="hidden" name="post_type" value="post">	  
		<input type="hidden" name="language[]" value="english">	  

	
		<div class="form-group">
		  <div class="col-md-12">
			<button type="submit" class="btn btn-primary pull-right">{{ _lang('Update Post') }}</button>
		  </div>
		</div>

	</div>
  </div>
 </div><!--End Col-9-->
 
 <div class="col-md-4">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Post Setting') }}</div>

		<div class="panel-body">
		   <div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('URL Slug') }}</label>						
				<input type="text" class="form-control" name="slug" value="{{ $post->slug }}">
			  </div>
		   </div>
		   
		   <div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Post Status') }}</label>						
				<select class="form-control select2" name="post_status">
				   <option value="publish" {{ $post->post_status == "publish" ? "selected" : "" }}>{{ _lang('Publish') }}</option>
				   <option value="draft" {{ $post->post_status == "draft" ? "selected" : "" }}>{{ _lang('Draft') }}</option>
				</select>
			  </div>
			</div>
			
			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Post Category') }}</label>						
				<select class="form-control select2" id="post_category" name="post_category">
				   <option value="0">{{ _lang('Uncategorized ') }}</option>
				   {{ buildOptionTree("post_categories", 0) }}
				</select>
			  </div>
			</div>

			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Featured Image') }}</label>						
				<input type="file" class="dropify" name="featured_image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-show-remove="false" data-default-file="{{ asset('public/uploads/media/'.$post->featured_image) }}">
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
$("#post_category").val("{{ $post->category_id }}");
</script>
@endsection
