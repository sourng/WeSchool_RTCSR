@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Syllabus')}}
				</div>
			</div>
			<table class="table table-striped table-bordered" width="100%">
				<tbody>
					<tr>
						<td>{{_lang('Title')}}</td>
						<td>{{$syllabus->title}}</td>
					</tr>
					<tr>
						<td>Description</td>
						<td>{!! $syllabus->description !!}</td>
					</tr>
					<tr>
						<td>{{_lang("Class")}}</td>
						<td>{{$syllabus->class_name}}</td>
					</tr>
					<tr>
						<td>{{_lang("File")}}</td>
						<td>
							<a class="btn btn-info btn-sm" href="{{ asset('public/uploads/files/syllabus/'.$syllabus->file) }}">{{ _lang('Click to Download') }}</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection