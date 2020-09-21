@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Update User') }}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-8">
				<form action="{{route('users.update',$data->id)}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Name') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Email') }}</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="{{ $data->email }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Phone') }}</label>
						<div class="col-sm-9">
							<input type="phone" class="form-control" name="phone" value="{{ $data->phone }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Password') }}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Confirm Password') }}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('User Type') }}</label>
						<div class="col-sm-9">
							<select name="user_type" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option @if($data->user_type=='Admin') selected @endif value="Admin">{{ _lang('Admin') }}</option>
								<option @if($data->user_type=='Accountant') selected @endif value="Accountant">{{ _lang('Accountant') }}</option>
								<option @if($data->user_type=='Librarian') selected @endif value="Librarian">{{ _lang('Librarian') }}</option>
								<option @if($data->user_type=='Employee') selected @endif value="Employee">{{ _lang('Employee') }}</option>
							    <option @if($data->user_type=='Teacher') selected @endif value="Teacher" >{{ _lang('Teacher') }}</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Permission Role') }}</label>
						<div class="col-sm-9">
							<select name="role_id" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option value="0" {{ $data->role_id==0 ? "selected" : "" }}>{{ _lang('Default') }}</option>
								{{ create_option("permission_roles","id","role_name",$data->role_id) }}
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Profile') }}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control dropify" name="image" data-default-file="{{ asset('public/uploads/images/'.$data->image) }}" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
						</div>
					</div>
										
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Facebook Link') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="facebook" value="{{ $data->facebook }}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Twitter Link') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="twitter" value="{{ $data->twitter }}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Linkedin Link') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="linkedin" value="{{ $data->linkedin }}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Google Plus Link') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="google_plus" value="{{ $data->google_plus }}">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">{{ _lang('Update User') }}</button>
						</div>
					</div>
				</form>
			  </div>	
			</div>
		</div>
	</div>
</div>
@endsection