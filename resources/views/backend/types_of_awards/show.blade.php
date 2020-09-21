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
						<td>{{ $types_of_award->title }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Status') }}</td>
						<td>{{ $types_of_award->status }}</td>
					</tr>

				</table>
			</div>
		</div>
	</div>
</div>
@endsection


