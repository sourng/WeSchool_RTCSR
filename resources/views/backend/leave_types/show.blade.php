@extends('layouts.backend')

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
						<td>{{ _lang('Title') }}</td>
						<td>{{ $leave_type->title }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Off Type') }}</td>
						<td>{{ $leave_type->off_type }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Status') }}</td>
						<td>{{ $leave_type->status }}</td>
					</tr>

				</table>
			</div>
		</div>
	</div>
</div>
@endsection


