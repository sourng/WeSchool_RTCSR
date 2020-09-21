@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Mark Distribution') }}</div>

			<div class="panel-body">
			<form method="post" class="validate" autocomplete="off" action="{{action('MarkDistributionController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Mark Distribution Type') }}</label>						
					<input type="text" class="form-control" name="mark_distribution_type" value="{{$markdistribution->mark_distribution_type}}" readOnly="true">
				 </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Mark Percentage') }}</label>						
					<input type="text" class="form-control float-field" name="mark_percentage" value="{{$markdistribution->mark_percentage}}" required>
				 </div>
				</div>
				
				@if ( $markdistribution->is_exam=='no' )
	
				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Active') }}</label>						
					<select class="form-control" name="is_active" required>
					   <option value="yes" {{ $markdistribution->is_active=='yes' ? 'selected' : '' }}>Yes</option>
					   <option value="no" {{ $markdistribution->is_active=='no' ? 'selected' : '' }}>No</option>
					</select>
				  </div>
				</div>
				
				@endif;
				
				<div class="form-group">
				  <div class="col-md-12">
					<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection


