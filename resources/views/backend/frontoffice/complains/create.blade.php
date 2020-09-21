@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Complain') }}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('complains.store')}}" class="validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Complain Type') }}</label>						
							<select class="form-control select2" name="complain_type" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",old('complain_type'),array("type="=>"Complain")) }}	
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
							<label class="control-label">{{ _lang('Complain By') }}</label>	
							<input type="text" class="form-control" name="complain_by" value="{{ old('complain_by') }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Phone') }}</label>						
							<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
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
							<label class="control-label">{{ _lang('Date') }}</label>						
							<input type="text" class="form-control datepicker" name="date" value="{{ (old('date')) ? old('date') : Carbon\Carbon::now()->toDateString() }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Taken Action') }}</label>						
							<textarea class="form-control" name="taken_action">{{ old('taken_action') }}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Note') }}</label>						
							<textarea class="form-control" name="note">{{ old('note') }}</textarea>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{_lang('Attach Document')}}</label>
							<input type="file" class="form-control" name="attach_document">
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