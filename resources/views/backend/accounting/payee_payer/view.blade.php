@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Payee / Payer') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Name') }}</td><td>{{ $payeepayer->name }}</td></tr>
			<tr><td>{{ _lang('Type') }}</td><td>{{ $payeepayer->type }}</td></tr>
			<tr><td>{{ _lang('Note') }}</td><td>{{ $payeepayer->note }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


