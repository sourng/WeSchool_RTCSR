@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('View Notice') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td><h4>{{ $notice->heading }}</h4></td></tr>
		<tr><td class="details-td">{!! $notice->content !!}</td></tr>
		<tr><td>{{ _lang("Notice Can See Only") }} : {{ object_to_string($notice->user_type,'user_type') }}</td></tr>
			
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection


