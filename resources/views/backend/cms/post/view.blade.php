@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('View Post') }}</div>

	<div class="panel-body">
	    <!--<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#english">{{ _lang('English') }}</a></li>
		  @foreach(get_table('website_languages') as $language)
			<li><a data-toggle="tab" href="#{{ $language->language }}">{{ $language->language }}</a></li>
		  @endforeach
		</ul>-->
		
		<div class="tab-content params-panel">
	
			<div id="english" class="tab-pane fade in active">
			  <table class="table table-bordered">
				<tr><td>{{ _lang('Featured Image') }}</td><td><img src="{{ $post->featured_image !="" ? asset('public/uploads/media/'.$post->featured_image) : asset('public/uploads/no_image.jpg') }}" style="max-width:200px;"></td></tr>
				<tr><td>{{ _lang('Category') }}</td><td>{{ isset($post->category->category) ? $post->category->category : _lang('Uncategorized ') }}</td></tr>
				<tr><td>{{ _lang('Title') }}</td><td>{{ $post->content[0]->post_title }}</td></tr>
				<tr><td>{{ _lang('Content') }}</td><td>{!! $post->content[0]->post_content !!}</td></tr>
				<tr><td>{{ _lang('Slug') }}</td><td>{{ $post->slug }}</td></tr>
				<tr><td>{{ _lang('Post Status') }}</td><td>{{ $post->post_status }}</td></tr>
				<tr><td>{{ _lang('Author') }}</td><td>{{ $post->author->name }}</td></tr>	
				<tr><td>{{ _lang('Author Type') }}</td><td>{{ $post->author->user_type }}</td></tr>	
			  </table>
			</div>  

		</div>  
		  
	</div>
  </div>
 </div>
</div>
@endsection


