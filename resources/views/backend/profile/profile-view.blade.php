@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Profile')}}
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tbody style="text-align: center;">
						<tr class="text-center">
							<td colspan="2"><img src="{{ asset('public/uploads/images/'.$profile->image) }}" style="width: 100px; border-radius: 5px"></td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Name') }}</td>
							<td>{{ $profile->name }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('User Type') }}</td>
							<td>{{ $profile->user_type }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Email') }}</td>
							<td>{{ $profile->email }}</td>
						</tr>
						<tr class="text-center">
							<td colspan="2">
								<ul class="social-link">
									<li><a href="{{ $profile->facebook }}"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{ $profile->twitter }}"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{ $profile->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="{{ $profile->google_plus }}"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection