@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Add New Transport')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-8">
				<form action="{{route('transports.store')}}" class="form-horizontal validate" method="POST">
					@csrf
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Road Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="road_name" value="{{ old('road_name') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Vehicle Serial No')}}</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="vehicle_id" required>
								<option value="">{{_lang('Select One') }}</option>
								{{ create_option('transport_vehicles','id','serial_number',old('vehicle_id')) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{!! _lang('Road Fare')." <b>".get_option('currency_symbol')."</b>" !!}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="road_fare" value="{{ old('road_fare') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Note')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="note" value="{{ old('note') }}">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">{{ _lang('Add Transport') }}</button>
						</div>
					</div>
				</form>
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection
