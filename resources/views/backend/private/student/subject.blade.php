@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('My Subjects')}}
				</div>
			</div>
		 <div class="panel-body">
			<table class="table table-bordered data-table">
				<thead>
					<th>{{ _lang('Subject Name') }}</th>
					<th>{{ _lang('Subject Code') }}</th>
					<th>{{ _lang('Class') }}</th>
					<th>{{ _lang('Full mark') }}</th>
					<th>{{ _lang('Pass mark') }}</th>
				</thead>
				<tbody>
					@foreach($subjects AS $data)
					<tr>
						<td>{{ $data->subject_name }}</td>
						<td>{{ $data->subject_code }}</td>
						<td>{{ $data->class_name }}</td>
						<td>{{ $data->full_mark }}</td>
						<td>{{ $data->pass_mark }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection