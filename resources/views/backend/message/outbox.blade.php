@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Send Items')}}
				</span>
				<a href="{{ url('message/compose') }}" class="btn btn-primary btn-sm pull-right">{{_lang('New Message')}}</a>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered">
					<thead>
						<th>{{ _lang('Date') }}</th>
						<th>{{ _lang('Receiver') }}</th>
						<th>{{ _lang('Subject') }}</th>
						<th>{{ _lang('View') }}</th>
					</thead>
					<tbody>
						@foreach($messages as $data)
						<tr>
							<td>{{ date('d/M/Y - H:m', strtotime($data->date)) }}</td>
							<td>{{ $data->receiver }}</td>
							<td>{{ $data->subject }}</td>
							<td><a href="{{ url('message/outbox/'.$data->id) }}" data-title="{{ _lang('View Message') }}" class="btn btn-primary btn-sm ajax-modal">{{ _lang('View') }}</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				<div class="pull-right">
					{{ $messages->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
