<!DOCTYPE html>
<?php
	$lang=substr(app()->getLocale(),0,2);
	$langs=app()->getLocale();
	// echo $langs;
?>
<html lang="{{ $lang }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		 <!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ isset($page) ? $page->content[0]->page_title : get_option('site_title') }}</title>
		<meta name="keywords" content="{{ isset($page) ? $page->content[0]->seo_meta_keywords : 'school' }}"/>
		<meta name="description" content="{{ isset($page) ? $page->content[0]->seo_meta_description : 'school website' }}"/>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{ asset('public/theme/default/css/bootstrap.min.css') }}"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{{ asset('public/theme/default/css/font-awesome.min.css') }}">
        <!-- OWL Carousle -->
		<link rel="stylesheet" href="{{ asset('public/theme/default/css/owl.carousel.css') }}">
	    <link rel="stylesheet" href="{{ asset('public/theme/default/css/owl.theme.default.min.css') }}">
	    <link rel="stylesheet" href="{{ asset('public/theme/default/css/animate.css') }}">
		
		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{{ asset('public/theme/default/css/style.css') }}"/>
		<link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@400;700&display=swap" rel="stylesheet">

        <style type="text/css">{{ get_option('custom_css') }}</style>		
		 
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
	    <!-- Header -->
		<header id="header" class="transparent-nav">
			<div class="container">			
				<!-- Navigation -->
				<nav role="navigation" class="navbar navbar-default mainmenu">
                <!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{url('/')}}">{{ get_option('site_title') }}</a>
					</div>
					<!-- Collection of nav links and other content for toggling -->
					<div id="navbarCollapse" class="collapse navbar-collapse">
						<ul id="fresponsive" class="nav navbar-nav dropdown navbar-right">
							{!! dropdown_navigation_menu("main_menu") !!}							
						</ul>
						<ul class="nav navbar-nav dropdown navbar-right">
							@php $locale = app()->getLocale(); @endphp
							<li class="dropdown">
								<a  href="#" role="button" data-toggle="dropdown">
									@switch($locale)
										@case('khmer')
										<img src="{{asset('flags/kh.png')}}" width="30px" height="20x"> Khmer
										@break
										{{-- @case('english')
										<img src="{{asset('flags/en.png')}}" width="30px" height="20x"> English --}}								
										@default
										<img src="{{asset('flags/en.png')}}" width="30px" height="20x"> English
									@endswitch
									
									<span class="dropdown-menu"></span>
								</a>
								
								<ul  class="dropdown-menu">
																	
									
									@switch($locale)
										@case('khmer')
										<li>
											<a  href="{{url('lang/english')}}" ><img src="{{asset('flags/en.png')}}" width="30px" height="20x"> English</a></li>
										@break
										{{-- @case('english')
										<img src="{{asset('flags/en.png')}}" width="30px" height="20x"> English --}}								
										@default
										
										<li><a  href="{{url('lang/khmer')}}"><img src="{{asset('flags/kh.png')}}" width="30px" height="20x"> Khmer</a></li>
										@endswitch
								</ul>
							</li>
						</ul>


						
					</div>
					

					

				</nav>
				<!-- /Navigation -->

			</div>
		</header>
		<!-- /Header -->
		
        @yield('content')
		

		<!-- Footer -->
		<footer id="footer" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- footer logo -->
					<div class="col-md-6">
						<div class="footer-logo">
							<a class="logo" href="index.html">
								<img src="{{ get_logo() }}" alt="logo">
							</a>
						</div>
					</div>
					<!-- footer logo -->

					<!-- footer nav -->
					<div class="col-md-6">
						<ul class="footer-nav">
							{!! dropdown_navigation_menu("footer_menu") !!}
						</ul>
					</div>
					<!-- /footer nav -->

				</div>
				<!-- /row -->

				<!-- row -->
				<div id="bottom-footer" class="row">

					<!-- social -->
					<div class="col-md-4 col-md-push-8">
						<ul class="footer-social">
							<li><a href="{{ get_option('facebook_link') }}" class="facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="{{ get_option('twitter_link') }}" class="twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="{{ get_option('google_plus_link') }}" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="{{ get_option('instagram_link') }}" class="instagram"><i class="fa fa-instagram"></i></a></li>
							<li><a href="{{ get_option('youtube_link') }}" class="youtube"><i class="fa fa-youtube"></i></a></li>
							<li><a href="{{ get_option('linkedin_link') }}" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>
					<!-- /social -->

					<!-- copyright -->
					<div class="col-md-8 col-md-pull-4">
						<div class="footer-copyright">
							<span>{!! get_option('copyright_text') !!}</span>
						</div>
					</div>
					<!-- /copyright -->

				</div>
				<!-- row -->

			</div>
			<!-- /container -->

		</footer>
		<!-- /Footer -->

		<!-- preloader -->
		<div id='preloader'><div class='preloader'></div></div>
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="{{ asset('public/theme/default/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('public/theme/default/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('public/theme/default/js/owl.carousel.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('public/theme/default/js/main.js') }}"></script>
        @yield('js-script')
		<script type="text/javascript">{!! get_option('custom_js') !!}</script>		
	</body>
</html>