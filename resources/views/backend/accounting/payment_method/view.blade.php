@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Payment Method') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Payment Method Name') }}</td><td>{{ $paymentmethod->name }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


