@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Types Of Awards List') }}</span>
				<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add New') }}" href="{{ route('types_of_awards.create') }}">
					{{ _lang('Add New') }}
				</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							
        					<th>{{ _lang('Title') }}</th>
        					<th>{{ _lang('Status') }}</th>

							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($types_of_awards as $data)
						<tr id="row_{{ $data->id }}">
							<td>{{ $i }}</td>
							
        					<td class="title">{{ $data->title }}</td>
        					<td class="status">{{ $data->status }}</td>

							<td class="action text-center">
								<form action="{{ route('types_of_awards.destroy', $data->id) }}" method="post" class="ajax-delete">
									<a href="{{ route('types_of_awards.edit', $data->id) }}" class="btn btn-warning btn-xs ajax-modal" data-title="{{ _lang('Edit') }}">
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
		</div>
	</div>
</div>

@endsection


