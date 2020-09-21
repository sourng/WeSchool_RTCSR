@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Edit Profile') }}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{ url('profile/update') }}" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Name') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="name" value="{{$profile->name}}" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Email') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="email" value="{{ $profile->email }}" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Phone') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="phone" value="{{ $profile->phone }}" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Image') }}</label>
							<div class="col-sm-9">
								<input type="file" class="form-control dropify" data-default-file="{{ asset('public/uploads/images/'.$profile->image) }}" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Facebook Link') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="facebook" value="{{ $profile->facebook }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Twitter Link') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="twitter" value="{{ $profile->twitter }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Linkedin Link') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="linkedin" value="{{ $profile->linkedin }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Google Plus Link') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="google_plus" value="{{ $profile->google_plus }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-info">{{ _lang('Update Profile') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection

