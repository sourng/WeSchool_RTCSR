@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Payslips')}}
				</div>
			</div>
			<div class="panel-body">
				<form class="params-panel" action="{{ route('payslips.index') }}" autocomplete="off" method="post">
					@csrf
					<div class="col-md-3 col-md-offset-3">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Month And Year') }}</label>
							<input type="text" name="month_year" class="form-control monthpicker" value="{{ $month_year }}" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button type="submit" style="margin-top:27px;" class="btn btn-success btn-block">
								{{_lang('Next')}}
							</button>
						</div>
					</div>
				</form>
				@if($payslips != null)
				<header class="panel-heading">
					<span class="panel-title">{{ _lang('Payslips List') }}</span>
				</header>
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
										<span class="label label-danger">{{ _lang('Unpaid') }}</span>
									@else
										<span class="label label-success">{{ _lang('Paid') }}</span>
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
				@endif
			</div>
		</div>
	</div>
</div>
@endsection


