@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('edit') }}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('admission_enquiries.update',$admission_enquiry->id) }}" class="validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					@method('PUT')
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('First Name') }}</label>	
							<input type="text" class="form-control" name="first_name" value="{{ $admission_enquiry->first_name }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Last Name') }}</label>	
							<input type="text" class="form-control" name="last_name" value="{{ $admission_enquiry->last_name }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Phone') }}</label>						
							<input type="text" class="form-control" name="phone" value="{{ $admission_enquiry->phone }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Email') }}</label>						
							<input type="email" class="form-control" name="email" value="{{ $admission_enquiry->email }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Address') }}</label>						
							<textarea class="form-control" name="address">{{ $admission_enquiry->address }}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Description') }}</label>						
							<textarea class="form-control" name="description">{{ $admission_enquiry->description }}</textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date') }}</label>						
							<input type="text" class="form-control datepicker" name="date" value="{{ $admission_enquiry->date }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Next Follow Up Date') }}</label>						
							<input type="text" class="form-control datepicker" name="next_follow_up_date" value="{{ $admission_enquiry->next_follow_up_date }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Reference') }}</label>						
							<select class="form-control select2" name="reference">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",$admission_enquiry->reference,array("type="=>"Reference")) }}	
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Source') }}</label>						
							<select class="form-control select2" name="source" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",$admission_enquiry->source,array("type="=>"Source")) }}	
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Class') }}</label>						
							<select class="form-control select2" name="class_id">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$admission_enquiry->class_id) }}
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Number Of Child') }}</label>						
							<input type="number" class="form-control" name="number_of_child" value="{{ $admission_enquiry->number_of_child }}">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-info">{{ _lang('Update') }}</button>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
@endsection