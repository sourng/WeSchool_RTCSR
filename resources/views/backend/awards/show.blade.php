@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Details') }}
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td>{{ _lang('Award') }}</td>
							<td>{{ $award->award_type->title }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Employee Name') }}</td>
							<td>{{ $award->name }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Employee Id') }}</td>
							<td>{{ $award->employee_id }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Gift Item') }}</td>
							<td>{{ $award->gift_item }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Cash Price') }}</td>
							<td>
								{{ $award->cash_price != null ? get_option('currency_symbol') . $award->cash_price : '' }}
							</td>
						</tr>
						<tr>
							<td>{{ _lang('Month') }}</td>
							<td>{{ month_number_to_name($award->month) }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Year') }}</td>
							<td>{{ $award->year }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection