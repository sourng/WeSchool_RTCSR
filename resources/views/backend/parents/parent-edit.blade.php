@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Update Parent')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-8">
				<form action="{{route('parents.update',$parent->id)}}" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Parent Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="parent_name" value="{{$parent->parent_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang("Father's Name")}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="f_name" value="{{$parent->f_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang("Mother's Name")}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="m_name" value="{{$parent->m_name}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang("Father's Profession")}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="f_profession" value="{{$parent->f_profession}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang("Mother's Profession")}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="m_profession" value="{{$parent->m_profession}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Phone')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="phone" value="{{$parent->phone}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="address">{{$parent->address}}</textarea>
						</div>
					</div>
					
					<hr>
					<div class="page-header">
					  <h4>Login Details</h4>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Email')}}</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="{{$parent->email}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Confirm Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Profile Picture')}}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control dropify" name="image" data-default-file="{{ asset('public/uploads/images/'.$parent->image) }}" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">Update Parent</button>
						</div>
					</div>
				</form>
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection
