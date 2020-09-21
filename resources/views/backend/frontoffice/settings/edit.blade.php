@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Picklist') }}</div>

			<div class="panel-body">
			 <form method="post" class="validate" autocomplete="off" action="{{action('PicklistController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-12">
				  <div class="form-group">
						<label class="control-label">{{ _lang('Type') }}</label>	
						<select name="type" id="type" class="form-control select2" required>
						    <option value="">{{ _lang('Select Type') }}</option>
							<option>{{ _lang('Source') }}</option>
							<option>{{ _lang('Reference') }}</option>
							<option>{{ _lang('Purpose') }}</option>
							<option>{{ _lang('Complain') }}</option>
						</select>
				   </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Value') }}</label>						
					<input type="text" class="form-control" name="value" value="{{$picklist->value}}" required>
				 </div>
				</div>
				
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

@section('js-script')
<script>
$("#type").val("{{$picklist->type}}");
</script>
@stop

