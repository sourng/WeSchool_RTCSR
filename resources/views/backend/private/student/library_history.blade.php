@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('My Library History') }}
				</div>
			</div>
			<div class="panel-body">
				@if( !empty($issues) )
				<div class="col-md-12">
					<div class="panel-heading text-center">
						<div class="panel-title" >
							{{ _lang('Book Issues Of') }}<br>
							{{ _lang('Member Name - ') }}{{ $member->name }}<br>
							{{ _lang('Library Id - ') }}{{ $member->library_id }}<br>
						</div>
					</div>

					<table class="table table-bordered data-table">
						<thead>
							<tr>
								<th>{{_lang('Book Name')}}</th>
								<th>{{_lang('Category')}}</th>
								<th>{{_lang('Issue Date')}}</th>
								<th>{{_lang('Due Date')}}</th>
								<th>{{_lang('Return Date')}}</th>
								<th>{{_lang('Status')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($issues AS $data)
							<tr>
								<td>{{$data->name}}</td>
								<td>{{$data->category_name}}</td>
								<td>{{date('d/ M/ Y', strtotime($data->issue_date))}}</td>
								<td>{{date('d/ M/ Y', strtotime($data->due_date))}}</td>
								<td>@if($data->return_date != '' ){{date('d-M-Y', strtotime($data->return_date))}}@endif</td>
								<td>@if($data->status == '1') <span class="badge badge-danger">{{ _lang('Not Return Yet') }}</span> @else <span class="badge badge-success">{{ _lang('Returned') }}</span> @endif</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@else
					<h5 class="text-center">{{ _lang('Sorry, No Records Found !') }}</h5>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection