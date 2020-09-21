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
					<li>{{ _lang('Faculty') }}</li>
				</ul>
				<h1 class="white-text">{{ $page->content[0]->page_title }}</h1>
			</div>
		</div>
	</div>
</div>
<!-- /Hero-area -->

<!-- Teachers -->
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
					$users = App\User::where("user_type","!=","Student")
									  ->where("user_type","!=","Parent")
									  ->where("user_type","!=","Admin")
									  ->orderBy("user_type","desc")
					                  ->paginate(12); 
					@endphp
					
					@foreach($users as $user)
					<div class="col-md-4 col-sm-6">
						<div class="our-team">
							<div class="team_img">
								<img src="{{ asset('public/uploads/images/'.$user->image) }}">
								<ul class="social">
									<li><a href="{{ $user->facebook =="" ? "#" : $user->facebook }}"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{ $user->twitter =="" ? "#" : $user->twitter }}"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{ $user->linkedin =="" ? "#" : $user->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="{{ $user->google_plus =="" ? "#" : $user->google_plus }}"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
							<div class="team-content">
								<h3 class="title">{{ $user->name }}</h3>
								<span class="post">{{ $user->user_type }}</span>
							</div>
						</div>
					</div>
					@endforeach
		 
				</div>		
				<!-- /row -->

				<!-- row -->
				<div class="row">

					<!-- pagination -->
					<div class="col-md-12">
						{{ $users->links(theme().'.pagination.default') }}
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
<!-- /Teachers -->

@endsection