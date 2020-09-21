@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{_lang('My Assignments')}}</h4>
				</div>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Title')}}</th>
						<th>{{_lang('Description')}}</th>
						<th>{{_lang('Subject')}}</th>
						<th>{{_lang('Details')}}</th>
					</thead>
					<tbody>
						@foreach($assignments AS $data)
						<tr>
							<td>{{$data->title}}</td>
							<td>{{substr(strip_tags($data->description),0,100)}}...</td>
							<td>{{$data->subject_name}}</td>
							<td>	
								@if($data->file)
								<li class="dropdown" style="display: inline;">
									<a href="#" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-download"></i>
									</a>
									<ul class="dropdown-menu">
										@if($data->file)
										<li><a href="{{ asset('public/uploads/files/assignments/'.$data->file) }}">{{ _lang('File 1') }}</a></li>
										@endif
										@if($data->file_2) 
										<li><a href="{{ asset('public/uploads/files/assignments/'.$data->file_2) }}">{{ _lang('File 2') }}</a></li>
										@endif
										@if($data->file_3) 
										<li><a href="{{ asset('public/uploads/files/assignments/'.$data->file_3) }}">{{ _lang('File 3') }}</a></li>
										@endif
										@if($data->file_4) 
										<li><a href="{{ asset('public/uploads/files/assignments/'.$data->file_4) }}">{{ _lang('File 4') }}</a></li>
										@endif
									</ul>
								</li>
								@endif
								<a href="{{ url('student/view_assignment/'.$data->id) }}" class="btn btn-primary btn-xs ajax-modal" data-title="{{ _lang('View Assignment') }}" data-fullscreen="true"><i class="fa fa-eye" aria-hidden="true"></i></a>
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

