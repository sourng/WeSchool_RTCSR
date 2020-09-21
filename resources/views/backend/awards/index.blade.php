@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Awards List') }}</span>
				<a href="{{ route('awards.create') }}" class="btn btn-info btn-sm pull-right ajax-modal" data-title="{{ _lang('Add New') }}">{{ _lang('Add New') }}</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>#</th>
							
						<th>{{ _lang('Award') }}</th>
						<th>{{ _lang('Employee Name') }}</th>
						<th>{{ _lang('Employee Id') }}</th>
						<th>{{ _lang('Gift Item') }}</th>
						<th>{{ _lang('Cash Price') }}</th>
						<th>{{ _lang('Month') }}</th>
						<th>{{ _lang('Year') }}</th>

						<th class="text-center">{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($awards AS $data)
						<tr>
							<td>{{ $i }}</td>
							
							<td>
								@if (isset($data->award_type))
								{{ $data->award_type->title }}
								@endif
							</td>
							<td>{{ $data->name }}</td>
							<td>{{ $data->employee_id }}</td>
							<td>{{ $data->gift_item }}</td>
							<td>
								{{ $data->cash_price != null ? get_option('currency_symbol') . $data->cash_price : '' }}
							</td>
							<td>{{ month_number_to_name($data->month) }}</td>
							<td>{{ $data->year }}</td>
							
							<td class="text-center">	
								<form action="{{ route('awards.destroy', $data->id) }}" method="post" class="ajax-delete">
									<a href="{{ route('awards.show', $data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

									<a href="{{ route('awards.edit', $data->id) }}" class="btn btn-warning btn-xs ajax-modal" data-title="{{ _lang('Edit') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									@method('DELETE')
									@csrf
									<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
								</form>
							</td>
						</tr>
						@php $i++; @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>
@endsection