@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Permission Role') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Role Name') }}</td><td>{{ $role->role_name }}</td></tr>
			<tr><td>{{ _lang('Note') }}</td><td>{{ $role->note }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


