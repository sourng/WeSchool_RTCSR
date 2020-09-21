@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Admission Enquiry') }}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('admission_enquiries.store')}}" class="validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('First Name') }}</label>	
							<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Last Name') }}</label>	
							<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Phone') }}</label>						
							<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Email') }}</label>						
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Address') }}</label>						
							<textarea class="form-control" name="address">{{ old('address') }}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Description') }}</label>						
							<textarea class="form-control" name="description">{{ old('description') }}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date') }}</label>						
							<input type="text" class="form-control datepicker" name="date" value="{{ old('date') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Next Follow Up Date') }}</label>						
							<input type="text" class="form-control datepicker" name="next_follow_up_date" value="{{ old('next_follow_up_date') }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Reference') }}</label>						
							<select class="form-control select2" name="reference">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",old('reference'),array("type="=>"Reference")) }}	
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Source') }}</label>						
							<select class="form-control select2" name="source" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",old('source'),array("type="=>"Source")) }}	
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Class') }}</label>						
							<select class="form-control select2" name="class_id">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Number Of Child') }}</label>						
							<input type="number" class="form-control" name="number_of_child" value="{{ old('number_of_child') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-info">{{ _lang('Save') }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection