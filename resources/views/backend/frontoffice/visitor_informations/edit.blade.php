@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Edit') }}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{ route('visitor_informations.update',$visitor_information->id) }}" class="validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					@method('PUT')
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Purpose') }}</label>						
							<select class="form-control select2" name="purpose" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",$visitor_information->purpose,array("type="=>"Purpose")) }}	
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Name') }}</label>	
							<input type="text" class="form-control" name="name" value="{{ $visitor_information->name }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Phone') }}</label>						
							<input type="text" class="form-control" name="phone" value="{{ $visitor_information->phone }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date') }}</label>						
							<input type="text" class="form-control datepicker" name="date" value="{{ $visitor_information->date }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('In Time') }}</label>						
							<input type="text" class="form-control timepicker" name="in_time" value="{{ $visitor_information->in_time }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Out Time') }}</label>						
							<input type="text" class="form-control timepicker" name="out_time" value="{{ $visitor_information->out_time }}">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Number Of Person') }}</label>						
							<input type="number" class="form-control" name="number_of_person" value="{{ $visitor_information->number_of_person }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Id Card') }}</label>						
							<input type="text" class="form-control" name="id_card" value="{{ $visitor_information->id_card }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{ _lang('Note') }}</label>						
							<textarea class="form-control" name="note">{{ $visitor_information->note }}</textarea>
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