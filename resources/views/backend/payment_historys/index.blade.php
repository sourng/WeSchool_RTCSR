@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Payment Historys List') }}</span>
			</header>
			<div class="panel-body">
				<table class="table table-striped data-table">
					<thead>
						<tr>
							<th>#</th>
							
							<th>{{ _lang('Date') }}</th>
							<th>{{ _lang('Amount') }}</th>

							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($payment_historys as $data)
						<tr id="row_{{ $data->id }}">
							<td>{{ $i }}</td>
							
							<td class="date">{{ $data->date }}</td>
							<td class="amount">{{ $data->amount }}</td>

							<td class="text-center">
								<a href="{{ route('payment_historys.show', $data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}">
									<i class="fa fa-eye"></i>
								</a>
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


