@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('View Page') }}</div>

	<div class="panel-body">
	
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Featured Image') }}</td><td><img src="{{ $page->featured_image !="" ? asset('public/uploads/media/'.$page->featured_image) : asset('public/uploads/no_image.jpg') }}" style="max-width:200px;"></td></tr>
		<tr><td>{{ _lang('Page Template') }}</td><td>{{ $page->page_template }}</td></tr>
		<tr><td>{{ _lang('Title') }}</td><td>{{ $page->content[0]->page_title }}</td></tr>
		<tr><td>{{ _lang('Content') }}</td><td>{!! $page->content[0]->page_content !!}</td></tr>
		<tr><td>{{ _lang('Slug') }}</td><td>{{ $page->slug }}</td></tr>
		<tr><td>{{ _lang('Post Status') }}</td><td>{{ $page->page_status }}</td></tr>
		<tr><td>{{ _lang('Author') }}</td><td>{{ $page->author->name }}</td></tr>	
		<tr><td>{{ _lang('Author Type') }}</td><td>{{ $page->author->user_type }}</td></tr>	
	  </table>
		  
	</div>
  </div>
 </div>
</div>
@endsection


