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
					<li><a href="">{{ _lang('Home') }}</a></li>
					<li>{{ $page->content[0]->page_title }}</li>
				</ul>
				<h1 class="white-text">{{ $page->content[0]->page_title }}</h1>
			</div>
		</div>
	</div>

</div>
<!-- /Hero-area -->

<!-- Contact -->
<div id="contact" class="section">

	<!-- container -->
	<div class="container">

		<!-- row -->
		<div class="row">
            @if ($errors->any())
				<div class="alert alert-danger alert-dismissible">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<ul>
						@foreach ($errors->all() as $error)
							<li><i class="fa fa-window-close"></i> {{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			
			@if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			@endif
			<!-- contact form -->
			<div class="col-md-6">
				<div class="contact-form">
					<h4>{{ _lang('Send A Message') }}</h4>
					<form method="post" action="{{ url('contact/send_message') }}" autocomplete="off">
						{{ csrf_field() }}
						<input class="input" type="text" name="name" placeholder="Name" required>
						<input class="input" type="email" name="email" placeholder="Email" required>
						<input class="input" type="text" name="subject" placeholder="Subject" required>
						<textarea class="input" name="message" placeholder="Enter your Message" required></textarea>
						<button class="main-button icon-button pull-right">{{ _lang('Send Message') }}</button>
					</form>
				</div>
			</div>
			<!-- /contact form -->

			<!-- contact information -->
			<div class="col-md-5 col-md-offset-1">
				<h4>{{ _lang('Contact Information') }}</h4>
				<ul class="contact-details">
					<li><i class="fa fa-envelope"></i>{{ get_option('contact_email') }}</li>
					<li><i class="fa fa-phone"></i>{{ get_option('contact_phone') }}</li>
					<li><i class="fa fa-map-marker"></i>{{ get_option('contact_address') }}</li>
				</ul>

				<!-- contact map -->
				<div id="contact-map"></div>
				<!-- /contact map -->

			</div>
			<!-- contact information -->

		</div>
		<!-- /row -->

	</div>
	<!-- /container -->

</div>
<!-- /Contact -->

@endsection

@section('js-script')
<script type="text/javascript">
var latitude = {{ get_option('google_map_latitude') }};
var longitude = {{ get_option('google_map_longitude') }};
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key={{ get_option('google_map_api') }}"></script>
<script src="{{ asset('public/theme/default/js/google-map.js') }}"></script>
@endsection

