@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Add New Hostel')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-8">
				<form action="{{route('hostels.store')}}" class="form-horizontal validate" method="POST">
					@csrf
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Hostel Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="hostel_name" value="{{ old('hostel_name') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Type')}}</label>
						<div class="col-sm-9">
							<select name="type" class="form-control select2" required>
								<option value="">{{_lang('Select One') }}</option>
								<option @if(old('type')=='Boys') selected @endif value="Boys">{{_lang('Boys') }}</option>
								<option @if(old('type')=='Girls') selected @endif value="Girls">{{_lang('Girls') }}</option>
								<option @if(old('type')=='Combine') selected @endif value="Combine">{{_lang('Combine') }}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
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
							<button type="submit" class="btn btn-info">{{_lang('Add Hostel') }}</button>
						</div>
					</div>
				</form>
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection
