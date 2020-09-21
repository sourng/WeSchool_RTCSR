@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{_lang('My Syllabus')}}</h4>
				</div>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Title')}}</th>
						<th>{{_lang('Description')}}</th>
						<th>{{_lang('Class')}}</th>
						<th>{{_lang('File')}}</th>
						<th style="width:120px">{{_lang('View Details')}}</th>
					</thead>
					<tbody>
						@foreach($syllabus AS $data)
						<tr>
							<td>{{$data->title}}</td>
							<td>{{substr(strip_tags($data->description),0,100)}}...</td>
							<td>{{$data->class_name}}</td>
							<td>{{$data->file}}</td>
							<td>
								<a href="{{ asset('public/uploads/files/syllabus/'.$data->file) }}" target="_blank" class="btn btn-info btn-xs rect-btn"><i class="fa fa-download" aria-hidden="true"></i></a>
								<a href="{{ url('student/view_syllabus/'.$data->id) }}" class="btn btn-primary btn-xs ajax-modal rect-btn" data-title="{{ _lang('View Syllabus') }}" data-fullscreen="true"><i class="fa fa-eye" aria-hidden="true"></i></a>	
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