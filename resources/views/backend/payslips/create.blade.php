@extends('layouts.backend')

@section('content')
<h4 class="panel-title" style="display: none;">{{ _lang('Generate Payslip') }}</h4>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
				<form class="params-panel" autocomplete="off" action="{{ route('payslips.store') }}" method="post">
					@csrf
					<div class="col-md-3 col-md-offset-3">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Month And Year') }}</label>
							<input type="text" name="month_year" class="form-control monthpicker" value="{{old('month_year') }}" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button type="submit" style="margin-top:27px;" class="btn btn-success btn-block">{{_lang('Generate')}}</button>
						</div>
					</div>
				</form>
				@if($payslips != null)
				<header class="panel-heading">
					<span class="panel-title">{{ _lang('Generated Payslips') }}</span>
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
								<td>{{ $data->employee_name }}</td>
								<td>{{ $data->employee_id }}</td>
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
										<a href="{{ route('payslips.edit', $data->id) }}" class="btn btn-warning btn-xs" title="{{ _lang('Edit') }}">
											<i class="fa fa-pencil"></i>
										</a>
										@csrf
										@method('DELETE')
										<button class="btn btn-danger btn-xs btn-remove" type="submit">
											<i class="fa fa-eraser"></i>
										</button>
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

@section('js-script')
@if (! empty($success))
<script type="text/javascript">
	Command: toastr["success"]("{{ $success }}");
</script>
@endif
@stop



