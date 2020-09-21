@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('Payslips') }}</span>
			</div>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>

							<th>{{ _lang('Employee Name') }}</th>
							<th>{{ _lang('Employee Id') }}</th>
							<th>{{ _lang('Month') }}</th>
							<th>{{ _lang('Year') }}</th>
							<th>{{ _lang('Net Salary') }}</th>
							<th>{{ _lang('Status') }}</th>

							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($payslips as $data)
						<tr>
							<td>{{ $i }}</td>
							<td>
								@if(isset($data->employee->user))
								{{ $data->employee->user->name }}
								@endif
							</td>
							<td>
								@if(isset($data->employee))
								{{ $data->employee->employee_id }}
								@endif
							</td>
							<td>{{ month_number_to_name($data->month) }}</td>
							<td>{{ $data->year }}</td>
							<td>{{ get_option('currency_symbol') }}{{ $data->net_salary }}</td>
							<td>
								@if ($data->status != 1)
								<span class="badge btn-danger">{{ _lang('Unpaid') }}</span>
								@else
								<span class="badge btn-success">{{ _lang('Paid') }}</span>
								@endif
							</td>
							<td class="text-center action">
								<form action="{{ route('payslips.destroy', $data->id) }}" method="post">
									<a href="{{ route('payslips.show', $data->id) }}" class="btn btn-info btn-xs" title="{{ _lang('Details') }}">
										<i class="fa fa-eye"></i>
									</a>
									@if($data->status == 0)
									<a href="{{ route('payslips.edit', $data->id) }}" class="btn btn-warning btn-xs" title="{{ _lang('Edit') }}">
										<i class="fa fa-pencil"></i>
									</a>
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-xs btn-remove" type="submit">
										<i class="fa fa-eraser"></i>
									</button>
									@endif
								</form>
							</td>
						</tr>
						@php $i++ @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection


