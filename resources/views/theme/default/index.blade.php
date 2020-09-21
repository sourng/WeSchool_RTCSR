<?php $langs=app()->getLocale(); ?>
@extends('theme.default.layout')

@section('content')

<!-- Home -->
<div id="home" class="hero-area">

	<!-- Backgound Image -->
	<div class="bg-image bg-parallax overlay" style="background-image:url({{ get_option('hero_image') =="" ? theme_asset_url('img/home-background.jpg') : asset('public/uploads/media/'.get_option('hero_image')) }})"></div>
	<!-- /Backgound Image -->

	<div class="home-wrapper">
		<div class="container">
		    @php $slider = unserialize(get_option('slider')); @endphp
			<div class="row owl-carousel owl-theme" id="slider">
				@if (!empty($slider))
					@for($i = 0; $i < count($slider['slider_heading']); $i++)
					<div class="col-md-8 slider-item">
						<h1 class="white-text slider-heading">{{ $slider['slider_heading'][$i] }}</h1>
						<p class="lead white-text slider-content">{{ $slider['slider_content'][$i] }}</p>
						{!! $slider['button_text'][$i] !="" ? '<a class="main-button icon-button" href="'.$slider['button_link'][$i].'">'.$slider['button_text'][$i].'</a>' : '' !!}
					</div>
					@endfor
				@endif
			</div>
		</div>
	</div>

</div>
<!-- /Home -->

<!-- About -->
<div id="about" class="section">

	<!-- container -->
	<div class="container">

		<!-- row -->
		<div class="row">

			<div class="col-md-12">
			
			    <div class="tab" role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#news" data-toggle="tab">{{ _lang('News') }}</a></li>
						<li><a href="#notice" data-toggle="tab">{{ _lang('Notice') }}</a></li>
						<li><a href="#event" data-toggle="tab">{{ _lang('Events') }}</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade in active" id="news">
							<ul class="news_tab">
							  @php $posts = get_posts(); @endphp
								@if(empty($posts))
									<h3>{{ _lang('No Records Found !') }}</h3>
								@endif  
							  @foreach($posts as $post)
							  @if ($post->content[0]->language==$langs)				  
							  						
								<li>
									<div class="media">
									<div class="media-left">
										<a class="news_img" href="{{ post_parmalink($post) }}">
										<img class="media-object" src="{{ $post->featured_image != "" ? asset('public/uploads/media/'.$post->featured_image) : asset('public/uploads/no_image.jpg') }}" alt="img">
										</a>
									</div>
									<div class="media-body">
									<a href="{{ post_parmalink($post) }}">{{ $post->content[0]->post_title }}</a>
									<p class="feed_date">{{ _lang('Posted On') }} {{ date('d-M-Y',strtotime($post->created_at)) }}</p>
									</div>
									</div>                    
								</li>
							  @endif
							  @endforeach
							</ul>
							<!--<a class="see_all" href="#">See All</a>-->
						</div>
						<div class="tab-pane fade" id="notice">
						   <ul class="news_tab">
						      @php $notices = get_notices(); @endphp
								@if(empty($notices))
									<h3>{{ _lang('No Records Found !') }}</h3>
								@endif
							  @foreach($notices as $notice)
							  <li>
								<div class="media">
								  <div class="media-body">
								   <a href="{{ url('notice/'.$notice->id) }}">{{ $notice->heading }}</a>
								   <p class="feed_date">{{ _lang('Posted On') }} {{ date('d-M-Y',strtotime($notice->created_at)) }}</p>
								  </div>
								</div>                    
							  </li>
							  @endforeach
							</ul>
						</div>
						<div class="tab-pane fade" id="event">
							<ul class="news_tab">
							  @php $events = get_events(); @endphp
								@if(empty($events))
									<h3>{{ _lang('No Records Found !') }}</h3>
								@endif
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
					</div>
				</div>

			</div>

		</div>
		<!-- row -->

	</div>
	<!-- container -->
</div>
<!-- /About -->

@if (! empty($page))
   {!! $page->content[0]->page_content !!}
@endif

@endsection