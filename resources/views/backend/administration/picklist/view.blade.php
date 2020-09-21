@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Picklist') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Type') }}</td><td>{{ $picklist->type }}</td></tr>
			<tr><td>{{ _lang('Value') }}</td><td>{{ $picklist->value }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


