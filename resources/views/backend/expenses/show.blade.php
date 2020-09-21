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
						<td>{{ _lang('Name') }}</td>
						<td>{{ $expense->name }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Purchase From') }}</td>
						<td>{{ $expense->purchase_from }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Date') }}</td>
						<td>{{ date('d F Y', strtotime($expense->date)) }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Amount') }}</td>
						<td>{{ get_option('currency_symbol') }}{{ $expense->amount }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Bill') }}</td>
						<td>
							@if ($expense->bill != null)
							<a href="{{ asset('public/uploads/' . $expense->bill) }}" class="btn btn-default btn-xs" title="{{ _lang('Download') }}" target="_blank">
								<i class="fa fa-download"></i>
							</a>
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Employee Name') }}</td>
						<td>
							@if(isset($expense->employee))
							{{ $expense->employee->user->name }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Employee Id') }}</td>
						<td>
							@if(isset($expense->employee))
							{{ $expense->employee->employee_id }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Status') }}</td>
						<td>
							@if ($expense->status == 0)
							<span class="badge btn-warning ">{{ _lang('Pending') }}</span>
							@elseif($expense->status == 1)
							<span class="badge btn-success">{{ _lang('Approved') }}</span>
							@elseif($expense->status == 2)
							<span class="badge btn-danger">{{ _lang('Rejected') }}</span>
							@endif
						</td>
					</tr>

				</table>
			</div>
		</div>
	</div>
</div>
@endsection


