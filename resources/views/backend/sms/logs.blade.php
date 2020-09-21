@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('SMS Log')}}
				</span>
				<a href="{{ url('sms/compose') }}" class="btn btn-primary btn-sm pull-right">{{_lang('New SMS')}}</a>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered">
					<thead>
						<th>{{ _lang('Date') }}</th>
						<th>{{ _lang('Mobile') }}</th>
						<th>{{ _lang('Message') }}</th>
						<th>{{ _lang('Sender') }}</th>
					</thead>
					<tbody>
						@foreach($messages as $data)
						<tr>
							<td>{{ date('d/M/Y - H:m', strtotime($data->created_at)) }}</td>
							<td>{{ $data->receiver }}</td>
							<td>{{ $data->message }}</td>
							<td>{{ $data->sender }}</td>
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
