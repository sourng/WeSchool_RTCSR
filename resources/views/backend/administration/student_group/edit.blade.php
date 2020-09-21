@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Student Group') }}</div>

			<div class="panel-body">
			 <form method="post" class="validate" autocomplete="off" action="{{action('StudentGroupController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Group Name') }}</label>						
					<input type="text" class="form-control" name="group_name" value="{{$studentgroup->group_name}}" required>
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


