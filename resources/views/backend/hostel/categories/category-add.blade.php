@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Add New Category')}}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{route('hostelcategories.store')}}" class="form-horizontal validate" method="POST">
						@csrf
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Hostel Name')}}</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="hostel_id" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option("hostels","id","hostel_name",old('hostel_id'))}}	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Standard')}}</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="standard" required>
									<option value="">{{ _lang('Select One') }}</option>	
									<option @if(old('standard')=='High End') selected @endif value="High End">High End</option>
									<option @if(old('standard')=='Medium') selected @endif value="Medium">Medium</option>
									<option @if(old('standard')=='Low End') selected @endif value="Low End">Low End</option>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{!! _lang('Hostel Fee')." <b>".get_option('currency_symbol')."</b>" !!}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="hostel_fee" value="{{ old('hostel_fee') }}" required>
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
								<button type="submit" class="btn btn-info">{{_lang('Add Category') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection
