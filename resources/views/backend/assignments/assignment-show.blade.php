@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Assignment')}}
				</div>
			</div>
			<table class="table table-striped table-bordered" width="100%">
				<tbody>
					<tr>
						<td>{{_lang('Title')}}</td>
						<td colspan="5"><b>{{$assignment->title}}</b></td>
					</tr>
					<tr>
						<td>{{_lang("Class")}}</td>
						<td><b>{{$assignment->class_name}}</b></td>
						<td>{{_lang("Section")}}</td>
						<td><b>{{$assignment->section_name}}</b></td>
						<td>{{_lang("Subject")}}</td>
						<td><b>{{$assignment->subject_name}}</b></td>
					</tr>
					<tr>
						<td colspan="6">{!! $assignment->description !!}</td>
					</tr>
					<tr>
						<td>{{_lang("Assignment Files")}}</td>
						<td><li class="dropdown" style="display: inline;">
							<a href="#" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
							{{ _lang('Click to Download') }}
							</a>
							<ul class="dropdown-menu">
								@if($assignment->file)
								<li><a href="{{ asset('public/uploads/files/assignments/'.$assignment->file) }}">{{$assignment->file}}</a></li>
								@endif
								@if($assignment->file_2) 
								<li><a href="{{ asset('public/uploads/files/assignments/'.$assignment->file_2) }}">{{$assignment->file_2}}</a></li>
								@endif
								@if($assignment->file_3) 
								<li><a href="{{ asset('public/uploads/files/assignments/'.$assignment->file_3) }}">{{$assignment->file_3}}</a></li>
								@endif
								@if($assignment->file_4) 
								<li><a href="{{ asset('public/uploads/files/assignments/'.$assignment->file_4) }}">{{$assignment->file_4}}</a></li>
								@endif
							</ul>
						</li>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
@endsection