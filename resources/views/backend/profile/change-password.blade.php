@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Change Password') }}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{ url('profile/updatepassword') }}" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Old Password') }}</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="oldpassword" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('New Password') }}</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Confirm Password') }}</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-info">{{ _lang('Update Password') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection

