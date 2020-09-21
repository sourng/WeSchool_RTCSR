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
						<td>{{ _lang('Employee Name') }}</td>
						<td>
							@if(isset($leave_application->employee->user))
							{{ $leave_application->employee->user->name }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Employee Id') }}</td>
						<td>
							@if(isset($leave_application->employee))
							{{ $leave_application->employee->employee_id }}
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Date') }}</td>
						<td>
							{{ date('D, jS F Y', strtotime($leave_application->date)) }}
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Leave Type') }}</td>
						<td>
							{{ $leave_application->leave_type->title }} ({{ $leave_application->leave_type->off_type }})
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Absent Reason') }}</td>
						<td>{{ $leave_application->absent_reason }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Status') }}</td>
						<td>
							@if ($leave_application->status == 0)
							<span class="badge btn-warning ">{{ _lang('Pending') }}</span>
							@elseif($leave_application->status == 1)
							<span class="badge btn-success">{{ _lang('Approved') }}</span>
							@elseif($leave_application->status == 2)
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


