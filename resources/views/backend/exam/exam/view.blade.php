@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Exam') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Name') }}</td><td>{{ $exam->name }}</td></tr>
		<tr><td>{{ _lang('Note') }}</td><td>{{ $exam->note }}</td></tr>		
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


