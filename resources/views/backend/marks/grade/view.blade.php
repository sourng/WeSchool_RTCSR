@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Grade') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Grade Name') }}</td><td>{{ $grade->grade_name }}</td></tr>
			<tr><td>{{ _lang('Marks From') }}</td><td>{{ $grade->marks_from }}</td></tr>
			<tr><td>{{ _lang('Marks To') }}</td><td>{{ $grade->marks_to }}</td></tr>
			<tr><td>{{ _lang('Note') }}</td><td>{{ $grade->note }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


