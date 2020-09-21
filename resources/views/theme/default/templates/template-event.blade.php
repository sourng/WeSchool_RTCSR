@extends('theme.default.layout')
@section('content')

<!-- Hero-area -->
<div class="hero-area section">

	<!-- Backgound Image -->
	<div class="bg-image bg-parallax overlay" style="background-image:url({{ theme_asset_url('img/page-background.jpg') }})"></div>
	<!-- /Backgound Image -->

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 text-center">
				<ul class="hero-area-tree">
					<li><a href="{{ url('/') }}">{{ _lang('Home') }}</a></li>
					<li>{{ $page->content[0]->page_title }}</li>
				</ul>
				<h1 class="white-text">{{ $page->content[0]->page_title }}</h1>
			</div>
		</div>
	</div>

</div>
<!-- /Hero-area -->

<!-- Blog -->
<div id="blog" class="section">

	<!-- container -->
	<div class="container">

		<!-- row -->
		<div class="row">

			<!-- main blog -->
			<div id="main" class="col-md-9">

				<!-- row -->
				<div class="row">
				
					@php 
					$events = \App\Event::orderBy("id","desc")
										  ->paginate(12); 
					@endphp

					<ul class="news_tab">
						@foreach($events as $event)
						  <li>
							<div class="media">
							  <div class="media-body">
							   <a href="{{ url('event/'.$event->id) }}">{{ $event->name }}</a>
							   </br><span>{{ _lang('Location')." : ".$event->location }}</span>
							   <p class="feed_date">
									{{ date('d/M/Y - H:i',strtotime($event->start_date)) }}
									- {{ date('d/M/Y - H:i',strtotime($event->end_date)) }}
							   </p>
							  </div>
							</div>                    
						  </li>
						@endforeach
					</ul>

				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row">

					<!-- pagination -->
					<div class="col-md-12">
						{{ $events->links(theme().'.pagination.default') }}
					</div>
					<!-- pagination -->

				</div>
				<!-- /row -->
			</div>
			<!-- /main blog -->

			<!-- aside blog -->
			<div id="aside" class="col-md-3">

				<!-- search widget -->
				<div class="widget search-widget">
					<form>
						<input class="input" type="text" name="search">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
				<!-- /search widget -->

				<!-- category widget -->
				<div class="widget category-widget">
					<h3>{{ _lang('Categories') }}</h3>
					{!! categoryTree(get_table('post_categories'), 0, '') !!}	
				</div>
				<!-- /category widget -->

				<!-- posts widget -->
				<div class="widget posts-widget">
					<h3>{{ _lang('Recents Posts') }}</h3>

					@foreach(get_posts(3) as $post)
					<!-- single posts -->
					<div class="single-post">
						<a class="single-post-img" href="{{ post_parmalink($post) }}">
							<img src="{{ $post->featured_image != "" ? asset('public/uploads/media/'.$post->featured_image) : asset('public/uploads/no_image.jpg') }}" alt="">
						</a>
						<a href="{{ post_parmalink($post) }}">{{ $post->content[0]->post_title }}</a>
						<p><small>{{ _lang('By') }} : {{ $post->author->name }} .{{ date('d M, Y',strtotime($post->created_at)) }}</small></p>
					</div>
					<!-- /single posts -->
                    @endforeach
				</div>
				<!-- /posts widget -->

			</div>
			<!-- /aside blog -->

		</div>
		<!-- row -->

	</div>
	<!-- container -->

</div>
<!-- /Blog -->

@endsection