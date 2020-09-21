@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading">
			<span class="panel-title">{{ _lang('List Post') }}</span>
			<a class="btn btn-primary btn-sm pull-right" href="{{route('posts.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>{{ _lang('Image') }}</th>
				<th>{{ _lang('Date') }}</th>
				<th>{{ _lang('Title') }}</th>
				<th>{{ _lang('Content') }}</th>
				<th>{{ _lang('Post Status') }}</th>	
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($posts as $post)
			  <tr id="row_{{ $post->id }}">
				<td><img class="img-thumbnail post_image" src="{{ $post->featured_image != "" ? asset('public/uploads/media/'.$post->featured_image) : asset('public/uploads/no_image.jpg') }}"></td>
				<td>{{ date('d-M-Y'), strtotime($post->created_at) }}</td>	
				<td>{{ $post->content[0]->post_title }}</td>	
				<td>{{ substr(strip_tags($post->content[0]->post_content),0,200) }}</td>	
				<td>{{ ucwords($post->post_status) }}</td>	
				<td>
				  <form action="{{ action('PostController@destroy', $post['id']) }}" method="post">
					<a href="{{ action('PostController@edit', $post['id']) }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
					<a href="{{ action('PostController@show', $post['id']) }}" class="btn btn-info btn-sm">{{ _lang('View') }}</a>
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
				  </form>
				</td>
			  </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection


