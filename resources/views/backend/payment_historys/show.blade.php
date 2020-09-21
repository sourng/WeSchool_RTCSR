@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					{{ _lang('Details') }}
				</h2>
			</header>
			<div class="panel-body">
				<table class="table table-bordered">
					
					<tr>
						<td>{{ _lang('Date') }}</td>
						<td>{{ $payment_history->date }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Amount') }}</td>
						<td>{{ $payment_history->amount }}</td>
					</tr>

				</table>
			</div>
		</div>
	</div>
</div>
@endsection


