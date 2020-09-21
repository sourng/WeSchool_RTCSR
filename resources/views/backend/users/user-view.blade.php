<div class="col-md-12">
	<div class="card card-user">
		<div class="image">
			<img src="{{ asset('public/uploads/images') }}/background.jpg" alt="..."/>
		</div>
		<div class="content">
			<div class="author">
				<img class="avatar border-white" src="{{ asset('public/uploads/images/'.$data->image) }}" alt="..."/>
				<h4 class="title">{{$data->name}}<br />
					<small>{{$data->user_type}}</small>
				</h4>
			</div>
			<p class="description text-center">
				{{ $data->email }}</br>
				{{ $data->phone }}</br>
				<ul class="social-link">
					<li><a href="{{ $data->facebook }}"><i class="fa fa-facebook"></i></a></li>
					<li><a href="{{ $data->twitter }}"><i class="fa fa-twitter"></i></a></li>
					<li><a href="{{ $data->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
					<li><a href="{{ $data->google_plus }}"><i class="fa fa-google-plus"></i></a></li>
				</ul>
			</p>
		</div>
		<hr>
	</div>
</div>
