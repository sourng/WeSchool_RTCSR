@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Edit Category')}}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{route('hostelcategories.update',$category->id)}}" class="form-horizontal validate" method="POST">
						@csrf
						{{ method_field('PATCH') }}
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Hostel Name')}}</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="hostel_id" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option("hostels","id","hostel_name",$category->hostel_id)}}	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Standard')}}</label>
							<div class="col-sm-9">
								<select class="form-control select2" name="standard" required>
									<option value="">{{ _lang('Select One') }}</option>	
									<option @if($category->standard=='High End') selected @endif value="High End">High End</option>
									<option @if($category->standard=='Medium') selected @endif value="Medium">Medium</option>
									<option @if($category->standard=='Low End') selected @endif value="Low End">Low End</option>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{!! _lang('Hostel Fee')." <b>".get_option('currency_symbol')."</b>" !!}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="hostel_fee" value="{{ $category->hostel_fee }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Note')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="note" value="{{ $category->note }}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="submit" class="btn btn-info">{{_lang('Update Category') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection
