@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Leave Applications List') }}</span>
				<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Apply Leave') }}" href="{{ route('leave_applications.create') }}">
					{{ _lang('Apply Leave') }}
				</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							
							<th>{{ _lang('Employee Name') }}</th>
							<th>{{ _lang('Employee Id') }}</th>
							<th>{{ _lang('Date') }}</th>
							<th>{{ _lang('Leave Type') }}</th>
							<th>{{ _lang('Absent Reason') }}</th>
							<th>{{ _lang('Status') }}</th>

							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($leave_applications as $data)
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
							<td>{{ date('D, jS F Y', strtotime($data->date)) }}</td>
							<td>{{ $data->leave_type->title }} ({{ $data->leave_type->off_type }})</td>
							<td>{{ $data->absent_reason }}</td>
							<td>
								@if ($data->status == 0)
								<span class="badge btn-warning ">{{ _lang('Pending') }}</span>
								@elseif($data->status == 1)
								<span class="badge btn-success">{{ _lang('Approved') }}</span>
								@elseif($data->status == 2)
								<span class="badge btn-danger">{{ _lang('Rejected') }}</span>
								@endif
							</td>

							<td class="text-center">
								<form action="{{ route('leave_applications.destroy', $data->id) }}" method="post" class="ajax-delete">
									@if ($data->status == 0)
									<a href="{{ url('leave_applications/status/' . $data->id . '/' . 1) }}" class="btn btn-success btn-xs" title="{{ _lang('Approve') }}">
										<i class="fa fa-check"></i>
									</a>
									<a href="{{ url('leave_applications/status/' . $data->id . '/' . 2) }}" class="btn btn-danger btn-xs" title="{{ _lang('Reject') }}">
										<i class="fa fa-times"></i>
									</a>
									@endif
									<a href="{{ route('leave_applications.show', $data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}">
										<i class="fa fa-eye"></i>
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
		</div>
	</div>
</div>

@endsection


