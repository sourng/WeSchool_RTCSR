@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Expenses List') }}</span>
				<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add New') }}" href="{{ route('expenses.create') }}">
					{{ _lang('Add New') }}
				</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ _lang('Item Name') }}</th>
							<th>{{ _lang('Amount') }}</th>
							<th>{{ _lang('Date') }}</th>
							<th>{{ _lang('Status') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($expenses as $data)
						<tr>
							<td>{{ $i }}</td>
							
							<td>{{ $data->name }}</td>
							<td>{{ get_option('currency_symbol') }}{{ $data->amount }}</td>
							<td>{{ date('d F Y', strtotime($data->date)) }}</td>
							<td>
								@if ($data->status == 0)
								<span class="badge btn-warning ">{{ _lang('Pending') }}</span>
								@elseif($data->status == 1)
								<span class="badge btn-success">{{ _lang('Approved') }}</span>
								@elseif($data->status == 2)
								<span class="badge btn-danger">{{ _lang('Rejected') }}</span>
								@endif
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


