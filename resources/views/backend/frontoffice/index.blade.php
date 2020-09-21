@extends('layouts.backend')

@section('content')
<div class="row">
	<strong class="panel-title" style="display: none;">{{ _lang('Front Office') }}</strong>
	<div class="col-md-12">
		<ul class="nav nav-tabs setting-tab">
			<li @if((Request::is('frontoffice'))OR(Request::is('frontoffice/admission_enquiries'))) class="active" @endif><a data-toggle="tab" href="#admission_enquiries" aria-expanded="true">{{ _lang('Admission Enquiry') }}</a></li>
			<li @if(Request::is('frontoffice/visitor_informations')) class="active" @endif><a data-toggle="tab" href="#visitor_informations" aria-expanded="false">{{ _lang('Visitor Information') }}</a></li>
			<li @if(Request::is('frontoffice/phone_call_logs')) class="active" @endif><a data-toggle="tab" href="#sms" aria-expanded="false">{{ _lang('Phone Call Logs') }}</a></li>
			<li @if(Request::is('frontoffice/complains')) class="active" @endif><a data-toggle="tab" href="#complains" aria-expanded="false">{{ _lang('Complain') }}</a></li>
			<li @if(Request::is('frontoffice/settings') || Request::is('frontoffice/settings/*')) class="active" @endif><a data-toggle="tab" href="#settings" aria-expanded="false">{{ _lang('Settings') }}</a></li>
		</ul>
		<div class="tab-content">
			<div id="admission_enquiries" class="tab-pane fade @if((Request::is('frontoffice'))OR(Request::is('frontoffice/admission_enquiries')))in active @endif">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="panel-title">{{ _lang('List') }}</strong>
						<a href="{{ route('admission_enquiries.create') }}" class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add') }}">
							<i class="fa fa-plus"></i> {{ _lang('Add New') }}
						</a>
					</div>
					<div class="panel-body no-export">		
						<table class="table table-bordered data-table admission_enquiries">
							<thead>
								<th>{{ _lang('Name') }}</th>
								<th>{{ _lang('Phone') }}</th>
								<th>{{ _lang('Source') }}</th>
								<th>{{ _lang('Enquiry Date') }}</th>
								<th>{{ _lang('Next Follow Up Date') }}</th>
								<th>{{ _lang('Action') }}</th>
							</thead>
							<tbody>
								@foreach($admission_enquiries AS $data)
								<tr>
									<td>{{ $data->first_name .' '. $data->last_name }}</td>
									<td>{{ $data->phone }}</td>
									<td>{{ $data->source }}</td>
									<td>{{ date('d M, Y',strtotime($data->date)) }}</td>
									<td>{{ date('d M, Y',strtotime($data->next_follow_up_date)) }}</td>
									<td>	
										<form action="{{route('admission_enquiries.destroy',$data->id)}}" method="post">
											<a href="{{route('admission_enquiries.show',$data->id)}}" class="btn btn-info btn-xs ajax-modal" data-title="Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a href="{{route('admission_enquiries.edit',$data->id)}}" class="btn btn-warning btn-xs ajax-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											{{ method_field('DELETE') }}
											@csrf
											<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="visitor_informations" class="tab-pane fade @if(Request::is('frontoffice/visitor_informations'))in active @endif">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="panel-title">{{ _lang('List') }}</strong>
						<a href="{{ route('visitor_informations.create') }}" class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add') }}">
							<i class="fa fa-plus"></i> {{ _lang('Add New') }}
						</a>
					</div>
					<div class="panel-body no-export">
						<table class="table table-bordered data-table">
							<thead>
								<th>{{ _lang('Purpose') }}</th>
								<th>{{ _lang('Name') }}</th>
								<th>{{ _lang('Phone') }}</th>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Action') }}</th>
							</thead>
							<tbody>
								@foreach($visitor_informations AS $data)
								<tr>
									<td>{{ $data->purpose }}</td>
									<td>{{ $data->name }}</td>
									<td>{{ $data->phone }}</td>
									<td>{{ date('d M, Y',strtotime($data->date)) }}</td>
									<td>	
										<form action="{{route('visitor_informations.destroy',$data->id)}}" method="post">
											<a href="{{route('visitor_informations.show',$data->id)}}" class="btn btn-info btn-xs ajax-modal" data-title="Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a href="{{route('visitor_informations.edit',$data->id)}}" class="btn btn-warning btn-xs ajax-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											{{ method_field('DELETE') }}
											@csrf
											<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>	
					</div>
				</div>
			</div>
			<div id="sms" class="tab-pane fade @if(Request::is('frontoffice/phone_call_logs'))in active @endif">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="panel-title">{{ _lang('List') }}</strong>
						<a href="{{ route('phone_call_logs.create') }}" class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add') }}">
							<i class="fa fa-plus"></i> {{ _lang('Add New') }}
						</a>
					</div>
					<div class="panel-body no-export">
						<table class="table table-bordered data-table">
							<thead>
								<th>{{ _lang('Name') }}</th>
								<th>{{ _lang('Phone') }}</th>
								<th>{{ _lang('Call Type') }}</th>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Start Time') }}</th>
								<th>{{ _lang('End Time') }}</th>
								<th>{{ _lang('Action') }}</th>
							</thead>
							<tbody>
								@foreach($phone_call_logs AS $data)
								<tr>
									<td>{{ $data->name }}</td>
									<td>{{ $data->phone }}</td>
									<td>{{ $data->call_type }}</td>
									<td>{{ date('d M, Y',strtotime($data->date)) }}</td>
									<td>{{ $data->start_time }}</td>
									<td>{{ $data->end_time }}</td>
									<td>	
										<form action="{{ route('phone_call_logs.destroy',$data->id) }}" method="post">
											<a href="{{ route('phone_call_logs.show',$data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a href="{{ route('phone_call_logs.edit',$data->id) }}" class="btn btn-warning btn-xs ajax-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											{{ method_field('DELETE') }}
											@csrf
											<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="complains" class="tab-pane fade @if(Request::is('frontoffice/complains'))in active @endif">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="panel-title">{{ _lang('List') }}</strong>
						<a href="{{ route('complains.create') }}" class="btn btn-primary btn-sm pull-right ajax-modal" data-title="Add">
							<i class="fa fa-plus"></i> {{ _lang('Add New') }}
						</a>
					</div>
					<div class="panel-body no-export">
						<table class="table table-bordered data-table">
							<thead>
								<th>{{ _lang('Complain Type') }}</th>
								<th>{{ _lang('Source') }}</th>
								<th>{{ _lang('Complain By') }}</th>
								<th>{{ _lang('Phone') }}</th>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Action') }}</th>
							</thead>
							<tbody>
								@foreach($complains AS $data)
								<tr>
									<td>{{ $data->complain_type }}</td>
									<td>{{ $data->source }}</td>
									<td>{{ $data->complain_by }}</td>
									<td>{{ $data->phone }}</td>
									<td>{{ date('d M, Y',strtotime($data->date)) }}</td>
									<td>	
										<form action="{{route('complains.destroy',$data->id)}}" method="post">
											@if($data->attach_document != '')
											<a href="{{ asset('public/uploads/files/complains/'.$data->attach_document) }}" class="btn btn-primary btn-xs"><i class="fa fa-download" aria-hidden="true"></i></a>
											@endif
											<a href="{{route('complains.show',$data->id)}}" class="btn btn-info btn-xs ajax-modal" data-title="Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a href="{{route('complains.edit',$data->id)}}" class="btn btn-warning btn-xs ajax-modal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											{{ method_field('DELETE') }}
											@csrf
											<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="settings" class="tab-pane fade @if(Request::is('frontoffice/settings') || Request::is('frontoffice/settings/*'))in active @endif">
				<div class="panel panel-default no-export">
					<div class="panel-heading"><span class="panel-title">{{ _lang('Picklist') }}</span>
						<select id="type" class="select_class pull-right" onchange="show(this);">
							<option value="">{{ _lang('Select Type') }}</option>
							<option>{{ _lang('Source') }}</option>
							<option>{{ _lang('Reference') }}</option>
							<option>{{ _lang('Purpose') }}</option>
							<option>{{ _lang('Complain') }}</option>
						</select>
						<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Picklist') }}" href="{{ url('settings/frontoffice') }}">{{ _lang('Add New') }}</a>
					</div>

					<div class="panel-body">
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ _lang('Type') }}</th>
									<th>{{ _lang('Value') }}</th>
									<th>{{ _lang('Action') }}</th>
								</tr>
							</thead>
							<tbody>

								@foreach($picklists as $picklist)
								<tr id="row_{{ $picklist->id }}">
									<td class='id'>{{ $picklist->id }}</td>
									<td class='type'>{{ $picklist->type }}</td>
									<td class='value'>{{ $picklist->value }}</td>

									<td>
										<form action="{{action('PicklistController@destroy', $picklist['id'])}}" method="post">
											<a href="{{ url('settings/frontoffice/'. $picklist->id) }}" data-title="{{ _lang('Update Picklist') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
											{{ csrf_field() }}
											<input name="_method" type="hidden" value="DELETE">
											<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
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
	</div>
</div>
@endsection

@section('js-script')
<script>
	$("#type").val("{{ $type }}");
	function show(elem){
		if($(elem).val() == ""){
			window.location = '{{ url('frontoffice/settings') }}';
		}else{
			window.location = '{{ url('frontoffice/settings') }}/' + $(elem).val();
		}
	}
</script>
@stop