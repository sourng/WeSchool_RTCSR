@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Departments List') }}</span>
				<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add New') }}" href="{{ route('departments.create') }}">
					{{ _lang('Add New') }}
				</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							
        					<th>{{ _lang('Department') }}</th>
        					<th>{{ _lang('Designations') }}</th>
        					<th>{{ _lang('Status') }}</th>

							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($departments as $data)
						<tr id="row_{{ $data->id }}">
							<td>{{ $data->id }}</td>
							
        					<td class="department">{{ $data->department }}</td>
        					<td class="designation">
        						<ul>
        						@foreach (get_table2('designations', ['department_id' => $data->id], 'ASC') as $designation)
        							<li>{{ $designation->designation }}</li>
        						@endforeach
        						</ul>
        					</td>
        					<td>
								@if ($data->status != 'Active')
									<span class="badge btn-danger">{{ _lang('In-Active') }}</span>
								@else
									<span class="badge btn-success">{{ _lang('Active') }}</span>
								@endif
							</td>

							<td class="text-center action">
								<form action="{{ route('departments.destroy', $data->id) }}" method="post" class="ajax-delete">
									<a href="{{ route('departments.show', $data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}">
										<i class="fa fa-eye"></i>
									</a>
									<a href="{{ route('departments.edit', $data->id) }}" class="btn btn-warning btn-xs ajax-modal" data-title="{{ _lang('Edit') }}">
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
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection


