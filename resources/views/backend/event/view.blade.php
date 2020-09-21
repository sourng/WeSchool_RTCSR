@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Event') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		 <tr><td>{{ _lang('Start Date') }}</td><td>{{ date('d M, Y - H:i' ,strtotime($event->start_date)) }}</td></tr>
		 <tr><td>{{ _lang('End Date') }}</td><td>{{ date('d M, Y - H:i' ,strtotime($event->end_date)) }}</td></tr>
	     <tr><td>{{ _lang('Name') }}</td><td>{{ $event->name }}</td></tr>
	     <tr><td>{{ _lang('Details') }}</td><td>{!! $event->details !!}</td></tr>
	     <tr><td>{{ _lang('Location') }}</td><td>{{ $event->location }}</td></tr>
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


